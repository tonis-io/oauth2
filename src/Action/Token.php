<?php
namespace Tonis\OAuth2\Action;

use Exception;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class Token
{
    /**
     * @var AuthorizationServer
     */
    private $server;

    /**
     * @param AuthorizationServer $server
     */
    public function __construct(AuthorizationServer $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            $data = $this->server->issueAccessToken();
        } catch (Exception $ex) {
            $data = ['error' => $ex->getMessage()];
        }

        return new JsonResponse($data);
    }
}
