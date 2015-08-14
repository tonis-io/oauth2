<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\ScopeInterface;
use Tonis\OAuth2\Entity;
use Tonis\OAuth2\Repository;

class Scope implements ScopeInterface
{
    use StorageTrait;

    /** @var Repository\Scope */
    private $repository;

    /**
     * @param Repository\Scope $repository
     */
    public function __construct(Repository\Scope $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        $scope = $this->repository->find($scope);

        if (!$scope instanceof Entity\Scope) {
            return null;
        }

        $leagueScope = new ScopeEntity($this->server);
        $leagueScope->hydrate([
            'id'          => $scope->getId(),
            'description' => $scope->getDescription(),
        ]);

        return $leagueScope;
    }
}
