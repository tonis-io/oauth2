<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\ResourceServer;

class OAuth2Provider extends ServiceProvider
{
    protected $provides = [
        AuthorizationServer::class,
        ResourceServer::class,
        Storage\Session::class,
        Storage\AccessToken::class,
        Storage\Client::class,
        Storage\Scope::class
    ];

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->singleton(Storage\Session::class, function () {
            $em = $this->getContainer()->get(EntityManager::class);
            return new Storage\Session($em->getRepository(Entity\Session::class));
        });

        $container->singleton(Storage\AccessToken::class, function () {
            $em = $this->getContainer()->get(EntityManager::class);
            return new Storage\AccessToken($em->getRepository(Entity\AccessToken::class));
        });

        $container->singleton(Storage\Client::class, function () {
            $em = $this->getContainer()->get(EntityManager::class);
            return new Storage\Client($em->getRepository(Entity\Client::class));
        });

        $container->singleton(Storage\Scope::class, function () {
            $em = $this->getContainer()->get(EntityManager::class);
            return new Storage\Scope($em->getRepository(Entity\Scope::class));
        });

        $container->singleton(AuthorizationServer::class, function () {
            $container = $this->getContainer();
            $server    = new AuthorizationServer;

            $server->setSessionStorage($container->get(Storage\Session::class));
            $server->setAccessTokenStorage($container->get(Storage\AccessToken::class));
            $server->setClientStorage($container->get(Storage\Client::class));
            $server->setScopeStorage($container->get(Storage\Scope::class));

            $clientCredentials = new ClientCredentialsGrant();
            $server->addGrantType($clientCredentials);

            return $server;
        });

        $container->singleton(ResourceServer::class, function () {
            $container = $this->getContainer();

            return new ResourceServer(
                $container->get(Storage\Session::class),
                $container->get(Storage\AccessToken::class),
                $container->get(Storage\Client::class),
                $container->get(Storage\Scope::class)
            );
        });
    }
}
