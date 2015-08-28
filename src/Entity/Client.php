<?php
namespace Tonis\OAuth2\Entity;

class Client
{
    public $id;
    public $secret;
    public $redirectUri;
    public $grantTypes;
    public $scope;
    public $user;
}