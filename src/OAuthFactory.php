<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Tonis\App;
use Tonis\Container\PimpleContainer;

final class OAuthFactory
{
    /**
     * Creates the OAuth app.
     *
     * @param EntityManager $entityManager
     * @param array         $config
     * @return App
     */
    public static function create(EntityManager $entityManager, array $config)
    {
        $defaults = [
            'entity_namespace' => __NAMESPACE__,
            'entity_path'      => __DIR__ . '/Entity',

            'entities' => [
                Entity\OAuthAccessTokenInterface::class => Entity\OAuthAccessToken::class,
                Entity\OAuthClientInterface::class      => Entity\OAuthClient::class,
                Entity\OAuthUserInterface::class        => null,
            ],
        ];

        // config from sane defaults with overrides
        $config = array_replace_recursive($defaults, $config);

        // ensure entity manager is setup properly
        self::prepareEntityManager($entityManager, $config);

        // create the OAuth2 specific container (pimple, light weight and fast)
        $pimple = new PimpleContainer();
        $pimple->register(new ServiceProvider($entityManager));

        // create the OAuth2 specific application that can be mounted at any path
        $app = new App($pimple);
        $app->post('/token', Action\Token::class);

        return $app;
    }

    /**
     * Prepare the EntityManager for OAuth entities and resolver.
     *
     * @param EntityManager $entityManager
     * @param array         $config
     */
    protected static function prepareEntityManager(EntityManager $entityManager, array $config)
    {
        $resolver = new ResolveTargetEntityListener();

        foreach ($config['entities'] as $originalEntity => $newEntity) {
            $resolver->addResolveTargetEntity($originalEntity, $newEntity, []);
        }

        $entityManager->getEventManager()->addEventSubscriber($resolver);

        $driver = $entityManager->getConfiguration()->getMetadataDriverImpl();

        if (!$driver instanceof MappingDriverChain) {
            throw new \LogicException('OAuth2 requires a driver chain on the Entity Manager');
        }

        $driver->addDriver(new YamlDriver([__DIR__ . '/../config']), $config['entity_namespace']);
    }

    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }
}