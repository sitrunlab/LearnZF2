<?php
namespace LearnZF2PaginationTest\View\Helper\QueryUrlTest;

use LearnZF2Pagination\View\Helper\QueryUrl;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Http\Request;
use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\Stdlib\Parameters;

class QueryUrlTest extends TestCase
{
    /**
     * @var QueryUrl
     */
    private $helper;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var RouteStackInterface
     */
    private $router;

    public function setUp()
    {
        $this->request = new Request();
        $this->helper = new QueryUrl($this->request);
        $this->router = TreeRouteStack::factory([
            'routes' => [
                'route-name' => new Literal('/foo/bar'),
            ],
        ]);
        $this->helper->setRouter($this->router);
    }

    public function testProvidedQueryParamsAreUsed()
    {
        $route = $this->helper->__invoke('route-name', [], ['query' => ['one' => 'foo', 'another' => 'bar']]);
        $this->assertEquals('/foo/bar?one=foo&another=bar', $route);
    }

    public function testRequestQueryParamsAreInherited()
    {
        $this->request->setQuery(new Parameters([
            'one' => 'foo',
            'another' => 'bar',
        ]));
        $route = $this->helper->__invoke('route-name', [], true);
        $this->assertEquals('/foo/bar?one=foo&another=bar', $route);
    }

    public function testRequestQueryParamsCanBeOverriden()
    {
        $this->request->setQuery(new Parameters([
            'one' => 'foo',
            'another' => 'bar',
        ]));
        $route = $this->helper->__invoke('route-name', [], ['query' => ['another' => 'overriden']], true);
        $this->assertEquals('/foo/bar?one=foo&another=overriden', $route);
    }

    /**
     * @expectedException \LearnZF2Pagination\Exception\RuntimeException
     */
    public function testNoRouterThrowsException()
    {
        $helper = new QueryUrl(new Request());
        $helper->__invoke('route-name');
    }
}
