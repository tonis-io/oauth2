<?php
namespace Tonis\OAuth2;

use Tonis\App;
use Tonis\DoctrineORM\Package as DoctrineORMPackage;

/**
 * @covers \Tonis\OAuth2\Package
 */
class PackageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Tonis\App */
    private $app;

    protected function setUp()
    {
        $app = new App();
        $app->package(new DoctrineORMPackage);

        $this->app = $app;
    }

    public function testRegister()
    {
        $app = $this->app;

        $package = new Package();
        $package->register($app);

        $this->assertTrue($app->getContainer()->has(Storage\AccessToken::class));
    }
}