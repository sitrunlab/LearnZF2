<?php
namespace LearnZF2Pagination\Factory\View\Helper;

use LearnZF2Pagination\View\Helper\QueryUrl;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryUrlFactory implements FactoryInterface
{
    /**
     * Create service.
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return QueryUrl
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $request = $serviceLocator->getServiceLocator()->get('Request');
        $helper = new QueryUrl($request);

        $router = $serviceLocator->getServiceLocator()->get('Router');
        $match = $serviceLocator->getServiceLocator()->get('Application')->getMvcEvent()->getRouteMatch();

        if ($match instanceof RouteMatch) {
            $helper->setRouteMatch($match);
        }
        $helper->setRouter($router);

        return $helper;
    }
}
