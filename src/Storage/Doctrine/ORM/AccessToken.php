<?php
namespace Tonis\OAuth2\Storage\Doctrine\ORM;

use DateTime;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use Tonis\OAuth2\Storage\StorageTrait;

class AccessToken extends EntityRepository implements AccessTokenInterface
{
    use StorageTrait;

    /**
     * {@inheritDoc}
     */
    public function get($token)
    {
        $token = $this->find($token);
        if (!$token instanceof AccessTokenEntity) {
            return null;
        }

        // Convert the token to an integer
        $token->setExpireTime($token->getExpireTime()->getTimestamp());
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
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function create($token, $expireTime, $sessionId)
    {
        $entity = new AccessTokenEntity($this->server);
        $entity->setId($token);
        $entity->setExpireTime(new DateTime("@{$expireTime}"));
        $entity->setSession($this->_em->getReference(SessionEntity::class, $sessionId));

        $this->_em->persist($entity);
        $this->_em->flush($entity);
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
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
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
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }

}