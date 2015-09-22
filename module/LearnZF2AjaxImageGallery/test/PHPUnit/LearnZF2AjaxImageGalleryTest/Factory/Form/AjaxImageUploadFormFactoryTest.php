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

use LearnZF2AjaxImageGallery\Factory\Form\AjaxImageUploadFormFactory;
use PHPUnit_Framework_TestCase;

class AjaxImageUploadFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var AjaxImageUploadFormFactory */
    protected $ajaxImageUploadFormFactory;

    /** @var \Prophecy\Prophecy\ObjectProphecy */
    protected $controllerManager;

    /** @var \Prophecy\Prophecy\ObjectProphecy */
    protected $locator;

    public function setUp()
    {
        $this->controllerManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->locator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');
        $this->controllerManager->getServiceLocator()->willReturn($this->locator);

        $ajaxImageUploadFormFactory = new AjaxImageUploadFormFactory();
        $this->ajaxImageUploadFormFactory = $ajaxImageUploadFormFactory;
    }

    public function testAjaxImageUploadForm()
    {
        $app = $this->prophesize('Zend\Mvc\Application');
        $app->getMvcEvent()->willReturn($this->prophesize('Zend\Mvc\MvcEvent'));

        $this->locator->get('Application')->willReturn($app);

        $form = $this->ajaxImageUploadFormFactory->createService($this->controllerManager->reveal());
        $this->assertInstanceOf('LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm', $form);
    }
}
