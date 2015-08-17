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
    public $code;

    /**
     * @var Session
     *
     * @ManyToOne(targetEntity="Session", inversedBy="authCodes")
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
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    public $clientRedirectUri;

    /**
     * @var Scope[]
     *
     * @ManyToMany(targetEntity="Scope")
     * @JoinTable(name="oauth_auth_code_scope",
     *   joinColumns={@JoinColumn(name="auth_code", referencedColumnName="code")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    public $scopes;
}
