<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Client")
 * @Table(name="oauth_client")
 */
class Client implements ClientInterface
{
    use ClientTrait;
}