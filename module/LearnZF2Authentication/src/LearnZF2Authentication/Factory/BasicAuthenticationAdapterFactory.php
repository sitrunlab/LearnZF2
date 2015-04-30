<?php

namespace LearnZF2Authentication\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\Http as HttpAdapter;
use Zend\Authentication\Adapter\Http\FileResolver;

/**
 * @author Stanimir Dimitrov Dimitrov <stanimirdim92@gmail.com>
 */
class BasicAuthenticationAdapterFactory implements FactoryInterface
{
    /** @var array|object|string $basicConfig */
    private $basicConfig = array();

    /**
     * @param array|object|string $basicConfig
     */
    public function __construct(array $basicConfig = array())
    {
        $this->basicConfig = $basicConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $basicServiceLocator)
    {
        if (empty($this->basicConfig)) {
            $this->basicConfig = $basicServiceLocator->get('Config');
        }

        $authBasicConfig = $this->basicConfig['authentication_basic']['adapter'];
        $authBasicAdapter = new HttpAdapter($authBasicConfig['config']);

        $basic = new FileResolver();
        $basic->setFile($authBasicConfig['basic']);

        $authBasicAdapter->setBasicResolver($basic);

        return $authBasicAdapter;
    }
}