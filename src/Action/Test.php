<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\ResourceServer;
use Tonis\Http\Request;
use Tonis\Http\Response;
use Tonis\Middleware;

final class Test implements Middleware\RouterInterface
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
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        try {
            $this->server->isValidRequest(false);
        } catch (\Exception $ex) {
            return $response
                ->withStatus(403)
                ->json([
                    'errors' => [
                        'title'   => $ex->getMessage(),
                        'details' => $ex->getTrace(),
                    ]
                ]);
        }

        $token   = $this->server->getAccessToken();
        $session = $token->getSession();
        $client  = $session->getClient();

        $scopes = [];
        foreach ($token->getScopes() as $scope) {
            $scopes[] = $scope->getId();
        }

        return $response->json([
            'client_id'    => $client->getId(),
            'client_name'  => $client->getName(),
            'owner_type'   => $session->getOwnerType(),
            'owner_id'     => $session->getOwnerId(),
            'access_token' => $token->getId(),
            'expire_time'  => $token->getExpireTime(),
            'scopes'       => $scopes
        ]);
    }
}
