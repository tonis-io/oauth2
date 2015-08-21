<?php
namespace Tonis\OAuth2\Repository;

trait OAuthUserTrait
{
    /**
     * {@inheritDoc}
     */
    public function checkUserCredentials($username, $password)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getUserDetails($username)
    {
        [
            'id'       => $this->id,
            'email'    => $this->email,
            'username' => $this->username,
        ];
    }
}