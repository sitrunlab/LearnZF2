<?php
namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class BasicAuthenticationAdapterFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $authConfig = $config[ 'authentication_basic' ][ 'adapter' ];
        $authAdapter = new HttpAdapter($authConfig[ 'config' ]);

        $basic = new FileResolver();
        $basic->setFile($authConfig[ 'basic' ]);

        $authAdapter->setBasicResolver($basic);

        return $authAdapter;
    }
}