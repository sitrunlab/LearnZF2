<?php

namespace LearnZF2FormUsage\Controller;

use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FormController extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * Construct form property
     *
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $formMessages = array();
        $isPost = false;

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            $this->form->isValid();
            $formMessages = $this->form->getMessages();
            $isPost = true;
        }

        return new ViewModel([
            'form' => $this->form,
            'formMessages' => $formMessages,
            'isPost' => $isPost,
        ]);
    }
}
