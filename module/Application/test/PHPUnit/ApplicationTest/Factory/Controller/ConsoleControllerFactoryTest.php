<?php

namespace ApplicationTest\Factory\Controller;

use Application\Factory\Controller\ConsoleControllerFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Console\Adapter\Posix;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class ConsoleControllerFactoryTest extends TestCase
{
    /**
     * @var ConsoleControllerFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new ConsoleControllerFactory();
    }

    public function testCreateService()
    {
        $sm = new ServiceManager();
        $sm->setService('Console', new Posix());
        $sm->setService('Config', []);
        $cm = $this->prophesize(ControllerManager::class);
        $cm->setServiceLocator($sm)->shouldBeCalled();

        $controller = $this->factory->createService($cm->reveal());
        $this->assertInstanceOf('Application\Controller\ConsoleController', $controller);
    }
}
