<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\AccessTokenInterface;
use Tonis\OAuth2\Entity;

class OAuthAccessToken extends EntityRepository implements AccessTokenInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAccessToken($token)
    {
        $token = $this->findOneBy(['token' => $token]);
        if ($token instanceof Entity\OAuthAccessToken) {
            return $token->getArrayCopy();
        }
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function setAccessToken($token, $clientId, $userId, $expires, $scope = null)
    {
        $entity = Entity\OAuthAccessToken::exchangeArray([
            'token'  => $token,
            'client' => $this->_em->getReference(Entity\OAuthClientInterface::class, $clientId)
        ]);
        print_r($entity);
        exit;
    }
}