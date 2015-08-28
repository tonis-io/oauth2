<?php
namespace Tonis\OAuth2\Entity;

class Client
{
    private $id;
    private $secret;
    private $redirectUri;
    private $grantTypes;
    private $scope;
    private $user;
}