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

namespace LearnZF2AuthenticationTest\Factory;

use PHPUnit_Framework_TestCase;
use LearnZF2Authentication\Factory\BasicAuthenticationAdapterFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use test\Bootstrap;

class BasicAuthenticationAdapterFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var BasicAuthenticationAdapterFactory */
    protected $basicFactory;

    /** @var ServiceLocatorInterface */
    protected $basicServiceLocator;

    /** @var ServiceManager */
    protected $basicServiceManager;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $basicServiceLocator */
        $this->basicServiceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        /** @var ServiceManager $basicServiceManager */
        $this->basicServiceManager = Bootstrap::getServiceManager();

        /** @var BasicAuthenticationAdapterFactory $basicFactory */
        $this->basicFactory = new BasicAuthenticationAdapterFactory($this->basicServiceManager->get('Config'));
    }

    public function testCreateBasicService()
    {
        $basic = $this->basicFactory->createService($this->basicServiceLocator);
        $this->assertInstanceOf('Zend\Authentication\Adapter\Http', $basic);
    }
}
