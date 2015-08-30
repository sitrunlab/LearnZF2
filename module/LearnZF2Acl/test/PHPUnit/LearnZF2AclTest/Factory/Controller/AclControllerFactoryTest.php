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

namespace LearnZF2AclTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use LearnZF2Acl\Factory\Controller\AclControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var AclControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        $this->controllerManager = $this->prophesize('Zend\Mvc\Controller\ControllerManager');
        $this->serviceLocator    = $this->prophesize('Zend\ServiceManager\ServiceLocatorInterface');

        $this->controllerManager->getServiceLocator()->willReturn($this->serviceLocator);

        $factory = new AclControllerFactory();
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $aclmock = $this->prophesize('LearnZF2Acl\Model\Acl');
        $this->serviceLocator->get('aclmodel')->willReturn($aclmock);

        $result = $this->factory->createService($this->controllerManager->reveal());
        $this->assertInstanceOf('LearnZF2Acl\Controller\AclController', $result);
    }
}
