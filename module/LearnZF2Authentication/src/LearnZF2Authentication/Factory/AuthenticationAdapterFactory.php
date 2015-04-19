<?php
namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class AuthenticationAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $authConfig = $config['authentication']['adapter'];
        $authAdapter = new HttpAdapter($authConfig['config']);

        $basic = new FileResolver();
        $digest = new FileResolver();

        $basic->setFile($authConfig['basic']);
        $digest->setFile($authConfig['digest']);

        $authAdapter->setBasicResolver($basic);
        $authAdapter->setDigestResolver($digest);

        return $authAdapter;
    }
}

?>