<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class DownloadControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testDownloadUrlWithoutModuleParamReturnsHtml()
    {
        $this->dispatch('/download');
        $this->assertQuery('html > head');
    }

    public function testDownloadUrlWithModuleNotRegisteredParamReturnsHtml()
    {
        $this->dispatch('/download/abc');
        $this->assertQuery('html > head');
    }

    public function testDownloadUrlWithModuleRegisteredParamReturnsResponse()
    {
        $this->dispatch('/download/LearnZF2FormUsage');
        $this->assertHasResponseHeader('Content-Disposition');
    }
}
