<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\AccessToken")
 * @Table(name="oauth_access_token")
 */
class AccessToken implements AccessTokenInterface
{
    use AccessTokenTrait;
}