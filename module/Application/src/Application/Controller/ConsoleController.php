<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Console\ColorInterface as Color;
use Zend\Http\Client as HttpClient;

/**
 * Console controller to get contributor list
 * inspired and almost all code copied from https://github.com/zendframework/zf-web/blob/master/module/Application/src/Application/Controller/ConsoleController.php
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
     * Construct console and config property
     */
    public function __construct(Console $console, array $config, HttpClient $httpClient)
    {
        $this->console = $console;
        $this->config  = $config;

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
     * route : get contributors
     */
    public function getcontributorsAction()
    {
        $width = $this->console->getWidth();
        $this->console->writeLine('Fetching GitHub Contributors', Color::GREEN);

        $this->httpClient->setUri('https://api.github.com/repos/sitrunlab/LearnZF2/contributors');

        $response = $this->httpClient->send();
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode().': '.$response->getReasonPhrase();
            $this->reportError($width, 0, $message);

            return;
        }

        $body         = $response->getBody();
        $contributors = json_decode($body, true);
        $total        = count($contributors);

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
            $body     = $response->getBody();
            $userInfo = json_decode($body, 1);
            $contributors[$i]['user_info'] = $userInfo;
            $this->reportSuccess($width, strlen($message));
        }

        $this->console->writeLine(str_repeat('-', $width));
        $message = 'Writing file';
        $this->console->write($message, Color::BLUE);
        $path = $this->config['console']['contributors']['output'];
        file_put_contents($path, serialize($contributors));
        $this->reportSuccess($width, strlen($message));
        $this->console->writeLine(sprintf('File written to %s', $path));
    }
}
