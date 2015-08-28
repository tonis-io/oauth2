<?php
namespace Tonis\OAuth2\Storage\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;
use Tonis\OAuth2\Storage\StorageTrait;

class Client extends EntityRepository implements ClientInterface
{
    use StorageTrait;

    /**
     * {@inheritDoc}
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $client = $this->find($clientId);

        if (!$client instanceof ClientEntity ||
            ($clientSecret !== null && $client->getSecret() !== $clientSecret) ||
            ($redirectUri !== null && $client->getRedirectUri() !== $redirectUri)
        ) {
            return null;
        }

        return $client;
    }

    /**
     * {@inheritDoc}
     */
    public function getBySession(SessionEntity $session)
    {
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }
}