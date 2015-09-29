<?php

namespace LearnZF2Authentication\Factory;

use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DigestAuthenticationAdapterFactory implements FactoryInterface
{
    /** @var array|object|string $digestConfig */
    private $digestConfig = [];

    /**
     * @param array|object|string $digestConfig
     */
    public function __construct(array $digestConfig = [])
    {
        $this->digestConfig = $digestConfig;
    }

    /**
     * {@inheritdoc}
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
