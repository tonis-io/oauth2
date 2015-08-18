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
     * @ManyToOne(targetEntity="SessionInterface", inversedBy="accessTokens")
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
     * @OneToMany(targetEntity="RefreshTokenInterface", mappedBy="accessToken")
     */
    protected $refreshTokens;

    /**
     * @var ScopeInterface[]
     *
     * @ManyToMany(targetEntity="ScopeInterface")
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
}
