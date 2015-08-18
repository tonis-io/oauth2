<?php
namespace Tonis\OAuth2\Entity;

use Doctrine\Common\Collections\ArrayCollection;

trait SessionTrait
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
     * @var string
     *
     * @Column(type="string", name="owner_type")
     */
    protected $ownerType;

    /**
     * @var string
     *
     * @Column(type="string", name="owner_id")
     */
    protected $ownerId;

    /**
     * @var ClientInterface
     *
     * @ManyToOne(targetEntity="ClientInterface", inversedBy="sessions")
     * @JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    protected $clientRedirectUri;

    /**
     * @var AccessTokenInterface[]
     *
     * @OneToMany(targetEntity="AccessTokenInterface", mappedBy="session")
     */
    protected $accessTokens;

    /**
     * @var AuthCodeInterface[]
     *
     * @OneToMany(targetEntity="AuthCodeInterface", mappedBy="session")
     */
    protected $authCodes;

    /**
     * @var ScopeInterface[]
     *
     * @ManyToMany(targetEntity="ScopeInterface")
     * @JoinTable(name="oauth_session_scope",
     *   joinColumns={@JoinColumn(name="session_id", referencedColumnName="id")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    protected $scopes;

    protected function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->scopes       = new ArrayCollection();
    }
}
