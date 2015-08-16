<?php
namespace Tonis\OAuth2\TestAsset;

use League\OAuth2\Server\ResourceServer as BaseResourceServer;

class ResourceServer extends BaseResourceServer
{
    public function __construct()
    {
        parent::__construct(
            new SessionStorage(),
            new AccessTokenStorage(),
            new ClientStorage(),
            new ScopeStorage()
        );
    }
}