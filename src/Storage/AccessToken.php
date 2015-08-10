<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use Tonis\OAuth2\Entity;
use Tonis\OAuth2\Repository;

class AccessToken implements AccessTokenInterface
{
    use StorageTrait;

    /** @var Repository\AccessToken */
    private $repository;

    /**
     * @param Repository\AccessToken $repository
     */
    public function __construct(Repository\AccessToken $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($token)
    {
        $result = $this->repository->find($token);

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
        $accessToken = $this->repository->findOneByTokenWithScopes($token);
        $scopes      = $accessToken->scopes;

        $result = [];
        foreach ($scopes as $scope) {
            $leagueScope = new ScopeEntity($this->server);
            $leagueScope->hydrate(['id' => $scope->id, 'description' => $scope->description]);

            $result[] = $leagueScope;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function create($token, $expireTime, $sessionId)
    {
        $this->repository->create($token, $expireTime, $sessionId);
    }

    /**
     * Associate a scope with an acess token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token
     * @param \League\OAuth2\Server\Entity\ScopeEntity       $scope The scope
     *
     * @return void
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {
        // TODO: Implement associateScope() method.
    }

    /**
     * Delete an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token to delete
     *
     * @return void
     */
    public function delete(AccessTokenEntity $token)
    {
        // TODO: Implement delete() method.
    }
}
