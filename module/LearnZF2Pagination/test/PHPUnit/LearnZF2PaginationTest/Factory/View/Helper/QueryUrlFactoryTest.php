<?php
namespace LearnZF2PaginationTest\Factory\View\Helper;

use LearnZF2Pagination\Factory\View\Helper\QueryUrlFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

class QueryUrlFactoryTest extends TestCase
{
    /**
     * @var QueryUrlFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new QueryUrlFactory();
    }

    public function testCreateServiceWithoutRouteMatch()
    {
        $helper = $this->factory->createService($this->createServiceLocator());
        $this->assertInstanceOf('LearnZF2Pagination\View\Helper\QueryUrl', $helper);
    }

    public function testCreateServiceWithRouteMatch()
    {
        $e = new MvcEvent();
        $e->setRouteMatch(new RouteMatch([]));
        $helper = $this->factory->createService($this->createServiceLocator());
        $this->assertInstanceOf('LearnZF2Pagination\View\Helper\QueryUrl', $helper);
    }

    /**
     * @return ServiceLocatorInterface
     */
    private function createServiceLocator(MvcEvent $e = null)
    {
        $sm = new ServiceManager();
        $sm->setService('Request', new Request());
        $sm->setService('Response', new Response());
        $sm->setService('EventManager', new EventManager());
        $sm->setService('Router', TreeRouteStack::factory(['routes' => []]));

        $e = $e ?: new MvcEvent();
        $app = $this->prophesize('Zend\Mvc\Application');
        $app->getMvcEvent()->willReturn($e);
        $sm->setService('Application', $app->reveal());

        $helperManager = new HelperPluginManager();
        $helperManager->setServiceLocator($sm);

        return $helperManager;
    }
}
