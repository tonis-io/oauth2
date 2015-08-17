<?php
namespace Tonis\OAuth2\Entity;

trait ScopeTrait
{
    /**
     * @param Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->scopes->add($scope);
    }
}