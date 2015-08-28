<?php
namespace Tonis\OAuth2\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\ScopeInterface;
use Tonis\OAuth2\Entity;

class Scope extends EntityRepository implements ScopeInterface
{
    /**
     * {@inheritDoc}
     */
    public function scopeExists($scope)
    {
        return null !== $this->find($scope);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultScope($clientId = null)
    {
        $entities = $this->findBy(['isDefault' => true]);

        if (empty($entities)) {
            return null;
        }

        $defaultScope = array_map(function (Entity\Scope $entity) {
            return $entity->id;
        }, $entities);

        return implode(' ', $defaultScope);
    }
}