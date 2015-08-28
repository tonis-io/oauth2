<?php
namespace Tonis\OAuth2;

use OAuth2\Server as OAuth2Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OAuthMiddleware
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
        if ($request->getUri()->getPath() === '/token' && $request->getMethod() == 'POST') {
            return (new Action\Token($this->server))->__invoke($request, $response, $next);
        } elseif ($request->getUri()->getPath() == '/test' && $request->getMethod() == 'GET') {
            // For testing we'll use the TokenMiddleware and then have it call the Test action.
            // This will set the token attribute on the request automatically!
            $token  = new TokenMiddleware($this->server);
            $action = new Action\Test();

            return $token->__invoke($request, $response, $action);
        }
        return $next($request, $response);
    }
}