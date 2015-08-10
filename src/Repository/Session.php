<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use Tonis\OAuth2\Entity;

class Session extends EntityRepository
{
    /**
     * @param      $ownerType
     * @param      $ownerId
     * @param      $clientId
     * @param null $clientRedirectUri
     * @return Entity\Session
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $session                    = new Entity\Session;
        $session->ownerType         = $ownerType;
        $session->ownerId           = $ownerId;
        $session->client            = $this->_em->getReference(Entity\Client::class, $clientId);
        $session->clientRedirectUri = $clientRedirectUri;

        $this->_em->persist($session);
        $this->_em->flush($session);

        return $session;
    }

    /**
     * @param string $accessToken
     * @return Entity\Session
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByAccessToken($accessToken)
    {
        $qb = $this->createQueryBuilder('session');
        $qb
            ->select('session')
            ->join('session.accessTokens', 'accessTokens')
            ->where('accessTokens.token = :accessToken')
            ->setParameter('accessToken', $accessToken)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}
