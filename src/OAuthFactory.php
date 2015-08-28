<?php
namespace Tonis\OAuth2;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;

class OAuthFactory
{
    /**
     * Adds the default Tonis\OAuth2 driver to the input entity manager. Drivers can be
     * setup manually if the consumer wishes to overwrite anything.
     *
     * The EntityManager MUST have a driver chain set as the metadata driver or this
     * method will throw an exception.
     *
     * @param EntityManager $entityManager
     */
    public static function addDefaultDriver(EntityManager $entityManager)
    {
        $driver = $entityManager->getConfiguration()->getMetadataDriverImpl();
        if (!$driver instanceof MappingDriverChain) {
            throw new \LogicException('Tonis\OAuth2 requires a driver chain');
        }

        $driver->addDriver(new YamlDriver([__DIR__ . '/../config']), 'League\\OAuth2\\Server\\Entity');
    }

    /**
     * Prepares the entity resolver for custom entities (optional). By default will
     * use the built in entities provided by Tonis\OAuth2.
     *
     * The user MUST specify their own OAuthUserInterface implementation.
     *
     * @param array $entities
     * @return ResolveTargetEntityListener
     */
    public static function getEntityResolver(array $entities)
    {
        $entities = array_merge([
            Entity\OAuthAccessTokenInterface::class => Entity\OAuthAccessToken::class,
            Entity\OAuthClientInterface::class      => Entity\OAuthClient::class,
            Entity\OAuthUserInterface::class        => null,
        ], $entities);

        if (null === $entities[Entity\OAuthUserInterface::class]) {
            throw new \LogicException(
                sprintf('You must supply your own %simplementation', Entity\OAuthUserInterface::class)
            );
        }

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