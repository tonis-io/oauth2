<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Scope")
 * @Table(name="oauth_scope")
 */
class Scope implements ScopeInterface
{
    use ScopeTrait;
}