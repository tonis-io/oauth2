<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Scope")
 * @Table(name="oauth_scope")
 */
class Scope
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    public $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    public $description;
}
