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
namespace LearnZF2CaptchaTest\Factory\Form;

use LearnZF2Captcha\Factory\Form\CaptchaFormFactory;
use PHPUnit_Framework_TestCase;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class CaptchaFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var CaptchaFormFactory */
    protected $factory;

    /** @var FormElementManager */
    protected $formElementManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        $this->formElementManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->serviceLocator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');

        $this->formElementManager->getServiceLocator()->willReturn($this->serviceLocator);

        $factory = new CaptchaFormFactory();
        $this->factory = $factory;
    }

    public function provideCaptchaAdapterKeys()
    {
        return [
            [0],
            [1],
            [2],
        ];
    }

    /**
     * @dataProvider provideCaptchaAdapterKeys
     */
    public function testCreateService($captchaAdapterKey)
    {
        $config = include __DIR__.'/../../../../../config/captcha.config.php';
        $this->serviceLocator->get('Config')
                             ->willReturn($config);

        $application = $this->prophesize('Zend\Mvc\Application');
        $mvcEvent = $this->prophesize('Zend\Mvc\MvcEvent');
        $application->getMvcEvent()->willReturn($mvcEvent);
        $request = $this->prophesize('Zend\Http\PhpEnvironment\Request');
        $request->getQuery('captcha_adapter', 0)->willReturn($captchaAdapterKey);
        $mvcEvent->getRequest()->willReturn($request);

        $this->serviceLocator->get('Application')->willReturn($application);

        $result = $this->factory->createService($this->formElementManager->reveal());
        $this->assertInstanceOf('LearnZF2Captcha\Form\CaptchaForm', $result);
    }
}
