<?php
namespace Tonis\OAuth2\Storage\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface;
use Tonis\OAuth2\Storage\StorageTrait;

class Session extends EntityRepository implements SessionInterface
{
    use StorageTrait;

    /**
     * Get a session from an access token
     *
     * @param \League\OAuth2\Server\Entity\AccessTokenEntity $accessToken The access token
     *
     * @return \League\OAuth2\Server\Entity\SessionEntity | null
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
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
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
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
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $entity = new SessionEntity($this->server);
        $entity->setOwner($ownerType, $ownerId);
        $entity->associateClient($this->_em->getReference(ClientEntity::class, $clientId));

        $this->_em->persist($entity);
        $this->_em->flush($entity);

        return $entity->getId();
    }

    /**
     * Associate a scope with a session
     *
     * @param \League\OAuth2\Server\Entity\SessionEntity $session The session
     * @param \League\OAuth2\Server\Entity\ScopeEntity   $scope The scope
     *
     * @return void
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }
}