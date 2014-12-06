<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class Module  implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;
    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $this->services = $e->getApplication()->getServiceManager();

        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
        $eventManager->attach(MvcEvent::EVENT_RENDER, [$this, 'onRender']);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Handle layout on 'dispatch' event
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $activeController = $routeMatch->getParam('controller');

        if ($activeController != 'Application\Controller\Index') {
            $controller = $e->getTarget();
            $controller = $e->getTarget();
            $controller->layout('layout/2columns');

            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            if (!$e->getViewModel() instanceof JsonModel) {
                $e->getViewModel()->setVariable('modulenamespace', $moduleNamespace);
            }
        }
    }

    /**
     * Set variable layout on 'render' event
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function onRender(MvcEvent $e)
    {
        if (!$e->getViewModel() instanceof JsonModel) {
            $entityManager = $this->services->get('Doctrine\ORM\EntityManager');
            $e->getViewModel()
              ->setVariable('modules_list', $entityManager->getRepository('Application\Entity\ModuleList')->findAll());
        }
    }

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ],
            ],
        ];
    }
}
