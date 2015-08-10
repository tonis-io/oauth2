<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;

class Client extends EntityRepository
{
    /**
     * @param string      $clientId
     * @param string|null $clientSecret
     * @param string|null $redirectUri
     * @param string|null $grantType
     * @return array
     */
    public function findOne($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $qb = $this->createQueryBuilder('client');
        $qb
            ->select('partial client.{id, name}')
            ->where('client.id = :clientId')
            ->setParameter('clientId', $clientId)
            ->setMaxResults(1);

        if (null !== $clientSecret) {
            $qb
                ->andWhere('client.secret = :clientSecret')
                ->setParameter('clientSecret', $clientSecret);
        }

        if (null !== $redirectUri) {
            $qb
                ->join('client.redirects', 'redirects')
                ->andWhere('redirects.uri = :redirectUri')
                ->setParameter('redirectUri', $redirectUri);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param int $sessionId
     * @return array
     */
    public function findOneBySession($sessionId)
    {
        $qb = $this->createQueryBuilder('client');
        $qb
            ->select('partial client.{id, name}')
            ->join('client.sessions', 'sessions')
            ->where('sessions.id = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->setMaxResults(1);

        return $qb->getQuery()->getArrayResult();
    }
}
