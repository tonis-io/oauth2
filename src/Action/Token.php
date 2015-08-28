<?php
namespace Tonis\OAuth2\Action;

use Exception;
use OAuth2\Server as OAuth2Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tonis\OAuth2\Util;
use Zend\Diactoros\Response\JsonResponse;

final class Token
{
    /**
     * @param OAuth2Server $server
     */
    public function __construct(OAuth2Server $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            $oauth2request  = Util::convertRequestFromPsr7($request);
            $oauth2response = $this->server->handleTokenRequest($oauth2request);
            $response       = Util::convertResponseToPsr7($oauth2response, $response);
        } catch (Exception $ex) {
            $response = new JsonResponse([
                'error'             => 'Internal server error',
                'error_description' => $ex->getMessage(),
            ]);
        }

        return $response;
    }
}
