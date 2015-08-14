<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;
use Tonis\OAuth2\Entity;
use Tonis\OAuth2\Repository;

class Client implements ClientInterface
{
    use StorageTrait;

    /** @var Repository\Client */
    private $clientRepository;

    /**
     * @param Repository\Client $clientRepository
     */
    public function __construct(Repository\Client $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $client = $this->clientRepository->findOne($clientId, $redirectUri);

        if (null !== $clientSecret &&
            $client instanceof Entity\Client &&
            !password_verify($clientSecret, $client->getSecret())
        ) {
            return null;
        }

        return $this->mapClient($client);
    }

    /**
     * {@inheritdoc}
     */
    public function getBySession(SessionEntity $session)
    {
        return $this->mapClient($this->clientRepository->findOneBySession($session->getId()));
    }

    /**
     * Maps a Tonis\OAuth2\Client to a League\OAuth2\Server\Entity\ClientEntity.
     *
     * @param Entity\Client $client
     * @return ClientEntity|null
     */
    private function mapClient(Entity\Client $client = null)
    {
        if (null === $client) {
            return null;
        }

        $leagueClient = new ClientEntity($this->server);
        $leagueClient->hydrate(['id' => $client->getId(), 'name' => $client->getName()]);

        return $leagueClient;
    }
}
