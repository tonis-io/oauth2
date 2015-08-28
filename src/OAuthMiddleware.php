<?php
namespace Tonis\OAuth2;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OAuthMiddleware
{
    /** @var AuthorizationServer */
    private $authorizationServer;
    /** @var ResourceServer */
    private $resourceServer;

    /**
     * @param AuthorizationServer $authorizationServer
     * @param ResourceServer      $resourceServer
     */
    public function __construct(
        AuthorizationServer $authorizationServer,
        ResourceServer $resourceServer
    ) {
        $this->authorizationServer = $authorizationServer;
        $this->resourceServer      = $resourceServer;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($request->getUri()->getPath() === '/token' && $request->getMethod() == 'POST') {
            return (new Action\Token($this->authorizationServer))->__invoke($request, $response, $next);
        } elseif ($request->getUri()->getPath() == '/test' && $request->getMethod() == 'GET') {
            // For testing we'll use the TokenMiddleware and then have it call the Test action.
            // This will set the token attribute on the request automatically!
            $token  = new TokenMiddleware($this->resourceServer);
            $action = new Action\Test();

            return $token->__invoke($request, $response, $action);
        }
        return $next($request, $response);
    }
}