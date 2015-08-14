<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity
 * @Table(name="oauth_client_redirect")
 */
class ClientRedirect
{
    /**
     * @var string
     *
     * @Id
     * @Column(type="integer", options={"unsigned"=true})
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Client
     *
     * @ManyToOne(targetEntity="Client", inversedBy="redirects")
     * @JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    private $uri;

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
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }
}
