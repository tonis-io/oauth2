<?php
namespace Tonis\OAuth2\Entity;

interface OAuthAccessTokenInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return \DateTime
     */
    public function getExpires();

    /**
     * @return string
     */
    public function getScope();

    /**
     * @return OAuthClientInterface
     */
    public function getClient();

    /**
     * @return OAuthUserInterface
     */
    public function getUser();
}