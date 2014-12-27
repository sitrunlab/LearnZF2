<?php

namespace Application\Factory\Controller;

use Application\Controller\DownloadController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DownloadControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $moduleList = [];
        foreach ($services->get('Doctrine\ORM\EntityManager')
                               ->getRepository('Application\Entity\ModuleList')
                               ->findAll() as $module) {
            $moduleList[] = $module->getModuleName();
        }

        return new DownloadController($moduleList);
    }
}
