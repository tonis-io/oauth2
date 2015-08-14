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
    private $token;

    /**
     * @var Session
     *
     * @ManyToOne(targetEntity="Session", inversedBy="accessTokens")
     * @JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    private $expireTime;

    /**
     * @var RefreshToken[]
     *
     * @OneToMany(targetEntity="RefreshToken", mappedBy="accessToken")
     */
    private $refreshTokens;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_access_token_scope",
     *   joinColumns={@JoinColumn(name="access_token", referencedColumnName="token")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    private $scopes;

    public function __construct()
    {
        $this->refreshTokens = new ArrayCollection();
        $this->scopes        = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return int
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * @param int $expireTime
     */
    public function setExpireTime($expireTime)
    {
        $this->expireTime = $expireTime;
    }

    /**
     * @return RefreshToken[]
     */
    public function getRefreshTokens()
    {
        return $this->refreshTokens;
    }
}
