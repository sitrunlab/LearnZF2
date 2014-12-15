<?php

namespace Application\Factory\Controller;

use Application\Controller\ConsoleController;
use Zend\Http\Client as HttpClient;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConsoleControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');
        $client->setUri('https://api.github.com/repos/sitrunlab/LearnZF2/contributors');

        return new ConsoleController(
            $services->get('Console'),
            $services->get('Config'),
            $client
        );
    }
}
