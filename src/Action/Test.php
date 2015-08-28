<?php
namespace Tonis\OAuth2\Action;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class Test
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $token = $request->getAttribute('access_token');

        if ($token instanceof AccessTokenEntity) {
            $session = $token->getSession();
            $client  = $session->getClient();

//            $scopes = [];
//            foreach ($session->getScopes() as $scope) {
//                $scopes[] = [
//                    'id'          => $scope->getId(),
//                    'description' => $scope->getDescription()
//                ];
//            }

            $data  = [
                'access_token' => [
                    'id'          => $token->getId(),
                    'expire_time' => $token->getExpireTime(),
                ],
                'client' => [
                    'id'           => $client->getId(),
                    'secret'       => $client->getSecret(),
                    'name'         => $client->getName(),
                    'redirect_uri' => $client->getRedirectUri(),
                ],
                'session' => [
                    'id'         => $session->getId(),
                    'owner_id'   => $session->getOwnerId(),
                    'owner_type' => $session->getOwnerType(),
                ],
//                'scopes' => $scopes
            ];
        } else {
            $data = ['error' => 'The authorization server denied the request'];
        }

        return new JsonResponse($data);
    }
}
