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

namespace LearnZF2AjaxImageGalleryTest\Factory\Controller;

use LearnZF2AjaxImageGallery\Factory\Controller\IndexControllerFactory;
use PHPUnit_Framework_TestCase;

class IndexControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var IndexControllerFactory */
    protected $indexControllerFactory;

    /** @var \Prophecy\Prophecy\ObjectProphecy */
    protected $indexControllerManager;

    /** @var \Prophecy\Prophecy\ObjectProphecy */
    protected $serviceLocator;

    public function setUp()
    {
        $this->indexControllerManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->serviceLocator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');
        $this->indexControllerManager->getServiceLocator()->willReturn($this->serviceLocator);

        $indexControllerFactory = new IndexControllerFactory();
        $this->indexControllerFactory = $indexControllerFactory;
    }

    public function testReturnIndexControllerFromFactory()
    {
        $formElementManager = $this->prophesize('Zend\Form\FormElementManager');
        $ajaxImageUploadForm = $this->prophesize('LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm');
        $formElementManager->get('LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm')->willReturn($ajaxImageUploadForm);
        $this->serviceLocator->get('FormElementManager')->willReturn($formElementManager);

        $controller = $this->indexControllerFactory->__invoke($this->indexControllerManager->reveal());
        $this->assertInstanceOf('LearnZF2AjaxImageGallery\Controller\IndexController', $controller);
    }
}
