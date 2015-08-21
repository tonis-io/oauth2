<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider;
use OAuth2\Server;

final class OAuth2Provider extends ServiceProvider
{
    protected $provides = [
        Repository\OAuthAccessToken::class,
        Server::class
    ];

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(Repository\OAuthAccessToken::class, function () use ($container) {
            return $container->get(EntityManager::class)->getRepository(Entity\OAuthAccessTokenInterface::class);
        });

        $container->add(Server::class, function () use ($container) {
            $em = $container->get(EntityManager::class);

            $server = new Server([
                'access_token'       => $em->getRepository(Entity\OAuthAccessTokenInterface::class),
                'client_credentials' => $em->getRepository(Entity\OAuthClientInterface::class),
                'user_credentials'   => $em->getRepository(Entity\OAuthUserInterface::class),
            ]);

            return $server;
        });
    }
}
