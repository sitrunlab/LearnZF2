<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class SitemapControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );
        parent::setUp();
    }

    public function testGetXmlPage()
    {
        $this->dispatch('/sitemapxml');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Sitemap');
        $this->assertControllerClass('SitemapController');
        $this->assertMatchedRouteName('sitemapxml');

        $this->assertEquals('Content-Type: text/xml', $this->getResponseHeader('Content-Type')->toString());
    }
}
