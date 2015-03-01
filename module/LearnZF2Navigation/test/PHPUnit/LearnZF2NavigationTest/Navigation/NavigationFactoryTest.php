<?php
namespace LearnZF2NavigationTest\Navigation;

use LearnZF2Navigation\Navigation\NavigationFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Console\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * Class NavigationFactoryTest
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class NavigationFactoryTest extends TestCase
{
    /**
     * @var NavigationFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new NavigationFactory();
    }

    public function testCreateService()
    {
        $sm = new ServiceManager(new Config([
            'services' => [
                'config' => include __DIR__ . '/../../../../config/module.config.php',
                'eventmanager' => new EventManager(),
                'router' => new TreeRouteStack(),
                'request' => new Request(),
                'routematch' => new RouteMatch([])
            ]
        ]));

        $event = new MvcEvent();
        $event->setRequest($sm->get('request'))
              ->setRouter($sm->get('router'))
              ->setRouteMatch($sm->get('routematch'));

        $app = $this->getMockBuilder('Zend\Mvc\Application')->disableOriginalConstructor()->getMock();
        $app->method('getMvcEvent')
            ->willReturn($event);

        $sm->setService('application', $app);

        $navigation = $this->factory->createService($sm);
        $this->assertInstanceOf('Zend\Navigation\Navigation', $navigation);
    }
}
