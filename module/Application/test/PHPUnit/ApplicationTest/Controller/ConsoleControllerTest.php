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

namespace ApplicationTest\Controller;

use Application\Controller\ConsoleController;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Zend\Console\Console;
use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Test as TestAdapter;

class ConsoleControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function setUp()
    {
        $this->httpClient = new HttpClient();
        $this->httpClient->setAdapter(get_class(new TestAdapter()));
        $this->httpClient->setUri('http://www.domain.com/');
    }

    public function testCallGetContributorsOK()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $expected =  "HTTP/1.1 200 OK\r\n\r\n"
            ."[{\"login\":\"samsonasik\",\"id\":459648,\"avatar_url\":\"https://avatars.githubusercontent.com/u/459648?v=3\",\"gravatar_id\":\"\",\"url\":\"https://api.github.com/users/samsonasik\",\"html_url\":\"https://github.com/samsonasik\",\"followers_url\":\"https://api.github.com/users/samsonasik/followers\",\"following_url\":\"https://api.github.com/users/samsonasik/following{/other_user}\",\"gists_url\":\"https://api.github.com/users/samsonasik/gists{/gist_id}\",\"starred_url\":\"https://api.github.com/users/samsonasik/starred{/owner}{/repo}\",\"subscriptions_url\":\"https://api.github.com/users/samsonasik/subscriptions\",\"organizations_url\":\"https://api.github.com/users/samsonasik/orgs\",\"repos_url\":\"https://api.github.com/users/samsonasik/repos\",\"events_url\":\"https://api.github.com/users/samsonasik/events{/privacy}\",\"received_events_url\":\"https://api.github.com/users/samsonasik/received_events\",\"type\":\"User\",\"site_admin\":false,\"contributions\":168},{\"login\":\"acelaya\",\"id\":2719332,\"avatar_url\":\"https://avatars.githubusercontent.com/u/2719332?v=3\",\"gravatar_id\":\"\",\"url\":\"https://api.github.com/users/acelaya\",\"html_url\":\"https://github.com/acelaya\",\"followers_url\":\"https://api.github.com/users/acelaya/followers\",\"following_url\":\"https://api.github.com/users/acelaya/following{/other_user}\",\"gists_url\":\"https://api.github.com/users/acelaya/gists{/gist_id}\",\"starred_url\":\"https://api.github.com/users/acelaya/starred{/owner}{/repo}\",\"subscriptions_url\":\"https://api.github.com/users/acelaya/subscriptions\",\"organizations_url\":\"https://api.github.com/users/acelaya/orgs\",\"repos_url\":\"https://api.github.com/users/acelaya/repos\",\"events_url\":\"https://api.github.com/users/acelaya/events{/privacy}\",\"received_events_url\":\"https://api.github.com/users/acelaya/received_events\",\"type\":\"User\",\"site_admin\":false,\"contributions\":35},{\"login\":\"mockiemockiz\",\"id\":1708946,\"avatar_url\":\"https://avatars.githubusercontent.com/u/1708946?v=3\",\"gravatar_id\":\"\",\"url\":\"https://api.github.com/users/mockiemockiz\",\"html_url\":\"https://github.com/mockiemockiz\",\"followers_url\":\"https://api.github.com/users/mockiemockiz/followers\",\"following_url\":\"https://api.github.com/users/mockiemockiz/following{/other_user}\",\"gists_url\":\"https://api.github.com/users/mockiemockiz/gists{/gist_id}\",\"starred_url\":\"https://api.github.com/users/mockiemockiz/starred{/owner}{/repo}\",\"subscriptions_url\":\"https://api.github.com/users/mockiemockiz/subscriptions\",\"organizations_url\":\"https://api.github.com/users/mockiemockiz/orgs\",\"repos_url\":\"https://api.github.com/users/mockiemockiz/repos\",\"events_url\":\"https://api.github.com/users/mockiemockiz/events{/privacy}\",\"received_events_url\":\"https://api.github.com/users/mockiemockiz/received_events\",\"type\":\"User\",\"site_admin\":false,\"contributions\":33}]";

        $this->httpClient->getAdapter()->setResponse($expected);

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $controller->getcontributorsAction();

        $this->assertContains("samsonasik", file_get_contents('foo.pson'));
        @unlink('foo.pson');
    }

    public function testCallGetContributorsBadRequest()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $expected =  "HTTP/1.1 400 Bad Request\r\n\r\n";
        $this->httpClient->getAdapter()->setResponse($expected);

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $controller->getcontributorsAction();
    }

    public function testZeroLengthReportErrror()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $class = new ReflectionClass('Application\Controller\ConsoleController');
        $method = $class->getMethod('reportError');
        $method->setAccessible(true);

        $method->invokeArgs($controller, array(10, 3, ''));
    }

    public function testExceptionPassedInReportError()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $class = new ReflectionClass('Application\Controller\ConsoleController');
        $method = $class->getMethod('reportError');
        $method->setAccessible(true);

        ob_start();
        $e = new \Exception('foo');
        $method->invokeArgs($controller, array(100, 1, '', $e));
        ob_get_clean();
    }

    public function testZeroLengthReportSuccess()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $class = new ReflectionClass('Application\Controller\ConsoleController');
        $method = $class->getMethod('reportSuccess');
        $method->setAccessible(true);

        $method->invokeArgs($controller, array(10, 3, ''));
    }

    public function testCollectContributorsInfoFailed()
    {
        $adapter = Console::detectBestAdapter();
        $consoleAdapter = new $adapter();

        $controller = new ConsoleController(
            $consoleAdapter,
            [
                'console' => [
                    'contributors' => [
                        'output' => 'foo.pson',
                    ],
                ],
            ],
            $this->httpClient
        );

        $class = new ReflectionClass('Application\Controller\ConsoleController');
        $method = $class->getMethod('collectContributorsInfo');
        $method->setAccessible(true);

        $contributors = [
            0 => [
                'login' => '*samsonasik*',
            ],
        ];

        $method->invokeArgs($controller, array($contributors, 3, 100));
    }
}
