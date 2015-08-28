<?php
namespace Tonis\OAuth2;

use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class TokenMiddleware
{
    /** @var ResourceServer */
    private $server;

    /**
     * @param ResourceServer $server
     */
    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            $this->server->isValidRequest(false);
            $request = $request->withAttribute('access_token', $this->server->getAccessToken());
        } catch (\Exception $ex) {
            return new JsonResponse(['error' => $ex->getMessage()]);
        }

        return $next($request, $response);
    }
}