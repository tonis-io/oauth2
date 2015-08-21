<?php
namespace Tonis\OAuth2\Entity;

use DateTime;

class OAuthAccessToken implements OAuthAccessTokenInterface
{
    /** @var int */
    private $id;
    /** @var string */
    private $token;
    /** @var DateTime */
    private $expires;
    /** @var string */
    private $scope;
    /** @var OAuthClientInterface */
    private $client;
    /** @var OAuthUserInterface */
    private $user;

    /**
     * {@iheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@iheritDoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * {@iheritDoc}
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * {@inheritDoc}
     */
    public function setExpires(DateTime $expires)
    {
        $this->expires = $expires;
    }

    /**
     * {@iheritDoc}
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * {@inheritDoc}
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * {@iheritDoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritDoc}
     */
    public function setClient(OAuthClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@iheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(OAuthUserInterface $user)
    {
        $this->user = $user;
    }
}