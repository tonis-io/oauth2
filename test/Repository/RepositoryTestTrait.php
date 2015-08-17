<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mockery as m;
use Tonis\OAuth2\TestAsset\StubServer;

trait RepositoryTestTrait
{
    /** @var EntityManager */
    protected $entityManager;
    /** @var AccessToken */
    protected $repository;
    /** @var StubServer */
    protected $server;

    protected function setUp()
    {
        $metadata = new ClassMetadata($this->getEntityClass());
        $rClass   = $this->getRepositoryClass();

        $this->entityManager = m::mock(EntityManager::class);
        $this->repository    = new $rClass($this->entityManager, $metadata);
        $this->server        = new StubServer();
    }

    abstract protected function getRepositoryClass();

    abstract protected function getEntityClass();
}