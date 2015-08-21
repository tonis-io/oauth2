<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Tonis\App;
use Tonis\PackageInterface;
use Tonis\Router\Group;
use Tonis\OAuth2\Entity;

final class Package implements PackageInterface
{
    /** @var array */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $defaults = [
            'entity_namespace' => __NAMESPACE__,
            'entity_path'      => __DIR__ . '/Entity',

            'entities' => [
                Entity\OAuthAccessTokenInterface::class => Entity\OAuthAccessToken::class,
                Entity\OAuthClientInterface::class      => Entity\OAuthClient::class,
                Entity\OAuthUserInterface::class        => Entity\OAuthUser::class,
            ],

            'register_user_entity' => true
        ];
        $this->config = array_replace_recursive($defaults, $config);
    }

    /**
     * {@inheritDoc}
     */
    public function register(App $app)
    {
        /** @var \Tonis\Container $container */
        $container = $app->getContainer();
        $container->addServiceProvider(new OAuth2Provider());

        $this->registerDriver($container->get(EntityManager::class));
        $this->registerResolvers($container->get(EntityManager::class));

        $router = $app->router();
        $router->group('/oauth', function (Group $oauth) use ($container) {
            $oauth->get('/test', Action\Test::class);
            $oauth->post('/token', Action\Token::class);
            $oauth->get('/authorize', Action\Authorize::class);
        });

        $app->add($router);
    }

    /**
     * Registers entities with a ResolveTargetEntityListener so that consumers can modify entities
     * if they need to (e.g., to change the table name).
     *
     * @param EntityManager $em
     */
    private function registerResolvers(EntityManager $em)
    {
        $resolver = new ResolveTargetEntityListener();

        foreach ($this->config['entities'] as $originalEntity => $newEntity) {
            $resolver->addResolveTargetEntity($originalEntity, $newEntity, []);
        }
        $em->getEventManager()->addEventSubscriber($resolver);
    }

    /**
     * Adds an annotation driver to the default Doctrine driver chain.
     *
     * @param EntityManager $em
     */
    private function registerDriver(EntityManager $em)
    {
        /** @var \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain $driver */
        $driver = $em->getConfiguration()->getMetadataDriverImpl();

        $dirs = [__DIR__ . '/../config'];
        if ($this->config['register_user_entity']) {
            $dirs[] = __DIR__ . '/../config/user';
        }

        $driver->addDriver(new YamlDriver($dirs), $this->config['entity_namespace']);
    }
}
