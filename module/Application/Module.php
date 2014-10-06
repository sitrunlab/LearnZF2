<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;


class Module  implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    /**
     * @var ServiceManager
     */
    protected $services;

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $application = $e->getApplication();
        $this->services = $application->getServiceManager();

        $eventManager        = $application->getEventManager();
        $eventManager->attach('dispatch', array($this, 'setVarView'), 10);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Set Application variable : view
     */
    public function setVarView(EventInterface $e)
    {
        $router = $this->services->get('router');
        $request = $this->services->get('request');

        $routeMatch = $router->match($request);
        $e->getViewModel()->setVariable('matchroutename', $routeMatch->getMatchedRouteName());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
