<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class DownloadController extends AbstractActionController
{
    public function learnmoduleAction()
    {
        $module = $this->params()->fromRoute('module', '');

    }
}
