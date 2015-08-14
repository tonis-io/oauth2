<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_auth_code")
 */
class AuthCode
{
    use ScopeTrait;

    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    private $code;

    /**
     * @var Session
     *
     * @ManyToOne(targetEntity="Session", inversedBy="authCodes")
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
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    private $clientRedirectUri;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_auth_code_scope",
     *   joinColumns={@JoinColumn(name="auth_code", referencedColumnName="code")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    private $scopes;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
