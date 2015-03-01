<?php
namespace LearnZF2NavigationTest;

use LearnZF2Navigation\Module;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Loader\StandardAutoloader;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    private $module;

    public function setUp()
    {
        $this->module = new Module();
    }

    public function testGetConfig()
    {
        $config = $this->module->getConfig();
        $expected = include __DIR__.'/../../../config/module.config.php';
        $this->assertEquals($expected, $config);
    }

    public function testGetAutoloaderConfig()
    {
        $config = $this->module->getAutoloaderConfig();
        $this->assertTrue(is_array($config));
        $this->assertArrayHasKey('Zend\Loader\StandardAutoloader', $config);
    }
}
