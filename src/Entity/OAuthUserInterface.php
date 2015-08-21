<?php
namespace Tonis\OAuth2\Entity;

interface OAuthUserInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPassword();
}