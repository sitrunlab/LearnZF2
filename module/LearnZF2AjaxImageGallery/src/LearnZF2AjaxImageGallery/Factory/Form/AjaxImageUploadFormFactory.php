<?php

namespace LearnZF2AjaxImageGallery\Factory\Form;

use LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxImageUploadFormFactory implements FactoryInterface
{
    /**
     * @{inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new AjaxImageUploadForm();

        return $form;
    }
}
