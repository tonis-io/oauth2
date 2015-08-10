<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\Storage\ScopeInterface;

class Scope implements ScopeInterface
{
    use StorageTrait;

    /**
     * Return information about a scope
     *
     * @param string $scope     The scope
     * @param string $grantType The grant type used in the request (default = "null")
     * @param string $clientId  The client sending the request (default = "null")
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity | null
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        // TODO: Implement get() method.
    }
}
