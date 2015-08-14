<?php
namespace Tonis\OAuth2\Entity;

/**
 * @Entity(repositoryClass="Tonis\OAuth2\Repository\Scope")
 * @Table(name="oauth_scope")
 */
class Scope
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
    private $description;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
