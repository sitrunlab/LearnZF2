<?php

namespace LearnZF2FormUsageTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include  dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/learn-zf2-form-usage');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('LearnZF2FormUsage');
        $this->assertControllerName('LearnZF2FormUsage\Controller\Form');
        $this->assertControllerClass('FormController');
        $this->assertMatchedRouteName('learn-zf2-form-usage');
    }
}
