<?php
namespace Tonis\OAuth2\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator;

class FileLocator extends DefaultFileLocator
{
    /** @var array */
    private $exclusions = [];

    /**
     * @param array|string $paths
     * @param null|string  $extension
     * @param array        $exclusions
     */
    public function __construct($paths, $extension, array $exclusions = [])
    {
        parent::__construct($paths, $extension);

        $this->exclusions = $exclusions;
    }

    /**
     * @param string $globalBasename
     * @return array
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     */
    public function getAllClassNames($globalBasename)
    {
        return array_diff(parent::getAllClassNames($globalBasename), $this->exclusions);
    }
}