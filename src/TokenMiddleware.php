<?php
namespace Tonis\OAuth2;

use OAuth2\Server as OAuth2Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class TokenMiddleware
{
    /** @var OAuth2Server */
    private $server;

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
            if (!$this->server->verifyResourceRequest($oauth2request)) {
                return Util::convertResponseToPsr7($this->server->getResponse(), $response);
            }
            $request = $request->withAttribute('access_token', $this->server->getAccessTokenData($oauth2request));
        } catch (\Exception $ex) {
            return new JsonResponse(
                [
                    'error'             => $ex->getMessage(),
                    'error_description' => $ex->getMessage(),
                ],
                500
            );
        }

        return $next($request, $response);
    }
}