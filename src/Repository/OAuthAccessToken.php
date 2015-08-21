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
            return [
                'token'     => $token->getToken(),
                'expires'   => $token->getExpires()->getTimestamp(),
                'scope'     => $token->getScope(),
                'client_id' => $token->getClient()->getClientId(),
                'user_id'   => $token->getUser() ? $token->getUser()->getId() : null,
            ];
        }
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function setAccessToken($oauthToken, $clientId, $userId, $expires, $scope = null)
    {
        $client = $this
            ->_em
            ->getRepository(Entity\OAuthClientInterface::class)
            ->findOneBy(['clientId' => $clientId]);

        if (!$client instanceof Entity\OAuthClientInterface) {
            throw new \RuntimeException(sprintf('Failed to find client "%s"', $clientId));
        }

        $token = new Entity\OAuthAccessToken();
        $token->setToken($oauthToken);
        $token->setClient($client);

        if (null !== $userId) {
            $token->setUser($this->_em->getReference(Entity\OAuthUserInterface::class, $userId));
        }

        $token->setExpires(new \DateTime("@{$expires}"));
        $token->setScope($scope);

        $this->_em->persist($token);
        $this->_em->flush($token);
    }
}