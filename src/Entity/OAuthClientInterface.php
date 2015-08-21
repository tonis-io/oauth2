<?php
namespace Tonis\OAuth2\Entity;

interface OAuthClientInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getClientId();

    /**
     * @return string
     */
    public function getClientSecret();

    /**
     * @return string
     */
    public function getRedirectUri();
}