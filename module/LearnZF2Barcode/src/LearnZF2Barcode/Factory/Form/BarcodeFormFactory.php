<?php

namespace LearnZF2Barcode\Factory\Form;

use LearnZF2Barcode\Form\BarcodeForm;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class BarcodeFormFactory implements FactoryInterface
{
    /**
    * @{inheritDoc}
    */
    public function createService(ServiceLocatorInterface $sl)
    {
        $form = new BarcodeForm(
            $sl->getServiceLocator()->get('BarcodeObjectPluginManager')->getRegisteredServices()['invokableClasses']
        );

        return $form;
    }
}
