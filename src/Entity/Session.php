<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Session")
 * @Table(name="oauth_session")
 */
class Session implements SessionInterface
{
    use SessionTrait;
}