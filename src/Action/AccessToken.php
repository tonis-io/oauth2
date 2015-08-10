<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\AuthorizationServer;
use Tonis\Http\Request;
use Tonis\Http\Response;

class AccessToken
{
    /** @var AuthorizationServer */
    private $server;

    /**
     * @param AuthorizationServer $server
     */
    public function __construct(AuthorizationServer $server)
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
            $result = $this->server->issueAccessToken();
        } catch (\Exception $ex) {
            $result = ['error' => $ex->getMessage()];
        }

        return $response->json($result);
    }
}
