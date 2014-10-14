<?php

namespace LearnZF2FormUsage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FormController extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('LearnZF2FormUsage\Form\LearnZF2Form');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                echo 'Success';
            } 
        }

        return new ViewModel(['form' => $form]);
    }
}
