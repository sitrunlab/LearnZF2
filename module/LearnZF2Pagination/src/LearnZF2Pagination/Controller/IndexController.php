<?php
namespace LearnZF2Pagination\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class IndexController extends AbstractActionController
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function indexAction()
    {
        return new ViewModel(['data' => $this->data]);
    }
}
