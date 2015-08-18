<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_auth_code")
 */
trait AuthCodeTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $code;

    /**
     * @var SessionInterface
     *
     * @ManyToOne(targetEntity="Tonis\OAuth2\Entity\SessionInterface", inversedBy="authCodes")
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
     * @var string
     *
     * @Column(type="string", name="client_redirect_uri", nullable=true)
     */
    protected $clientRedirectUri;

    /**
     * @var ScopeInterface[]
     *
     * @ManyToMany(targetEntity="Tonis\OAuth2\Entity\ScopeInterface")
     * @JoinTable(name="oauth_auth_code_scope",
     *   joinColumns={@JoinColumn(name="auth_code", referencedColumnName="code")},
     *   inverseJoinColumns={@JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    protected $scopes;
}
