<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\InvalidRequestException;
use Mockery as m;
use Tonis\Http\Response;
use Tonis\Test\TonisPsr7Trait;

/**
 * @covers \Tonis\OAuth2\Action\AccessToken
 */
class AccessTokenTest extends \PHPUnit_Framework_TestCase
{
    use TonisPsr7Trait;

    /** @var AccessToken */
    private $action;
    /** @var AuthorizationServer|\Mockery\MockInterface */
    private $server;

    protected function setUp()
    {
        $this->server = m::mock(AuthorizationServer::class);
        $this->action = new AccessToken($this->server);
    }

    public function testHandlesException()
    {
        $ex = new InvalidRequestException('grant_type');

        $this
            ->server
            ->shouldReceive('issueAccessToken')
            ->once()
            ->andThrow($ex);

        $action = $this->action;
        /** @var Response $result */
        $result = $action($this->newTonisRequest('/'), $this->newTonisResponse());

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(400, $result->getStatusCode());
        $this->assertContains('grant_type', (string) $result->getBody());
    }

    public function testInvoke()
    {
        $this
            ->server
            ->shouldReceive('issueAccessToken')
            ->once()
            ->andReturn(['accessToken' => 'foo']);

        $action   = $this->action;
        /** @var Response $response */
        $response = $action($this->newTonisRequest('/'), $this->newTonisResponse());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertContains('foo', (string) $response->getBody());
    }
}