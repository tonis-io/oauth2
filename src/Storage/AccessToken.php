<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use Tonis\OAuth2\Entity;
use Tonis\OAuth2\Repository;

final class AccessToken implements AccessTokenInterface
{
    use StorageTrait;

    /** @var Repository\Scope */
    private $scopeRepository;
    /** @var Repository\AccessToken */
    private $tokenRepository;

    /**
     * @param Repository\AccessToken $tokenRepository
     * @param Repository\Scope $scopeRepository
     */
    public function __construct(
        Repository\AccessToken $tokenRepository,
        Repository\Scope $scopeRepository
    ) {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($token)
    {
        $result = $this->tokenRepository->find($token);

        if (!$result instanceof Entity\AccessToken) {
            return null;
        }

        $token = new AccessTokenEntity($this->server);
        $token->setId($result->token);
        $token->setExpireTime($result->expireTime);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(AccessTokenEntity $token)
    {
        $accessToken = $this->tokenRepository->findOneWithScopesByToken($token);
        $scopes      = $accessToken->scopes;

        $result = [];
        foreach ($scopes as $scope) {
            $leagueScope = new ScopeEntity($this->server);
            $leagueScope->hydrate(['id' => $scope->getId(), 'description' => $scope->getDescription()]);

            $result[] = $leagueScope;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create($token, $expireTime, $sessionId)
    {
        $this->tokenRepository->create($token, $expireTime, $sessionId);
    }

    /**
     * {@inheritDoc}
     */
    public function associateScope(AccessTokenEntity $leagueToken, ScopeEntity $leagueScope)
    {
        /** @var Entity\AccessToken $token */
        $token = $this->tokenRepository->find($leagueToken->getId());
        /** @var Entity\Scope $scope */
        $scope = $this->scopeRepository->find($leagueScope->getId());

        $token->addScope($scope);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(AccessTokenEntity $token)
    {
        $this->tokenRepository->remove($token);
    }
}
