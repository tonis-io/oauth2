<?php
namespace Tonis\OAuth2\Entity;

trait RefreshTokenTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $token;

    /**
     * @var AccessTokenInterface
     *
     * @ManyToOne(targetEntity="AccessTokenInterface", inversedBy="refreshTokens")
     * @JoinColumn(nullable=false, name="access_token", referencedColumnName="token")
     */
    protected $accessToken;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    protected $expireTime;
}
