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

namespace LearnZF2AuthenticationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Stdlib\Parameters;
use test\Bootstrap;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    /** @var serviceManager $serviceManager */
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        $this->serviceManager = Bootstrap::getServiceManager();
        parent::setUp();
    }

    public function testAccessIndexAction()
    {
        $this->dispatch('/learn-zf2-authentication');

        $this->assertModuleName('LearnZF2Authentication');
        $this->assertControllerName('LearnZF2Authentication\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('learn-zf2-authentication');
    }

    public function testAccessBasicAction()
    {
        $this->getRequest()
        ->setMethod('POST')
        ->setPost(new Parameters(array('username' => 'basic', 'realm' => "authentication")));

        $this->dispatch('/learn-zf2-authentication/basic');
        $authAdapter = $this->serviceManager->get('LearnZF2Authentication\BasicAuthenticationAdapter');
        $authAdapter->setRequest($this->getRequest());
        $authAdapter->setResponse($this->getResponse());
        $result = $authAdapter->authenticate();
        $this->assertRedirectTo('/learn-zf2-authentication/basic');

    }

    public function testAccessDigestAction()
    {
        $this->getRequest()
        ->setMethod('POST')
        ->setPost(new Parameters(array('username' => 'digest', 'realm' => "authentication")));

        $this->dispatch('/learn-zf2-authentication/digest');
        $authAdapter = $this->serviceManager->get('LearnZF2Authentication\DigestAuthenticationAdapter');
        $authAdapter->setRequest($this->getRequest());
        $authAdapter->setResponse($this->getResponse());
        $result = $authAdapter->authenticate();
        $this->assertRedirectTo('/learn-zf2-authentication/digest');
    }
}
