<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Client")
 * @Table(name="oauth_client")
 */
class Client
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    private $secret;

    /**
     * @var ClientRedirect[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\ClientRedirect", mappedBy="client")
     */
    private $redirects;

    /**
     * @var Session[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\Session", mappedBy="client")
     */
    private $sessions;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
