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

namespace LearnZF2ThemesTest\Controller;

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

    public function testIndexAction()
    {
        $this->dispatch('/learn-zf2-themes');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('LearnZF2Themes');
        $this->assertControllerName('LearnZF2Themes\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('learn-zf2-themes');
    }

    public function testActivateThemeWithNameDefault()
    {
        $postData = [
            'themeName' => 'default',
        ];

        $this->dispatch('/learn-zf2-themes', 'POST', $postData);
        $this->assertQueryContentContains('div.col-lg-9 > h2', 'Default theme');
    }

    public function testActivateThemeWithNameBlueTheme()
    {
        $postData = [
            'themeName' => 'blue-theme',
        ];

        $this->dispatch('/learn-zf2-themes', 'POST', $postData);
        $this->assertQueryContentContains('div.col-lg-9 > h2', 'Blue theme');
    }

    public function testActivateThemeWithNameRedTheme()
    {
        $postData = [
            'themeName' => 'red-theme',
        ];

        $this->dispatch('/learn-zf2-themes', 'POST', $postData);
        $this->assertQueryContentContains('div.col-lg-9 > h2', 'Red theme');
    }
}
