<?php
namespace Tonis\OAuth2\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\AccessToken")
 * @Table(name="oauth_access_token")
 */
class AccessToken
{
    use ScopeTrait;

    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    public $token;

    /**
     * @var Session
     *
     * @ManyToOne(targetEntity="Session", inversedBy="accessTokens")
     * @JoinColumn(nullable=false)
     */
    public $session;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    public $expireTime;

    /**
     * @var RefreshToken[]
     *
     * @OneToMany(targetEntity="RefreshToken", mappedBy="accessToken")
     */
    public $refreshTokens;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_access_token_scope",
     *   joinColumns={@JoinColumn(name="access_token", referencedColumnName="token")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    public $scopes;

    public function __construct()
    {
        $this->refreshTokens = new ArrayCollection();
        $this->scopes        = new ArrayCollection();
    }
}
