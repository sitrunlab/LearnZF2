<?php

namespace LearnZF2Barcode\Factory\Controller;

use LearnZF2Barcode\Controller\BarcodeController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class BarcodeControllerFactory implements FactoryInterface
{
    /**
     * @{inheritDoc}
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $controller = new BarcodeController(
            $sl->getServiceLocator()->get('FormElementManager')->get('LearnZF2Barcode\Form\BarcodeForm')
        );

        return $controller;
    }
}
