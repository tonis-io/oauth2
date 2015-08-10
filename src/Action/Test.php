<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\ResourceServer;
use Tonis\Http\Request;
use Tonis\Http\Response;

class Test
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
        } catch (AccessDeniedException $ex) {
            return $response->json(['error' => $ex->getMessage()]);
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
