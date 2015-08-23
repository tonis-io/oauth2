<?php
namespace Tonis\OAuth2\Action;

use OAuth2\Request as OAuth2Request;
use OAuth2\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tonis\MiddlewareInterface;
use Tonis\OAuth2\Util;

final class Token implements MiddlewareInterface
{
    /** @var Server */
    private $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return Util::convertResponseToPsr7(
            $this->server->handleTokenRequest(Util::convertRequestFromPsr7($request)),
            $response
        );
    }
}
