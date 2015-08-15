<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use Tonis\OAuth2\Entity;

final class Client extends EntityRepository
{
    /**
     * @param string      $clientId
     * @param string|null $redirectUri
     * @return Entity\Client
     */
    public function findOne($clientId, $redirectUri = null)
    {
        $qb = $this->createQueryBuilder('client');
        $qb
            ->select('partial client.{id, name, secret}')
            ->where('client.id = :clientId')
            ->setParameter('clientId', $clientId)
            ->setMaxResults(1);

        if (null !== $redirectUri) {
            $qb
                ->join('client.redirects', 'redirects')
                ->andWhere('redirects.uri = :redirectUri')
                ->setParameter('redirectUri', $redirectUri);
        }

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param int $sessionId
     * @return Entity\Client
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

        return $qb->getQuery()->getSingleResult();
    }
}
