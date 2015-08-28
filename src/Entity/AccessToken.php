<?php
namespace Tonis\OAuth2\Entity;

class AccessToken
{
    public $token;
    public $client;
    public $user;
    public $expires;
    public $scope;
}