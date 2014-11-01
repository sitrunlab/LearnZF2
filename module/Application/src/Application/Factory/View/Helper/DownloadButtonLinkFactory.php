<?php

namespace Application\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\View\Helper\DownloadButtonLink;

class DownloadButtonLinkFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        return new DownloadButtonLink($services->get('Application')->getMvcEvent());
    }
}
