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
        $accessToken->token = $token;
        $accessToken->expireTime = $expireTime;
        $accessToken->session = $this->_em->getReference(Entity\SessionInterface::class, $sessionId);

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
     * @param string $token
     * @return Entity\AccessToken
     */
    public function findOneWithScopesByToken($token)
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
