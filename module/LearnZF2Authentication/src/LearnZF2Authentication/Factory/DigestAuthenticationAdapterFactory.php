<?php

namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class DigestAuthenticationAdapterFactory implements FactoryInterface
{
    /**
     * @var array $config
     */
    private $config = array();

    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (empty($this->config)) {
            $this->config = $serviceLocator->get('Config');
        }

        $authConfig = $this->config['authentication_digest']['adapter'];
        $authAdapter = new HttpAdapter($authConfig['config']);

        $digest = new FileResolver();
        $digest->setFile($authConfig['digest']);

        $authAdapter->setDigestResolver($digest);

        return $authAdapter;
    }
}
