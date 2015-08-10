<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface;
use Tonis\OAuth2\Entity;
use Tonis\OAuth2\Repository;

class Session implements SessionInterface
{
    use StorageTrait;

    /** @var Repository\Session */
    private $repository;

    /**
     * @param Repository\Session $repository
     */
    public function __construct(Repository\Session $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $result = $this
            ->repository
            ->findOneByAccessToken($accessToken->getId());

        $session = new SessionEntity($this->server);
        $session->setId($result->id);
        $session->setOwner($result->ownerType, $result->ownerId);

        return $session;
    }

    /**
     * Get a session from an auth code
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $authCode The auth code
     *
     * @return \League\OAuth2\Server\Entity\SessionEntity | null
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        // TODO: Implement getByAuthCode() method.
    }

    /**
     * Get a session's scopes
     *
     * @param  \League\OAuth2\Server\Entity\SessionEntity
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(SessionEntity $session)
    {
        // TODO: Implement getScopes() method.
    }

    /**
     * {@inheritdoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        return $this
            ->repository
            ->create($ownerType, $ownerId, $clientId, $clientRedirectUri)
            ->id;
    }

    /**
     * Associate a scope with a session
     *
     * @param \League\OAuth2\Server\Entity\SessionEntity $session The session
     * @param \League\OAuth2\Server\Entity\ScopeEntity   $scope   The scope
     *
     * @return void
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        // TODO: Implement associateScope() method.
    }
}
