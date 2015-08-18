<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_client_redirect")
 */
class ClientRedirect implements ClientRedirectInterface
{
    use ClientRedirectTrait;
}