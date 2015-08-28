<?php
namespace Tonis\OAuth2\Doctrine\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\AccessTokenInterface;
use Tonis\OAuth2\Entity;

class AccessToken extends EntityRepository implements AccessTokenInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAccessToken($oauthToken)
    {
        $token = $this->find($oauthToken);

        if ($token instanceof Entity\AccessToken) {
            return [
                'expires'   => $token->expires->getTimestamp(),
                'client_id' => $token->client ? $token->client->id : null,
                'user_id'   => $token->user ? $token->user->id : null,
                'scope'     => $token->scope,
            ];
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setAccessToken($oauthToken, $clientId, $userId, $expires, $scope = null)
    {
        $expires = new DateTime("@{$expires}");
        $token   = $this->find($oauthToken);

        if (!$token instanceof Entity\AccessToken) {
            $token        = new Entity\AccessToken();
            $token->token = $oauthToken;
        }

        $token->client  = $this->_em->getReference(Entity\Client::class, $clientId);
        $token->expires = $expires;
        $token->scope   = $scope;

        if ($userId) {
            $token->user = $this->_em->getReference(Entity\User::class, $userId);
        }

        $this->_em->persist($token);
        $this->_em->flush();
    }
}