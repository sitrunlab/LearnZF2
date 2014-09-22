<?php
/**
 * Created by PhpStorm.
 * User: mockie
 * Date: 9/4/14
 * Time: 12:28 PM
 * Website : http://mockie.net
 * Email : rifkimuhammad89@gmail.com
 */

namespace LearnZF2Ajax\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction()
    {
        return new ViewModel();
    }

} 