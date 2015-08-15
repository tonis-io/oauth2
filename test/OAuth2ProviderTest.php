<?php
namespace Tonis\OAuth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\ResourceServer;
use Tonis\Container;
use Tonis\DoctrineORM\DoctrineProvider;

/**
 * @covers \Tonis\OAuth2\OAuth2Provider
 */
class OAuth2ProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var OAuth2Provider */
    private $provider;
    /** @var Container */
    private $container;

    protected function setUp()
    {
        $doctrine = new DoctrineProvider([
            'connection' => [
                'driver' => 'pdo_sqlite',
                'memory' => true
            ]
        ]);

        $container = new Container();
        $container->addServiceProvider($doctrine);

        $provider  = new OAuth2Provider();
        $provider->setContainer($container);
        $provider->register();

        $this->container = $container;
        $this->provider  = $provider;
    }

    /**
     * @dataProvider instanceProvider
     * @param string $class
     */
    public function testInstances($class)
    {
        $this->assertInstanceOf($class, $this->container->get($class));
    }

    public function testRegister()
    {
        $container = $this->container;
        $provides = [
            AuthorizationServer::class,
            ResourceServer::class,
            Storage\Session::class,
            Storage\AccessToken::class,
            Storage\Client::class,
            Storage\Scope::class
        ];

        foreach ($provides as $class) {
            $this->assertTrue($container->has($class));
        }
    }

    public function instanceProvider()
    {
        return [
            [Storage\Session::class],
            [Storage\AccessToken::class],
            [Storage\Client::class],
            [Storage\Scope::class],
            [AuthorizationServer::class],
            [ResourceServer::class]
        ];
    }
}