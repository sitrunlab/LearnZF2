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
    /**
     * @var array|object|string $basicConfg
     */
    private $basicConfg = array();

    /**
     * @param array|object|string $basicConfg
     */
    public function __construct(array $basicConfg = array())
    {
        $this->basicConfg = $basicConfg;
    }

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $basicServiceLocator)
    {
        if (empty($this->basicConfg)) {
            $this->basicConfg = $basicServiceLocator->get('Config');
        }

        $authBasicConfig = $this->basicConfg['authentication_basic']['adapter'];
        $authBasicAdapter = new HttpAdapter($authBasicConfig['config']);

        $basic = new FileResolver();
        $basic->setFile($authBasicConfig['basic']);

        $authBasicAdapter->setBasicResolver($basic);

        return $authBasicAdapter;
    }
}
