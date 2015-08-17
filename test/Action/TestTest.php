<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Exception\InvalidRequestException;
use Tonis\Http\Response;
use Tonis\OAuth2\TestAsset\ResourceServer;
use Tonis\Test\TonisPsr7Trait;

/**
 * @covers \Tonis\OAuth2\Action\TestTest
 */
class TestTest extends \PHPUnit_Framework_TestCase
{
    use TonisPsr7Trait;

    /** @var Test */
    private $action;
    /** @var ResourceServer */
    private $server;

    protected function setUp()
    {
        $this->server = new ResourceServer();
        $this->action = new Test($this->server);
    }

    public function testHandlesException()
    {
        $action = $this->action;

        /** @var Response $response */
        $response = $action($this->newTonisRequest('/'), $this->newTonisResponse());

        $this->assertSame(403, $response->getStatusCode());
        $this->assertContains('access token', $response->getBody()->__toString());
    }

    public function testInvoke()
    {
        $this->server->getRequest()->headers->add(['Authorization' => 'Bearer foo']);

        $action = $this->action;
        /** @var Response $response */
        $response = $action($this->newTonisRequest('/'), $this->newTonisResponse());

        $this->assertSame(200, $response->getStatusCode());
        $this->assertContains('foo', $response->getBody()->__toString());
    }
}