<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_auth_code")
 */
class AuthCode implements AuthCodeInterface
{
    use AuthCodeTrait;
}
