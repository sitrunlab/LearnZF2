<?php

namespace LearnZF2Ajax\Factory\Controller;

use LearnZF2Ajax\Controller\UploadController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class UploadControllerFactory implements FactoryInterface
{
    /**
     * @{inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $controller = new UploadController(
            $sl->getServiceLocator()->get('FormElementManager')->get('LearnZF2Ajax\Form\UploadForm')
        );

        return $controller;
    }
}
