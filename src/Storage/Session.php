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
    private $sessionRepository;

    /**
     * @param Repository\Session $sessionRepository
     * @param Repository\Scope $scopeRepository
     */
    public function __construct(
        Repository\Session $sessionRepository,
        Repository\Scope $scopeRepository
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->scopeRepository   = $scopeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $session = $this
            ->sessionRepository
            ->findOneByAccessToken($accessToken->getId());

        $leagueSession = new SessionEntity($this->server);
        $leagueSession->setId($session->getId());
        $leagueSession->setOwner($session->getOwnerType(), $session->getOwnerId());

        return $leagueSession;
    }

    /**
     * {@inheritDoc}
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        $session = $this
            ->sessionRepository
            ->findOneByAuthCode($authCode->getId());

        $leagueSession = new SessionEntity($this->server);
        $leagueSession->setId($session->getId());
        $leagueSession->setOwner($session->getOwnerType(), $session->getOwnerId());

        return $leagueSession;
    }

    /**
     * {@inheritDoc}
     */
    public function getScopes(SessionEntity $leagueSession)
    {
        /** @var Entity\Session $session */
        $session = $this->sessionRepository->find($leagueSession->getId());
        $scopes  = [];

        foreach ($session->getScopes() as $scope) {
            $leagueScope = new ScopeEntity($this->server);
            $leagueScope->hydrate([
                'id'          => $scope->getId(),
                'description' => $scope->getDescription(),
            ]);

            $scopes[] = $leagueScope;
        }

        return $scopes;
    }

    /**
     * {@inheritdoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        return $this
            ->sessionRepository
            ->create($ownerType, $ownerId, $clientId, $clientRedirectUri)
            ->getId();
    }

    /**
     * {@inheritDoc}
     */
    public function associateScope(SessionEntity $leagueSession, ScopeEntity $leagueScope)
    {
        /** @var Entity\AccessToken $token */
        $token = $this->sessionRepository->find($leagueSession->getId());
        /** @var Entity\Scope $scope */
        $scope = $this->scopeRepository->find($leagueScope->getId());

        $token->addScope($scope);
    }
}
