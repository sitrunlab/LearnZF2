<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Get sitemap page
 */
class SitemapController extends AbstractActionController
{
    public function indexAction()
    {
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'text/xml');

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel;
    }
}
