<?php
namespace Tonis\OAuth2\Entity;

trait ClientTrait
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="string")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $secret;

    /**
     * @var ClientRedirectInterface[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\ClientRedirectInterface", mappedBy="client")
     */
    protected $redirects;

    /**
     * @var SessionInterface[]
     *
     * @OneToMany(targetEntity="Tonis\OAuth2\Entity\SessionInterface", mappedBy="client")
     */
    protected $sessions;

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

    /**
     * @return ClientRedirectInterface[]
     */
    public function getRedirects()
    {
        return $this->redirects;
    }

    /**
     * @return SessionInterface[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
