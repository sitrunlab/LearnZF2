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
use Zend\Debug\Debug;
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
        $viewModel = $this->acceptableviewmodelselector($this->acceptCriteria);
        $result = ['result' => false,'message' => ''];

        $request = $this->getRequest();
        if ($request->isPost()) {
            $login = new LoginInputFilter();
            $this->loginForm->setInputFilter($login->getInputFilter());
            $this->loginForm->setData($request->getPost());

            if ($this->loginForm->isValid()) {
                $result = ['result' => true,'message' => 'Ajax request success'];
            } else {
                $result = ['result' => false,'message' => $this->loginForm->getMessages()];
            }
        }

        $viewModel->setVariables(['form' => $this->loginForm,'data' => $result]);
        return $viewModel;
    }


} 
