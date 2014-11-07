<?php

namespace LearnZF2FormUsage\Factory\Controller;

use LearnZF2FormUsage\Controller\FormController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class FormControllerFactory implements FactoryInterface
{
    /**
     * @{inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $controller = new FormController(
            $sl->getServiceLocator()->get('FormElementManager')->get('LearnZF2FormUsage\Form\LearnZF2Form')
        );

        return $controller;
    }
}
