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

namespace LearnZF2LogTest\Factory\Controller;

use LearnZF2Log\Factory\Controller\IndexControllerFactory;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var IndexControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        $this->controllerManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->serviceLocator = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');

        $this->controllerManager->getServiceLocator()->willReturn($this->serviceLocator);

        $factory = new IndexControllerFactory();
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $mockFormElementManager = $this->prophesize('Zend\Form\FormElementManager');
        $this->serviceLocator->get('FormElementManager')->willReturn($mockFormElementManager);
        $mockLogForm = $this->prophesize('LearnZF2Log\Form\LogForm');
        $mockFormElementManager->get('LearnZF2Log\Form\LogForm')->willReturn($mockLogForm);

        $result = $this->factory->createService($this->controllerManager->reveal());
        $this->assertInstanceOf('LearnZF2Log\Controller\IndexController', $result);
    }
}
