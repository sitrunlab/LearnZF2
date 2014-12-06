<?php
namespace LearnZF2Pagination\Factory\View\Helper;

use LearnZF2Pagination\View\Helper\QueryUrl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryUrlFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $request = $serviceLocator->get('Request');
        $router = $serviceLocator->get('Router');
        $helper = new QueryUrl($request);
        $helper->setRouter($router);
        return $helper;
    }
}
