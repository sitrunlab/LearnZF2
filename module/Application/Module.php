<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


class Module  implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch']);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Handle layout on 'dispatch' event
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onDispatch(MvcEvent $e) {
        $routeMatch = $e->getRouteMatch();
        $activeController = $routeMatch->getParam('controller');

        if($activeController!='Application\Controller\Index') {
            $controller = $e->getTarget();
            $controller->layout('layout/2columns');
        }
    }

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }
}
