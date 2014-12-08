<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContributorsController extends AbstractActionController
{
    public function __construct()
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
