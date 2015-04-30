<?php

namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

class DigestAuthenticationAdapterFactory implements FactoryInterface
{
    /** @var array|object|string $digestConfig */
    private $digestConfig = array();

    /**
     * @param array|object|string $digestConfig
     */
    public function __construct(array $digestConfig = array())
    {
        $this->digestConfig = $digestConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $digestServiceLocator)
    {
        if (empty($this->digestConfig)) {
            $this->digestConfig = $digestServiceLocator->get('Config');
        }

        $authDigestConfig = $this->digestConfig['authentication_digest']['adapter'];
        $authDigestAdapter = new HttpAdapter($authDigestConfig['config']);

        $digest = new FileResolver();
        $digest->setFile($authDigestConfig['digest']);

        $authDigestAdapter->setDigestResolver($digest);

        return $authDigestAdapter;
    }
}
