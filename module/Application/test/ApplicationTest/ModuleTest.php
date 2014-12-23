<?php

namespace ApplicationTest;

use Application\Module;
use PHPUnit_Framework_TestCase;
use Zend\Console\Console;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    public function setUp()
    {
        $this->module = new Module();
    }

    public function testGetConsoleUsage()
    {
        $expected = [
            'get contributors' => 'get contributors list',
        ];
        $consoleAdapter = Console::detectBestAdapter();
        $this->assertEquals($expected, $this->module->getConsoleUsage(new $consoleAdapter()));
    }
}
