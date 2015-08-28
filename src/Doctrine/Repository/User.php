<?php
namespace Tonis\OAuth2\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\UserCredentialsInterface;

class User extends EntityRepository implements UserCredentialsInterface
{
    /**
     * {@inheritDoc}
     */
    public function checkUserCredentials($username, $password)
    {
        echo implode('::', [__CLASS__, __FUNCTION__]) . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserDetails($username)
    {
        echo implode('::', [__CLASS__, __FUNCTION__]) . PHP_EOL;
    }
}