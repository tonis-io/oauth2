<?php
namespace Tonis\OAuth2\TestAsset;

use League\OAuth2\Server\AbstractServer;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\SessionInterface;

class AccessTokenStorage extends AbstractStorage implements AccessTokenInterface
{
    public function get($token)
    {
        if ($token !== 'foo') {
            return null;
        }

        $token = new AccessTokenEntity($this->server);
        $token->setId('foo');
        $token->setExpireTime(time() + 3600);

        return $token;
    }

    /**
     * Get the scopes for an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(AccessTokenEntity $token)
    {
        // TODO: Implement getScopes() method.
    }

    /**
     * Creates a new access token
     *
     * @param string $token The access token
     * @param integer $expireTime The expire time expressed as a unix timestamp
     * @param string|integer $sessionId The session ID
     *
     * @return void
     */
    public function create($token, $expireTime, $sessionId)
    {
        // TODO: Implement create() method.
    }

    /**
     * Associate a scope with an acess token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $token The access token
     * @param \League\OAuth2\Server\Entity\ScopeEntity $scope The scope
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