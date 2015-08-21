<?php
namespace Tonis\OAuth2\Entity;

class OAuthClient implements OAuthClientInterface
{
    /** @var int */
    private $id;
    /** @var string */
    private $clientId;
    /** @var string */
    private $clientSecret;
    /** @var string */
    private $redirectUri;

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }
}