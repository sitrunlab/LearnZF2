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
ini_set('display_errors',1);


use LearnZF2Ajax\Form\LoginForm;
use LearnZF2Ajax\Model\LoginInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => ['application/json'],
        'Zend\View\Model\ViewModel' => ['text/html'],
    );

    public function indexAction()
    {
        return new ViewModel();
    }

    public function formAjaxAction()
    {
        $viewModel = $this->acceptableviewmodelselector($this->acceptCriteria);
        $dataDemo = ['username' => 'admin','password' => 'admin'];
        $form = new LoginForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $login = new LoginInputFilter();
            $form->setInputFilter($login->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $login->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);
            }
        }

        // Potentially vary execution based on model returned
//        if ($viewModel instanceof JsonModel)

        $viewModel->setVariables(['form' => $form]);
        return $viewModel;

    }

} 