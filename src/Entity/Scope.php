<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
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
