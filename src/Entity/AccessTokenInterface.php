<?php
namespace Tonis\OAuth2\Entity;

interface AccessTokenInterface
{
    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return SessionInterface
     */
    public function getSession();

    /**
     * @param SessionInterface $session
     */
    public function setSession(SessionInterface $session);

    /**
     * @return int
     */
    public function getExpireTime();

    /**
     * @param int $expireTime
     */
    public function setExpireTime($expireTime);

    /**
     * @return RefreshTokenInterface[]
     */
    public function getRefreshTokens();

    /**
     * @return ScopeInterface[]
     */
    public function getScopes();
}