<?php
/**
 * Created by PhpStorm.
 * User: mockie
 * Date: 12/8/14
 * Time: 8:53 PM
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContributorController extends AbstractActionController
{
    public function __construct()
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
