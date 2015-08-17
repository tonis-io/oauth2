<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Client")
 * @Table(name="oauth_client")
 */
class Client
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
    public $name;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    public $secret;

    /**
     * @var ClientRedirect[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\ClientRedirect", mappedBy="client")
     */
    public $redirects;

    /**
     * @var Session[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\Session", mappedBy="client")
     */
    public $sessions;
}
