<?php
namespace Tonis\OAuth2\Storage\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Storage\ScopeInterface;
use Tonis\OAuth2\Storage\StorageTrait;

class Scope extends EntityRepository implements ScopeInterface
{
    use StorageTrait;

    /**
     * Return information about a scope
     *
     * @param string $scope The scope
     * @param string $grantType The grant type used in the request (default = "null")
     * @param string $clientId The client sending the request (default = "null")
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity | null
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        echo 'implement: ' .__CLASS__ . '::' .  __FUNCTION__ . PHP_EOL;
    }
}