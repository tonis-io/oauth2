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
     * @ManyToOne(targetEntity="Tonis\OAuth2\Entity\ClientInterface", inversedBy="sessions")
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
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\AccessTokenInterface", mappedBy="session")
     */
    protected $accessTokens;

    /**
     * @var AuthCodeInterface[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\AuthCodeInterface", mappedBy="session")
     */
    protected $authCodes;

    /**
     * @var ScopeInterface[]
     *
     * @ManyToMany(targetEntity="Tonis\OAuth2\Entity\ScopeInterface")
     * @JoinTable(name="oauth_session_scope",
     *   joinColumns={@JoinColumn(name="session_id", referencedColumnName="id")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    protected $scopes;

    public function __construct()
    {
        $this->accessTokens = new ArrayCollection();
        $this->scopes       = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOwnerType()
    {
        return $this->ownerType;
    }

    /**
     * @param string $ownerType
     */
    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;
    }

    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param string $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getClientRedirectUri()
    {
        return $this->clientRedirectUri;
    }

    /**
     * @param string $clientRedirectUri
     */
    public function setClientRedirectUri($clientRedirectUri)
    {
        $this->clientRedirectUri = $clientRedirectUri;
    }
}
