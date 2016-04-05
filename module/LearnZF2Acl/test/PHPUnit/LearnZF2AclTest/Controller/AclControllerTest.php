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
namespace LearnZF2AclTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AclControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testAccessIndexAction()
    {
        $this->dispatch('/learn-zf2-acl');

        $this->assertModuleName('LearnZF2Acl');
        $this->assertControllerName('LearnZF2Acl\Controller\Acl');
        $this->assertControllerClass('AclController');
        $this->assertMatchedRouteName('learn-zf2-acl');
    }

    /**
     * @return array
     */
    public function provideValidRole()
    {
        return [
            [0, '"RegisterUser"'],
            [1, 'EditUser"'],
            [2, '"AddUser"'],
        ];
    }

    /**
     * @dataProvider provideValidRole
     */
    public function testPostData($roleId, $responseJson)
    {
        $postData = [
            'roleId' => $roleId,
        ];
        $this->dispatch('/learn-zf2-acl/listresourcesandrights', 'POST', $postData);
        $response = $this->getResponse();

        $this->assertContains($responseJson, $response->getBody());
    }
}
