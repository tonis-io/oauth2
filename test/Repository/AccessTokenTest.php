<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use MMoussa\Doctrine\Test\ORM\QueryBuilderMocker;
use Mockery as m;
use Tonis\OAuth2\Entity;

/**
 * @covers \Tonis\OAuth2\Repository\AccessToken
 */
class AccessTokenTest extends \PHPUnit_Framework_TestCase
{
    use RepositoryTestTrait;

    public function testCreate()
    {
        $session = new Entity\Session();
        $session->id = 1;

        $this
            ->entityManager
            ->shouldReceive('getReference')
            ->with(Entity\Session::class, 1)
            ->once()
            ->andReturn($session);

        $this->entityManager->shouldReceive('persist')->once();
        $this->entityManager->shouldReceive('flush')->once();

        $time = time() + 3600;

        $r     = $this->repository;
        $token = $r->create('token', $time, 1);

        $this->assertInstanceOf(Entity\AccessToken::class, $token);
        $this->assertSame('token', $token->token);
        $this->assertSame($time, $token->expireTime);
        $this->assertSame($session, $token->session);
    }

    public function testRemove()
    {
        $token = new AccessTokenEntity($this->server);

        $this->entityManager->shouldReceive('remove')->once()->with($token);
        $this->entityManager->shouldReceive('flush')->once()->with($token);

        $this->repository->remove($token);
    }

    public function testFindOneWithScopesByToken()
    {
        $token = 'foo';

        $qbm = new QueryBuilderMocker($this);
        $qbm
            ->select('token, scopes')
            ->leftJoin('token.scopes', 'scopes')
            ->where('token.token = :token')
            ->setParameter('token', $token)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        $this
            ->entityManager
            ->shouldReceive('createQueryBuilder')
            ->andReturn($qbm->getQueryBuilderMock());

        $this->repository->findOneWithScopesByToken($token);
    }

    protected function getEntityClass()
    {
        return Entity\AccessToken::class;
    }

    protected function getRepositoryClass()
    {
        return AccessToken::class;
    }
}