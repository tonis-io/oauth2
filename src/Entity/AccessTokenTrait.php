<?php
namespace Tonis\OAuth2\Entity;

use Doctrine\Common\Collections\ArrayCollection;

trait AccessTokenTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $token;

    /**
     * @var SessionInterface
     *
     * @ManyToOne(targetEntity="Tonis\OAuth2\Entity\SessionInterface", inversedBy="accessTokens")
     * @JoinColumn(nullable=false)
     */
    protected $session;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    protected $expireTime;

    /**
     * @var RefreshTokenInterface[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\RefreshTokenInterface", mappedBy="accessToken")
     */
    protected $refreshTokens;

    /**
     * @var ScopeInterface[]
     *
     * @ManyToMany(targetEntity="Tonis\OAuth2\Entity\ScopeInterface")
     * @JoinTable(name="oauth_access_token_scope",
     *   joinColumns={@JoinColumn(name="access_token", referencedColumnName="token")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    protected $scopes;

    public function __construct()
    {
        $this->refreshTokens = new ArrayCollection();
        $this->scopes        = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritDoc}
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * {@inheritDoc}
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritDoc}
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * {@inheritDoc}
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
    }

    /**
     * {@inheritDoc}
     */
    public function getRefreshTokens()
    {
        return $this->refreshTokens;
    }

    /**
     * {@inheritDoc}
     */
    public function getScopes()
    {
        return $this->scopes;
    }
}
