<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use Tonis\OAuth2\Entity;

final class AccessToken extends EntityRepository
{
    /**
     * @param string $token
     * @param int    $expireTime
     * @param int    $sessionId
     * @return Entity\AccessToken
     * @throws \Doctrine\ORM\ORMException
     */
    public function create($token, $expireTime, $sessionId)
    {
        $accessToken = new Entity\AccessToken();
        $accessToken->setToken($token);
        $accessToken->setExpireTime($expireTime);
        $accessToken->setSession($this->_em->getReference(Entity\Session::class, $sessionId));

        $this->_em->persist($accessToken);
        $this->_em->flush($accessToken);

        return $accessToken;
    }

    /**
     * @param AccessTokenEntity $token
     */
    public function remove(AccessTokenEntity $token)
    {
        $this->_em->remove($token);
        $this->_em->flush($token);
    }

    /**
     * @param AccessTokenEntity $token
     * @param ScopeEntity $scope
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {

    }

    /**
     * @param string $token
     * @return Entity\AccessToken
     */
    public function findOneByTokenWithScopes($token)
    {
        $qb = $this->createQueryBuilder('token');
        $qb
            ->select('token, scopes')
            ->leftJoin('token.scopes', 'scopes')
            ->where('token.token = :token')
            ->setParameter('token', $token)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}
