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

use test\Bootstrap;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

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

    protected function basicAuthAdapter()
    {
        $this->dispatch('/learn-zf2-authentication/basic');
        $basicAuthAdapter = $this->serviceManager->get('LearnZF2Authentication\BasicAuthenticationAdapter');
        $basicAuthAdapter->setRequest($this->getRequest());
        $basicAuthAdapter->setResponse($this->getResponse());

        return $basicAuthAdapter->authenticate();
    }

    protected function digestAuthAdapter()
    {
        $this->dispatch('/learn-zf2-authentication/digest');
        $digestAuthAdapter = $this->serviceManager->get('LearnZF2Authentication\DigestAuthenticationAdapter');
        $digestAuthAdapter->setRequest($this->getRequest());
        $digestAuthAdapter->setResponse($this->getResponse());

        return $digestAuthAdapter->authenticate();
    }

    public function testAccessIndexAction()
    {
        $this->dispatch('/learn-zf2-authentication');

        $this->assertModuleName('LearnZF2Authentication');
        $this->assertControllerName('LearnZF2Authentication\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('learn-zf2-authentication');
    }

    public function testSuccessBasicAction()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Authorization', 'Basic YmFzaWM6c3Ryb25ncGFzc3dvcmQ=');
        $basicSuccess = $this->basicAuthAdapter();
        $this->assertArrayHasKey('username', $basicSuccess->getIdentity());
        $this->assertArrayHasKey('realm', $basicSuccess->getIdentity());
    }

    public function testErrorBasicAction()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Authorization', 'Basic s64g6fs4h7j3dg3mk7gcj6g5fy=');
        $basicError = $this->basicAuthAdapter();
        $this->assertEquals('Invalid or absent credentials; challenging client', $basicError->getMessages()[0]);
    }

    public function testErrorDigestAction()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Authorization', 'Digest username="digest", realm="authentication", nonce="84d6e21677c33887f3dad809", uri="/learn-zf2-authentication/digest", algorithm=MD5, response="7c86f860b6714c74cc966", opaque="e6bf6992a5479102cc787bc9", qop=auth, nc=00000001, cnonce="fd60c8e82cb');
        $digestError = $this->digestAuthAdapter();
        $this->assertEquals('Invalid Authorization header format', $digestError->getMessages()[0]);
    }
}
