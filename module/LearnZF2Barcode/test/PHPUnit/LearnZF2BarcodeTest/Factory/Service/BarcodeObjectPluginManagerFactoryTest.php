<?php

namespace LearnZF2BarcodeTest\Factory\Service;

use LearnZF2Barcode\Factory\Service\BarcodeObjectPluginManagerFactory;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class BarcodeObjectPluginManagerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceManager
     */
    protected $services;

    /**
     * @var BarcodeObjectPluginManagerFactory
     */
    public function setUp()
    {
        $this->services = new ServiceManager();
        $this->services->setService('Config', []);
        $this->factory  = new BarcodeObjectPluginManagerFactory();
    }

    public function testInstanceOfObjectPluginManager()
    {
        $manager = $this->factory->createService($this->services);
        $this->assertInstanceof('Zend\Barcode\ObjectPluginManager', $manager);
    }

    public function testGetServiceViaManager()
    {
        $manager = $this->factory->createService($this->services);
        $manager->get('codabar');
    }
}
