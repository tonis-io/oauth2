<?php
namespace Tonis\OAuth2\TestAsset;

use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\ClientInterface;

class ClientStorage extends AbstractStorage implements ClientInterface
{
    /**
     * Validate a client
     *
     * @param string $clientId The client's ID
     * @param string $clientSecret The client's secret (default = "null")
     * @param string $redirectUri The client's redirect URI (default = "null")
     * @param string $grantType The grant type used (default = "null")
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity | null
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        // TODO: Implement get() method.
    }

    /**
     * Get the client associated with a session
     *
     * @param \League\OAuth2\Server\Entity\SessionEntity $session The session
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity | null
     */
    public function getBySession(SessionEntity $session)
    {
        if ($session->getId() !== 'foo') {
            return null;
        }

        $client = new ClientEntity($this->server);
        $client->hydrate(['id' => 'foo']);

        return $client;
    }
}