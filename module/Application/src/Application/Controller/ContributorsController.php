<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContributorsController extends AbstractActionController
{
    /**
     * @var array
     */
    protected $contributors;

    /**
     * Construct contributors property
     */
    public function __construct(array $contributors)
    {
        $this->contributors = $contributors;
    }

    public function indexAction()
    {
        $this->layout()->setVariable('skipWelcome', true);

        return new ViewModel([
            'contributors' => $this->contributors,
        ]);
    }
}
