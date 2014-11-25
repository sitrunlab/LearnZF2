<?php

namespace LearnZF2BarcodeTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testIn()
    {
        $this->assertTrue(true);
    }
}
