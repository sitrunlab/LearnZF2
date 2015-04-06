<?php
namespace LearnZF2PaginationTest\Controller;

use LearnZF2Pagination\Controller\IndexController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/config/application.config.php'
        );

        parent::setUp();
    }

    public function testDispatchWithourQueryParams()
    {
        $this->dispatchRoute();
        $this->assertQueryCount('tbody > tr', IndexController::ITEM_PER_PAGE);

        // Last page has only 2 results
        $this->dispatchRoute('GET', ['page' => 50]);
        $this->assertQueryCount('tbody > tr', 2);
    }

    public function testDispatchWithCategory()
    {
        $this->dispatchRoute('GET', ['category' => 'music']);
        $body = $this->getResponse()->getContent();
        // Assert there is a selected option
        $this->assertGreaterThan(0, strpos($body, 'selected'));
    }

    public function testDispatchWithNoResults()
    {
        $this->dispatchRoute('GET', ['keyword' => 'QWERTYASDF123456789']);
        $this->assertQuery('.alert-warning');
    }

    private function dispatchRoute($method = null, $params = [], $isXmlHttpRequest = false)
    {
        $this->dispatch('/learn-zf2-pagination', $method, $params, $isXmlHttpRequest);
    }
}
