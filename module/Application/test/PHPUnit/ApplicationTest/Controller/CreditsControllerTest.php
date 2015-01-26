<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CreditsControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );
        parent::setUp();
    }

    public function testCreditPageWithIndexActionCanBeAccessed()
    {
        $this->dispatch('/credits');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Credits');
        $this->assertControllerClass('CreditsController');
        $this->assertMatchedRouteName('credits');
    }
}
