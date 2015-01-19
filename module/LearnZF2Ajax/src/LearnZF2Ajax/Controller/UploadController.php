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

use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Created by PhpStorm.
 * User: mockie
 * Date: 12/2/14
 * Time: 5:31 AM
 */

class UploadController extends AbstractActionController
{
    protected $acceptCriteria = [
        'Zend\View\Model\JsonModel' => ['application/json'],
        'Zend\View\Model\ViewModel' => ['text/html'],
    ];

    public function __construct(FormInterface $uploadForm)
    {
        $this->uploadForm = $uploadForm;
    }

    public function indexAction()
    {
        $result = ['result' => false,'message' => ''];
        $viewModel = $this->acceptableviewmodelselector($this->acceptCriteria);
        $form = $this->uploadForm;

        $request = $this->getRequest();
        if ($request->isPost()) {

            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                var_dump($form->getData());
//                $result = ['result' => true,'message' => 'Ajax request success'];
            } else {
//                $result = ['result' => false,'message' => $form->getMessages()];
            }

        }

        $viewModel->setVariables(['form' => $form,'data' => $result]);

        return $viewModel;
    }
}
