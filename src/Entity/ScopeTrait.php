<?php
namespace Tonis\OAuth2\Entity;

trait ScopeTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $description;
}
