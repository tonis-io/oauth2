<?php
namespace Tonis\OAuth2\Storage;

use Doctrine\ORM\QueryBuilder;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;
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
        $result = $this->clientRepository->findOne($clientId, $clientSecret, $redirectUri, $grantType);

        return $this->hydrateClient($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getBySession(SessionEntity $session)
    {
        return $this->hydrateClient($this->clientRepository->findOneBySession($session->getId()));
    }

    /**
     * If no results then null is returned. If a result matches then a
     * League ClientEntity is hydrated and returned.
     *
     * @param array $result
     * @return ClientEntity|null
     */
    private function hydrateClient(array $result)
    {
        if (empty($result)) {
            return null;
        }

        $client = new ClientEntity($this->server);
        $client->hydrate(array_shift($result));

        return $client;
    }
}
