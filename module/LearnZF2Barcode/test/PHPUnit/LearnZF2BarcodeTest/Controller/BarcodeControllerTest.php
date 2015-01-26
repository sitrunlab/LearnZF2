<?php

namespace LearnZF2BarcodeTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class BarcodeControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/learn-zf2-barcode');
        $this->assertResponseStatusCode(200);
    }

    public function testPostData()
    {
        $postData = [
            'barcode-object-text' => '123456789',
            'barcode-object-select' => 'codabar',
        ];
        $this->dispatch('/learn-zf2-barcode', 'POST', $postData);

        $this->assertFileExists('./data/barcode.gif');
    }

    public function testAccessBarcodeImageWithoutAccessForm()
    {
        @unlink('./data/barcode.gif');

        $this->dispatch('/learn-zf2-barcode/getbarcodeimage');
        $this->assertResponseHeaderContains('Content-Type', 'text/html');
    }

    public function testAccessBarcodeImageWithccessFormBefore()
    {
        $postData = [
            'barcode-object-text' => '123456789',
            'barcode-object-select' => 'codabar',
        ];
        $this->dispatch('/learn-zf2-barcode', 'POST', $postData);

        $this->dispatch('/learn-zf2-barcode/getbarcodeimage');
        $this->assertResponseHeaderContains('Content-Type', 'image/gif');
    }
}
