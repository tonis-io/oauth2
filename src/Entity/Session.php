<?php
namespace Tonis\OAuth2\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Session")
 * @Table(name="oauth_session")
 */
class Session
{
    use ScopeTrait;

    /**
     * @var string
     *
     * @Id
     * @Column(type="integer", options={"unsigned"=true})
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     *
     * @Column(type="string", name="owner_type")
     */
    public $ownerType;

    /**
     * @var string
     *
     * @Column(type="string", name="owner_id")
     */
    public $ownerId;

    /**
     * @var Client
     *
     * @ManyToOne(targetEntity="Client", inversedBy="sessions")
     * @JoinColumn(nullable=false)
     */
    public $client;

    /**
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    public $clientRedirectUri;

    /**
     * @var AccessToken[]
     *
     * @OneToMany(targetEntity="AccessToken", mappedBy="session")
     */
    public $accessTokens;

    /**
     * @var AuthCode[]
     *
     * @OneToMany(targetEntity="AuthCode", mappedBy="session")
     */
    public $authCodes;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_session_scope",
     *   joinColumns={@JoinColumn(name="session_id", referencedColumnName="id")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    public $scopes;

    public function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->scopes       = new ArrayCollection();
    }
}
