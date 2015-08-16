<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace LearnZF2CaptchaTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use LearnZF2Captcha\Factory\Controller\CaptchaControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var CaptchaControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = $this->getMock('Zend\Mvc\Controller\ControllerManager');
        $this->controllerManager = $controllerManager;

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $controllerManager->expects($this->any())
                          ->method('getServiceLocator')
                          ->willReturn($serviceLocator);

        $factory = new CaptchaControllerFactory();
        $this->factory = $factory;
    }

    public function testCreateServiceWithServiceLocator()
    {
        $this->doTestCreateService($this->serviceLocator);
    }

    public function testCreateServiceWithControllerManager()
    {
        $this->doTestCreateService($this->controllerManager);
    }

    private function doTestCreateService(ServiceLocatorInterface $serviceLocator)
    {
        $config = include __DIR__.'/../../config/captcha.config.php';
        $serviceLocator->expects($this->at(0))
                       ->method('get')
                       ->with('Config')
                       ->willReturn($config);
        $application = $this->getMockBuilder('Zend\Mvc\Application')
                            ->disableOriginalConstructor()
                            ->getMock();
        $mvcEvent = $this->getMockBuilder('Zend\Mvc\MvcEvent')
                            ->disableOriginalConstructor()
                            ->getMock();
        $application->expects($this->once())
                    ->method('getMvcEvent')
                    ->willReturn($mvcEvent);

        $services->expects($this->at(2))
                 ->method('get')
                 ->with('Application')
                 ->willReturn($application);

        $result = $this->factory->createService($serviceLocator);
        $this->assertInstanceOf('LearnZF2Captcha\Controller\CaptchaController', $result);
    }
}
