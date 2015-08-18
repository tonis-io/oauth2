<?php
namespace Tonis\OAuth2\Entity;

trait ScopeTrait
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
    protected $description;

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
