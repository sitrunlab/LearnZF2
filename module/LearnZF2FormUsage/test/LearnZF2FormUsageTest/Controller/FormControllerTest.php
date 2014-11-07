<?php

namespace LearnZF2FormUsageTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class FormControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/config/application.config.php'
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

    public function testPostValidData()
    {
        $postData = [
            'id' => null,
            'name' => 'ikhsan',
            'gender' => 2,
            'hobby' => [
                0 => 1
            ],
            'email' => 'foo@bar.com',
            'birth' => '2008-10-01',
            'address' => 'jalan jalan',
            'direction' => 1
        ];
        $this->dispatch('/learn-zf2-form-usage', 'POST', $postData);
        $this->assertQueryContentContains('h3', 'Success!');
    }

    public function testPostInValidData()
    {
        $postData = [
            'id' => null,
            'name' => null,
            'gender' => 2,
            'hobby' => [
                0 => 1
            ],
            'email' => 'foo@bar.com',
            'birth' => '2008-10-01',
            'address' => 'jalan jalan',
            'direction' => 1
        ];
        $this->dispatch('/learn-zf2-form-usage', 'POST', $postData);
        $this->assertQueryContentContains('li', 'Value is required and can\'t be empty');
    }
}
