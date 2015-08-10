<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Tonis\App;
use Tonis\DoctrineORM\Exception\InvalidDriver;
use Tonis\OAuth2\Entity\ClientInterface;
use Tonis\PackageInterface;
use Tonis\Router\Group;

class Package implements PackageInterface
{
    /** @var array */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
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
        $this->registerResolver($container->get(EntityManager::class));

        $router = $app->router();
        $router->group('/oauth', function (Group $oauth) use ($container) {
            $oauth->get('/test', Action\Test::class);
            $oauth->post('/access_token', Action\AccessToken::class);
        });

        $app->add($router);
    }

    private function registerDriver(EntityManager $em)
    {
        $driver = $em->getConfiguration()->getMetadataDriverImpl();

        if (!$driver instanceof MappingDriverChain) {
            throw new InvalidDriver('Expected driver chain; setup DoctrineORM package manually');
        }

        $oauth2driver = $em->getConfiguration()->newDefaultAnnotationDriver(__DIR__ . '/Entity');
        $driver->addDriver($oauth2driver, __NAMESPACE__);
    }

    private function registerResolver(EntityManager $em)
    {
        $resolver = new ResolveTargetEntityListener();
        $resolver->addResolveTargetEntity(ClientInterface::class, $this->config['client_entity'], []);

        $em->getEventManager()->addEventListener(Events::loadClassMetadata, $resolver);
    }
}
