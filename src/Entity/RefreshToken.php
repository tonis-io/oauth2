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
    private $token;

    /**
     * @var Session
     *
     * @ManyToOne(targetEntity="AccessToken", inversedBy="refreshTokens")
     * @JoinColumn(nullable=false, name="access_token", referencedColumnName="token")
     */
    private $accessToken;

    /**
     * @var int
     *
     * @Column(type="integer", name="expire_time")
     */
    private $expireTime;

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
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param Session $accessToken
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
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
}
