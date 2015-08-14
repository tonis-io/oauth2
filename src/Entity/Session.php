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
    private $id;

    /**
     * @var string
     *
     * @Column(type="string", name="owner_type")
     */
    private $ownerType;

    /**
     * @var string
     *
     * @Column(type="string", name="owner_id")
     */
    private $ownerId;

    /**
     * @var Client
     *
     * @ManyToOne(targetEntity="Client", inversedBy="sessions")
     * @JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    private $clientRedirectUri;

    /**
     * @var AccessToken[]
     *
     * @OneToMany(targetEntity="AccessToken", mappedBy="session")
     */
    private $accessTokens;

    /**
     * @var AuthCode[]
     *
     * @OneToMany(targetEntity="AuthCode", mappedBy="session")
     */
    private $authCodes;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_session_scope",
     *   joinColumns={@JoinColumn(name="session_id", referencedColumnName="id")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    private $scopes;

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
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
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

    /**
     * @return AccessToken[]
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }

    /**
     * @return AuthCode[]
     */
    public function getAuthCodes()
    {
        return $this->authCodes;
    }
}
