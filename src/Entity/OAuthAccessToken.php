<?php
namespace Tonis\OAuth2\Entity;

class OAuthAccessToken implements OAuthAccessTokenInterface
{
    use ExchangeArrayTrait;

    /** @var int */
    private $id;
    /** @var string */
    private $token;
    /** @var \DateTime */
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
     * {@iheritDoc}
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * {@iheritDoc}
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * {@iheritDoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@iheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@iheritDoc}
     */
    public function getArrayCopy()
    {
        return [
            'token'     => $this->token,
            'expires'   => $this->expires->getTimestamp(),
            'scope'     => $this->scope,
            'client_id' => $this->client->getClientId(),
            'user_id'   => $this->user ? $this->user->getId() : null,
        ];
    }
}