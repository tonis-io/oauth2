<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use Tonis\OAuth2\Entity;

class AccessToken extends EntityRepository
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
        $accessToken             = new Entity\AccessToken();
        $accessToken->token      = $token;
        $accessToken->expireTime = $expireTime;
        $accessToken->session    = $this->_em->getReference(Entity\Session::class, $sessionId);

        $this->_em->persist($accessToken);
        $this->_em->flush($accessToken);

        return $accessToken;
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
