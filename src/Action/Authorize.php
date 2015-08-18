<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthException;
use Tonis\Http\Request;
use Tonis\Http\Response;
use Tonis\Middleware;

final class Authorize implements Middleware\RouterInterface
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
            $params = $this->server->getGrantType('authorization_code')->checkAuthorizeParams();
        } catch (OAuthException $ex) {
            if ($ex->shouldRedirect()) {
                return $response->redirect($ex->getRedirectUri());
            }

            return $response
               ->withStatus($ex->httpStatusCode)
                ->json([
                    'errors' => [
                        'title'   => $ex->errorType,
                        'details' => $ex->getMessage(),
                    ],
                ]);
        }

        echo 'wat';exit;
    }
}
