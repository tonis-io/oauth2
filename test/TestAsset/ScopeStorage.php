<?php
namespace Tonis\OAuth2\TestAsset;

use League\OAuth2\Server\Storage\AbstractStorage;
use League\OAuth2\Server\Storage\ScopeInterface;

class ScopeStorage extends AbstractStorage implements ScopeInterface
{
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
        // TODO: Implement get() method.
    }
}