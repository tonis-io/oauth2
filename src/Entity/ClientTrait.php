<?php
namespace Tonis\OAuth2\Entity;

trait ClientTrait
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
    protected $name;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $secret;

    /**
     * @var ClientRedirectInterface[]
     *
     * @OneToMany(targetEntity="ClientRedirectInterface", mappedBy="client")
     */
    protected $redirects;

    /**
     * @var SessionInterface[]
     *
     * @OneToMany(targetEntity="SessionInterface", mappedBy="client")
     */
    protected $sessions;
}
