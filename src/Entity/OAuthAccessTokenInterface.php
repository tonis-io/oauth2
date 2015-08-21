<?php
namespace Tonis\OAuth2\Entity;

use DateTime;

interface OAuthAccessTokenInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return \DateTime
     */
    public function getExpires();

    /**
     * @param DateTime $expires
     */
    public function setExpires(DateTime $expires);

    /**
     * @return string
     */
    public function getScope();

    /**
     * @param string $scope
     */
    public function setScope($scope);

    /**
     * @return OAuthClientInterface
     */
    public function getClient();

    /**
     * @param OAuthClientInterface $client
     */
    public function setClient(OAuthClientInterface $client);

    /**
     * @return OAuthUserInterface
     */
    public function getUser();

    /**
     * @param OAuthUserInterface $user
     */
    public function setUser(OAuthUserInterface $user);
}