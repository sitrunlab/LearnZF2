<?php
namespace LearnZF2Navigation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
