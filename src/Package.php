<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use Tonis\App;
use Tonis\DoctrineORM\Exception\InvalidDriver;
use Tonis\PackageInterface;
use Tonis\Router\Group;

final class Package implements PackageInterface
{
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

        $router = $app->router();
        $router->group('/oauth', function (Group $oauth) use ($container) {
            $oauth->get('/test', Action\Test::class);
            $oauth->post('/access_token', Action\AccessToken::class);
        });

        $app->add($router);
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

        $oauth2driver = $em->getConfiguration()->newDefaultAnnotationDriver(__DIR__ . '/Entity');
        $driver->addDriver($oauth2driver, __NAMESPACE__);
    }
}
