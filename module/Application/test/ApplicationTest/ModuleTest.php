<?php

namespace ApplicationTest;

use Application\Controller\DownloadController;
use Application\Entity\ModuleList;
use Application\Module;
use Doctrine\ORM\Tools\EntityRepositoryGenerator;
use PHPUnit_Framework_TestCase;
use Zend\Console\Console;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Console\RouteMatch;
use Zend\Mvc\Service\ViewHelperManagerFactory;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\HeadTitle;
use Zend\View\HelperPluginManager;
use Zend\View\Model\ViewModel;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * @var ServiceManager
     */
    protected $sm;

    public function setUp()
    {
        $this->sm = new ServiceManager();
        $this->module = new Module();

        // Initialize private services property by using reflection
        $class = new \ReflectionClass('Application\Module');
        $smProperty = $class->getProperty('services');
        $smProperty->setAccessible(true);
        $smProperty->setValue($this->module, $this->sm);
    }

    public function testGetConsoleUsage()
    {
        $expected = [
            'get contributors' => 'get contributors list',
        ];
        $consoleAdapter = Console::detectBestAdapter();
        $this->assertEquals($expected, $this->module->getConsoleUsage(new $consoleAdapter()));
    }

    public function testOnDispatch()
    {
        // Create MvcEvent
        $e = new MvcEvent();
        $e->setViewModel(new ViewModel());
        $rm = new RouteMatch([]);
        $rm->setParam('controller', 'Application\Controller\Download');
        $e->setRouteMatch($rm);
        $e->setTarget(new DownloadController([]));

        // Create EntityManager and EntityRepository
        $moduleDetail = new ModuleList();
        $moduleDetail->setModuleDesc('Pretty description');
        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
                     ->disableOriginalConstructor()
                     ->getMock();
        $repo->expects($this->any())
             ->method('findOneBy')
             ->willReturn($moduleDetail);
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                   ->disableOriginalConstructor()
                   ->getMock();
        $em->expects($this->any())
           ->method('getRepository')
           ->willReturn($repo);
        $this->sm->setService('Doctrine\ORM\EntityManager', $em);

        // Create ViewHelperManager
        $headTitle = new HeadTitle();
        $vhm = new HelperPluginManager();
        $vhm->setService('headTitle', $headTitle);
        $this->sm->setService('ViewHelperManager', $vhm);

        $this->module->onDispatch($e);
        $fbMeta = $e->getViewModel()->getVariable('fbMeta');
        $this->assertEquals(sprintf('%s-Real Live Learn ZF2', $moduleDetail->getModuleDesc()), $fbMeta['title']);
        $this->assertEquals(sprintf('%s-', $moduleDetail->getModuleDesc()), $fbMeta['description']);
    }
}
