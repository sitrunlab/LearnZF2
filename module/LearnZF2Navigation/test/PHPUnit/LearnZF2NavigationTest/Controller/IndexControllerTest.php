<?php
namespace LearnZF2NavigationTest\Controller;

use LearnZF2Navigation\Controller\IndexController;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class IndexControllerTest
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class IndexControllerTest extends TestCase
{
    /**
     * @var IndexController
     */
    private $indexController;

    public function setUp()
    {
        $this->indexController = new IndexController();
    }

    public function testIndexAction()
    {
        $model = $this->indexController->indexAction();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $model);
        $this->assertCount(0, $model->getVariables());
    }
}
