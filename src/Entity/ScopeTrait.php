<?php
namespace Tonis\OAuth2\Entity;

trait ScopeTrait
{
    /**
     * @return Scope[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->scopes->add($scope);
    }
}