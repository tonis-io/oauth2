<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\ClientCredentialsInterface;
use Tonis\OAuth2\Entity;

class OAuthClient extends EntityRepository implements ClientCredentialsInterface
{
    /**
     * {@inheritDoc}
     */
    public function checkClientCredentials($clientId, $clientSecret = null)
    {
        $client = $this->findOneBy(['clientId' => $clientId]);

        if ($client instanceof Entity\OAuthClient) {
            return password_verify($clientSecret, $client->getClientSecret());
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isPublicClient($clientId)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientDetails($clientId)
    {
        $client = $this->findOneBy(['clientId' => $clientId]);
        if ($client instanceof Entity\OAuthClient) {
            return $client->getArrayCopy();
        }
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getClientScope($clientId)
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function checkRestrictedGrantType($clientId, $grantType)
    {
        return true;
    }
}