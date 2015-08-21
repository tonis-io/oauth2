<?php
namespace Tonis\OAuth2\Action;

use OAuth2\Request as OAuth2Request;
use OAuth2\Server;
use Tonis\Http\Request;
use Tonis\Http\Response;
use Tonis\Middleware;
use Tonis\OAuth2\Util;

final class Token implements Middleware\RouterInterface
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
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $oauth2request = Util::convertRequestFromPsr7($request);

        return Util::convertResponseToTonisJson(
            $this->server->handleTokenRequest($oauth2request),
            $response
        );
    }
}
