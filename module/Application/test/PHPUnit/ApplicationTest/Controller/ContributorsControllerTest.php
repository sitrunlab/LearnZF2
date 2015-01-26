<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ContributorsControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );
        parent::setUp();
    }

    public function testcontributorspagewithIndexActionBeAccessed()
    {
        $this->dispatch('/contributors');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Contributors');
        $this->assertControllerClass('ContributorsController');
        $this->assertMatchedRouteName('contributors');
    }
}
