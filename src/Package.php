<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Tonis\App;
use Tonis\PackageInterface;
use Tonis\Router\Group;
use Tonis\OAuth2\Entity;

final class Package implements PackageInterface
{
    /** @var array */
    private $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'entity_path' => __DIR__ . '/Entity',
            'entities' => [
                Entity\AccessTokenInterface::class    => Entity\AccessToken::class,
                Entity\AuthCodeInterface::class       => Entity\AuthCode::class,
                Entity\ClientInterface::class         => Entity\Client::class,
                Entity\ClientRedirectInterface::class => Entity\ClientRedirect::class,
                Entity\RefreshTokenInterface::class   => Entity\RefreshToken::class,
                Entity\ScopeInterface::class          => Entity\Scope::class,
                Entity\SessionInterface::class        => Entity\Session::class,
            ]
        ];
        $this->config = array_replace_recursive($defaults, $config);
    }

    /**
     * @param App $app
     * @return void
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
            $oauth->post('/access_token', Action\AccessToken::class);
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

        $oauth2driver = $em->getConfiguration()->newDefaultAnnotationDriver($this->config['entity_path']);
        $driver->addDriver($oauth2driver, __NAMESPACE__);
    }
}
