<?php
namespace Tonis\OAuth2\Storage;

use League\OAuth2\Server\AbstractServer;

trait StorageTrait
{
    /** @var AbstractServer */
    private $server;

    /**
     * @param \League\OAuth2\Server\AbstractServer $server
     * @return self
     */
    public function setServer(AbstractServer $server)
    {
        $this->server = $server;
        return $this;
    }
}
