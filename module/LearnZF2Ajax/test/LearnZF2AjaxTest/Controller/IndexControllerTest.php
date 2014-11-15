<?php

namespace LearnZF2AjaxTest\Controller;

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

    public function testGoToPageWithoutPostRequest()
    {
        $this->dispatch('/learn-zf2-ajax');
        $this->assertQuery('html > head');
    }

    public function testPostDataWithoutAjax()
    {
        $postData = [
            'username' => 'user',
            'password' => 'user123',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData);
        $this->assertQuery('html > head');
    }

    public function testPostInvalidDataWithAjax()
    {
        $postData = [
            'username' => 'user',
            'password' => 'user123',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData, true);
        $request = $this->getRequest();

        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"form":{"1":{},"0":{}},"data":{"result":false,"message":{"username":{"regexNotMatch":"The input does not match against pattern \u0027\/admin\/\u0027"},"password":{"regexNotMatch":"The input does not match against pattern \u0027\/admin\/\u0027"}}}}', $this->getResponse()->getBody());
    }

    public function testPostValidDataWithAjax()
    {
        $postData = [
            'username' => 'admin',
            'password' => 'admin',
        ];
        $this->dispatch('/learn-zf2-ajax', 'POST', $postData, true);
        $request = $this->getRequest();

        $this->assertTrue($request->isXmlHttpRequest());
        $this->assertResponseHeaderContains('Content-Type', 'application/json; charset=utf-8');

        $this->assertEquals('{"form":{"1":{},"0":{}},"data":{"result":true,"message":"Ajax request success"}}', $this->getResponse()->getBody());
    }
}
