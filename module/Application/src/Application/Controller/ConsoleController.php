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

/**
 * This modified only, comes from https://github.com/zendframework/zf-web/blob/master/module/Application/src/Application/Controller/ConsoleController.php.
 */

namespace Application\Controller;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as Color;
use Zend\Http\Client as HttpClient;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * Console controller to get contributor list.
 */
class ConsoleController extends AbstractConsoleController
{
    /**
     * @var Console
     */
    protected $console;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Construct console and config property.
     */
    public function __construct(Console $console, array $config, HttpClient $httpClient)
    {
        $this->console = $console;
        $this->config = $config;

        $this->httpClient = $httpClient;
    }

    protected function reportError($width, $length, $message, $e = null)
    {
        if (($length + 9) > $width) {
            $this->console->writeLine('');
            $length = 0;
        }
        $spaces = $width - $length - 9;
        $this->console->writeLine(str_repeat('.', $spaces).'[ ERROR ]', Color::RED);
        $this->console->writeLine($message);
        if ($e) {
            $this->console->writeLine($e->getTraceAsString());
        }
    }

    protected function reportSuccess($width, $length)
    {
        if (($length + 8) > $width) {
            $this->console->writeLine('');
            $length = 0;
        }
        $spaces = $width - $length - 8;
        $this->console->writeLine(str_repeat('.', $spaces).'[ DONE ]', Color::GREEN);
    }

    /**
     * Collect contributors info.
     *
     * @param array $contributors
     * @param int   $total
     * @param int   $width
     *
     * @return array
     */
    protected function collectContributorsInfo($contributors, $total, $width)
    {
        foreach ($contributors as $i => $contributor) {
            $message = sprintf('    Processing %d/%d', $i, $total);
            $this->console->write($message);
            $this->httpClient->setUri("https://api.github.com/users/{$contributor['login']}");
            $response = $this->httpClient->send();
            if (!$response->isSuccess()) {
                // report failure
                $error = $response->getStatusCode().': '.$response->getReasonPhrase();
                $this->reportError($width, strlen($message), $error);
            }
            $body = $response->getBody();
            $userInfo = json_decode($body, 1);
            $contributors[$i]['user_info'] = $userInfo;
            $this->reportSuccess($width, strlen($message));
        }

        return $contributors;
    }

    /**
     * route : get contributors.
     */
    public function getcontributorsAction()
    {
        $width = $this->console->getWidth();
        $this->console->writeLine('Fetching GitHub Contributors', Color::GREEN);

        $response = $this->httpClient->send();
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode().': '.$response->getReasonPhrase();
            $this->reportError($width, 0, $message);

            return;
        }

        $body = $response->getBody();
        $contributors = json_decode($body, true);
        $total = count($contributors);

        $contributors = $this->collectContributorsInfo($contributors, $total, $width);

        $this->console->writeLine(str_repeat('-', $width));
        $message = 'Writing file';
        $this->console->write($message, Color::BLUE);
        $path = $this->config['console']['contributors']['output'];
        file_put_contents($path, serialize($contributors));
        $this->reportSuccess($width, strlen($message));
        $this->console->writeLine(sprintf('File written to %s', $path));
    }
}
