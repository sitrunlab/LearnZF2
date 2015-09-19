<?php

namespace LearnZF2AjaxImageGallery\Factory\Controller;

use LearnZF2AjaxImageGallery\Controller\IndexController;
use Zend\Mvc\Controller\ControllerManager;

class IndexControllerFactory
{
    /**
     * @{inheritDoc}
     */
    public function __invoke(ControllerManager $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        $controller = new IndexController(
            (object) $serviceLocator->get('FormElementManager')->get('LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm')
        );

        return $controller;
    }
}
