<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use OAuth2\Server;
use OAuth2\Storage;
use Tonis\OAuth2\Doctrine\FileLocator;

class OAuthFactory
{
    /**
     * Creates a default instance based on DoctrineORM. This adds the YAML driver
     * for the entity metadata, sets up the entity resolver so you can customize any
     * entities, and sets the storage using the same PDO connection as the Entity Manager.
     *
     * @param EntityManager $entityManager
     * @param array         $options
     * @param array         $grants
     * @return Server
     */
    public static function createForDoctrineORM(
        EntityManager $entityManager,
        array $options = [],
        array $grants = []
    ) {
        $storage = new Storage\Pdo(
            $entityManager->getConnection()->getWrappedConnection(),
            [
                'client_table'        => $entityManager->getClassMetadata(Entity\Client::class)->getTableName(),
                'access_token_table'  => $entityManager->getClassMetadata(Entity\AccessToken::class)->getTableName(),
                'refresh_token_table' => 'oauth_refresh_token',
                'code_table'          => 'oauth_auth_code',
                'user_table'          => $entityManager->getClassMetadata(Entity\User::class)->getTableName(),
                'jwt_table'           => 'oauth_jwt',
                'jti_table'           => 'oauth_jti',
                'scope_table'         => $entityManager->getClassMetadata(Entity\Scope::class)->getTableName(),
                'public_key_table'    => 'oauth_public_key',
            ]
        );
        $server  = new Server($storage, $options, $grants);

        return $server;
    }

    /**
     * Adds the default Tonis\OAuth2 driver to the input entity manager. Drivers can be
     * setup manually if the consumer wishes to overwrite anything.
     *
     * The EntityManager MUST have a driver chain set as the metadata driver or this
     * method will throw an exception.
     *
     * @param EntityManager $entityManager
     */
    public static function addDefaultDriver(
        EntityManager $entityManager,
        array $exclusions = []
    ) {
        $driver = $entityManager->getConfiguration()->getMetadataDriverImpl();
        if (!$driver instanceof MappingDriverChain) {
            throw new \LogicException('Tonis\OAuth2 requires a driver chain');
        }

        $locator = new FileLocator([__DIR__ . '/../config'], '.dcm.yml', $exclusions);
        $yaml    = new YamlDriver($locator);

        $driver->addDriver($yaml, __NAMESPACE__ . '\\Entity');
    }

    /**
     * Prepares the entity resolver for custom entities (optional). By default will
     * use the built in entities provided by Tonis\OAuth2.
     *
     * @param array $entities
     * @return ResolveTargetEntityListener
     */
    public static function getEntityResolver(array $entities = [])
    {
        $entities = array_merge([
            Entity\AccessToken::class => Entity\AccessToken::class,
            Entity\Client::class      => Entity\Client::class,
            Entity\User::class        => Entity\User::class,
        ], $entities);

        $resolver = new ResolveTargetEntityListener();
        foreach ($entities as $originalEntity => $newEntity) {
            $resolver->addResolveTargetEntity($originalEntity, $newEntity, []);
        }

        return $resolver;
    }

    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }
}