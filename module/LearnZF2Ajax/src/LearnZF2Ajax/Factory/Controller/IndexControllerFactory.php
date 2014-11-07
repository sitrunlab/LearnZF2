<?php

namespace LearnZF2Ajax\Factory\Controller;

use LearnZF2Ajax\Controller\IndexController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @{inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $controller = new IndexController(
            $sl->getServiceLocator()->get('FormElementManager')->get('LearnZF2Ajax\Form\LoginForm')
        );
        return $controller;
    }
}
