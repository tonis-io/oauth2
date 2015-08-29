<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use OAuth2\Server;
use OAuth2\Storage;
use PDO;
use Tonis\OAuth2\Doctrine\FileLocator;

class OAuthFactory
{
    /**
     * Creates a default instance for PDO usage.
     *
     * @param PDO   $pdo
     * @param array $options
     * @param array $grants
     * @return Server
     */
    public static function createForPDO(PDO $pdo, array $options = [], array $grants = [])
    {
        return new Server(new Storage\Pdo($pdo), $options, $grants);
    }

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
        return new Server(
            [
                'access_token'       => $entityManager->getRepository(Entity\AccessToken::class),
                //'authorization_code' => $entityManager->getRepository(Entity\AuthCode::class),
                'client_credentials' => $entityManager->getRepository(Entity\Client::class),
                'client'             => $entityManager->getRepository(Entity\Client::class),
                //'refresh_token'      => $entityManager->getRepository(Entity\RefreshToken::class),
                'user_credentials'   => $entityManager->getRepository(Entity\User::class),
                //'user_claims'        => 'OAuth2\OpenID\Storage\UserClaimsInterface',
                //'public_key'         => 'OAuth2\Storage\PublicKeyInterface',
                //'jwt_bearer'         => 'OAuth2\Storage\JWTBearerInterface',
                'scope'              => $entityManager->getRepository(Entity\Scope::class),
            ],
            $options,
            $grants
        );
    }

    /**
     * Prepares an EntityManager by adding the Doctrine driver and Entity Resolver. Assumes that any custom
     * entities are also exclusions for the entity resolver.
     *
     * @param EntityManager $entityManager
     * @param array         $entities
     */
    public static function prepareEntityManager(EntityManager $entityManager, array $entities)
    {
        self::addDoctrineDriver($entityManager, $entities);
        self::addDoctrineEntityResolver($entityManager, $entities);
    }

    /**
     * Adds the default Tonis\OAuth2 driver to the input entity manager. Drivers can be
     * setup manually if the consumer wishes to overwrite anything.
     *
     * The EntityManager MUST have a driver chain set as the metadata driver or this
     * method will throw an exception.
     *
     * @param EntityManager $entityManager
     * @param array         $exclusions
     */
    public static function addDoctrineDriver(
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
     * @param EntityManager $entityManager
     * @param array         $entities
     */
    public static function addDoctrineEntityResolver(EntityManager $entityManager, array $entities = [])
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

        $entityManager->getEventManager()->addEventSubscriber($resolver);
    }

    /**
     * Disallow construction.
     */
    private function __construct()
    {
    }
}