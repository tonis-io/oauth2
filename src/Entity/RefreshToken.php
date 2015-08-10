<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_refresh_token")
 */
class RefreshToken
{
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
     * @ManyToOne(targetEntity="AccessToken", inversedBy="refreshTokens")
     * @JoinColumn(nullable=false, name="access_token", referencedColumnName="token")
     */
    public $accessToken;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    public $expireTime;
}
