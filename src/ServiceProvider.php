<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use OAuth2\Server;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /** @var Entitymanager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function register(Container $pimple)
    {
        $pimple[Server::class] = function () {
            return new Server([
                'access_token'       => $this->entityManager->getRepository(Entity\OAuthAccessTokenInterface::class),
                'client_credentials' => $this->entityManager->getRepository(Entity\OAuthClientInterface::class),
                'user_credentials'   => $this->entityManager->getRepository(Entity\OAuthUserInterface::class),
            ]);
        };

        $pimple[Action\Token::class] = function () use ($pimple) {
            return new Action\Token($pimple[Server::class]);
        };
    }
}