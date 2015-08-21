<?php
namespace Tonis\OAuth2\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\UserCredentialsInterface;

class OAuthUser extends EntityRepository implements UserCredentialsInterface
{
    use OAuthUserTrait;
}