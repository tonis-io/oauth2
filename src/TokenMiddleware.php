<?php
namespace Tonis\OAuth2;

use Doctrine\ORM\EntityRepository;
use OAuth2\Server;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TokenMiddleware
{
    /** @var Repository\OAuthUser */
    private $repository;
    /** @var Server */
    private $server;

    /**
     * @param EntityRepository $repository
     * @param Server           $server
     */
    public function __construct(
        EntityRepository $repository,
        Server $server
    ) {
        $this->repository = $repository;
        $this->server     = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $oauth2request = Util::convertRequestFromPsr7($request);

        if (!$this->server->verifyResourceRequest($oauth2request)) {
            return Util::convertResponseToPsr7($this->server->getResponse(), $response);
        }

        $token   = $this->server->getAccessTokenData($oauth2request);
        $request = $request
            ->withAttribute('access_token', $token)
            ->withAttribute('user', $this->repository->find($token['user_id']));

        return $next($request, $response);
    }
}