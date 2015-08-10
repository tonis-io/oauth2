<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_client_redirect")
 */
class ClientRedirect
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="integer", options={"unsigned"=true})
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var ClientInterface
     *
     * @ManyToOne(targetEntity="ClientInterface", inversedBy="redirects")
     * @JoinColumn(nullable=false)
     */
    public $client;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    public $uri;
}
