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
namespace LearnZF2AjaxTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testGoToPageWithoutPostRequest()
    {
        $this->dispatch('/learn-zf2-ajax');
        $this->assertQuery('html > head');
    }

    public function testPostDataWithoutAjax()
    {
        $postData = [
            'username' => 'user',
            'password' => 'user123',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData);
        $this->assertQuery('html > head');
    }

    public function testPostInvalidDataWithAjax()
    {
        $postData = [
            'username' => 'user',
            'password' => 'user123',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData, true);
        $request = $this->getRequest();

        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"form":{"username":{},"password":{}},"data":{"result":false,"message":{"username":{"regexNotMatch":"The input does not match against pattern \u0027\/admin\/\u0027"},"password":{"regexNotMatch":"The input does not match against pattern \u0027\/admin\/\u0027"}}}}', $this->getResponse()->getBody());
    }

    public function testPostValidDataWithAjax()
    {
        $postData = [
            'username' => 'admin',
            'password' => 'admin',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData, true);
        $request = $this->getRequest();

        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"form":{"username":{},"password":{}},"data":{"result":true,"message":"Ajax request success"}}', $this->getResponse()->getBody());
    }
}
