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

use LearnZF2Ajax\Form\LoginForm;
use LearnZF2Ajax\Model\LoginInputFilter;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $acceptCriteria = [
        'Zend\View\Model\JsonModel' => ['application/json'],
        'Zend\View\Model\ViewModel' => ['text/html'],
    ];

    /**
     * @var FormInterface
     */
    protected $loginForm;

    public function __construct(FormInterface $loginForm)
    {
        $this->loginForm = $loginForm;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'form' => $this->loginForm,
        ));
    }

    public function formAjaxAction()
    {
        $viewModel = $this->acceptableviewmodelselector($this->acceptCriteria);
        $dataDemo = ['username' => 'admin','password' => 'admin'];

        $request = $this->getRequest();
        if ($request->isPost()) {
            $login = new LoginInputFilter();
            $this->loginForm->setInputFilter($login->getInputFilter());
            $this->loginForm->setData($request->getPost());

            if ($form->isValid()) {
                $login->exchangeArray($this->loginForm->getData());
            }
        }

        $viewModel->setVariables(['form' => $form]);

        return $viewModel;
    }

}
