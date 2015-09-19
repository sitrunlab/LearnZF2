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

namespace LearnZF2AjaxImageGalleryTest\Factory\Form;

use PHPUnit_Framework_TestCase;
use LearnZF2AjaxImageGallery\Factory\Form\AjaxImageUploadFormFactory;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxImageUploadFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var AjaxImageUploadFormFactory */
    protected $factory;

    /** @var Prophecy\Prophecy\ObjectProphecy */
    protected $formElementManager;

    /** @var Prophecy\Prophecy\ObjectProphecy */
    protected $serviceLocator;

    public function setUp()
    {
        $this->formElementManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->serviceLocator     = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');

        $this->formElementManager->getServiceLocator()->willReturn($this->serviceLocator);

        $factory = new AjaxImageUploadFormFactory();
        $this->factory = $factory;
    }

    public function testReturnsAjaxImageUploadFormFromFactory()
    {
        $application = $this->prophesize('Zend\Mvc\Application');
        $mvcEvent    = $this->prophesize('Zend\Mvc\MvcEvent');
        $application->getMvcEvent()->willReturn($mvcEvent);
 
        $this->serviceLocator->get('Application')->willReturn($application);

        $form = $this->factory->createService($this->formElementManager->reveal());
        $this->assertInstanceOf('LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm', $form);
    }

}
