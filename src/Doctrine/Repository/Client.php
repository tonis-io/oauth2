<?php
namespace Tonis\OAuth2\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\ClientCredentialsInterface;
use Tonis\OAuth2\Entity;

class Client extends EntityRepository implements ClientCredentialsInterface
{
    /**
     * {@inheritDoc}
     */
    public function checkClientCredentials($clientId, $clientSecret = null)
    {
        $client = $this->find($clientId);
        return $client && $client->secret === $clientSecret;
    }

    /**
     * {@inheritDoc}
     */
    public function isPublicClient($clientId)
    {
        echo implode('::', [__CLASS__, __FUNCTION__]) . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientDetails($clientId)
    {
        $client = $this->find($clientId);

        if ($client instanceof Entity\Client) {
            return [
                'redirect_uri' => $client->redirectUri,
                'client_id'    => $client->id,
                'grant_types'  => $client->grantTypes,
                'user_id'      => $client->user ? $client->user->id : null,
                'scope'        => $client->scope,
            ];
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientScope($clientId)
    {
        echo implode('::', [__CLASS__, __FUNCTION__]) . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function checkRestrictedGrantType($clientId, $grant_type)
    {
        $details = $this->getClientDetails($clientId);
        if (isset($details['grant_types'])) {
            $grant_types = explode(' ', $details['grant_types']);

            return in_array($grant_type, (array) $grant_types);
        }

        // if grant_types are not defined, then none are restricted
        return true;
    }
}