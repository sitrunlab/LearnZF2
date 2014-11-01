<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/home.phtml');

        $paginator = new Paginator(new ArrayAdapter([
            0 => [
                'module_name' => 'LearnZF2Ajax',
                'module_desc' => 'Learn Ajax with ZF2',
                'module_route' => 'learnZF2Ajax'
            ],
            1 => [
                'module_name' => 'LearnZF2FormUsage',
                'module_desc' => 'Learn Form Usage with ZF2',
                'module_route' => 'learn-zf2-form-usage'
            ]
        ]));

        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        $paginator->setItemCountPerPage(10);

        return new ViewModel([
            'paginator' => $paginator
        ]);
    }
}
