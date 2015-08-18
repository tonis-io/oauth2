<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_client_redirect")
 */
trait ClientRedirectTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="integer", options={"unsigned"=true})
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ClientInterface
     *
     * @ManyToOne(targetEntity="ClientInterface", inversedBy="redirects")
     * @JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $uri;
}
