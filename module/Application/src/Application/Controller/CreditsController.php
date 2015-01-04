<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CreditsController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout()->setVariable('skipWelcome', true);

        return new ViewModel();
    }
}
