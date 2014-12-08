<?php

namespace Application\Factory\Controller;

use Application\Controller\ContributorsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContributorsControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        return new ContributorsController();
    }
}
