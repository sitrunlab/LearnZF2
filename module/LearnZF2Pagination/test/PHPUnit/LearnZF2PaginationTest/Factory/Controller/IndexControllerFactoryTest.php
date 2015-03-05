<?php
namespace LearnZF2PaginationTest\Factory\Controller;

use LearnZF2Pagination\Factory\Controller\IndexControllerFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class IndexControllerFactoryTest extends TestCase
{
    /**
     * @var IndexControllerFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new IndexControllerFactory();
    }

    public function testCreateServiceWithData()
    {
        $controller = $this->factory->createService($this->createServiceLocator(['pagination_data' => []]));
        $this->assertInstanceOf('LearnZF2Pagination\Controller\IndexController', $controller);
    }

    public function testCreateServiceWithoutData()
    {
        $controller = $this->factory->createService($this->createServiceLocator());
        $this->assertInstanceOf('LearnZF2Pagination\Controller\IndexController', $controller);
    }

    /**
     * @return ServiceLocatorInterface
     *
     * @param array $data
     */
    private function createServiceLocator(array $data = [])
    {
        $controllerManager = new ControllerManager();
        $sm = new ServiceManager();
        $sm->setService('Config', $data);
        $controllerManager->setServiceLocator($sm);

        return $controllerManager;
    }
}
