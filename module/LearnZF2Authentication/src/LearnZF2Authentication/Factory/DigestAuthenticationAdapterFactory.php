<?php
namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class DigestAuthenticationAdapterFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $authConfig = $config['authentication_digest']['adapter'];
        $authAdapter = new HttpAdapter($authConfig['config']);

        $digest = new FileResolver();
        $digest->setFile($authConfig['digest']);

        $authAdapter->setDigestResolver($digest);

        return $authAdapter;
    }
}