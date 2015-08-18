<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\RefreshToken")
 * @Table(name="oauth_refresh_token")
 */
class RefreshToken implements RefreshTokenInterface
{
    use RefreshTokenTrait;
}