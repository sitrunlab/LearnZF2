<?php

namespace LearnZF2Barcode\Controller;

use Zend\Barcode\Barcode;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BarcodeController extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * Construct the form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
    * Use the form to get barcode image from selected barcode object
    */
    public function indexAction()
    {
        $request = $this->getRequest();

        //default value without post parameter
        $barcodeOptions = array('text' => '123456789');
        $barcode = Barcode::factory('codabar', 'image', $barcodeOptions);

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $barcodeOptions = array('text' => $this->form->getData()['barcode-object-text']);
                $barcode = Barcode::factory($this->form->getData()['barcode-object-select'], 'image', $barcodeOptions);
            }
        }

        imagegif($barcode->draw(), './data/barcode.gif');

        return new ViewModel([
            'form' => $this->form,
        ]);
    }

    /**
     * Show image barcode
     */
    public function getbarcodeimageAction()
    {
        $response = $this->getResponse();

        if (file_exists('./data/barcode.gif')) {
            $response->getHeaders()->addHeaderLine('Content-Type', 'image/gif');
            $response->getHeaders()->addHeaderLine('Content-Length', filesize('./data/barcode.gif'));
            // set response with get content of pdf
            $response->setContent(file_get_contents('./data/barcode.gif'));

            //remove file after no need
            @unlink('./data/barcode.gif');
        } else {
            $response->getHeaders()->addHeaderLine('Content-Type', 'text/html');
            $response->setContent('barcode not found');
        }

        return $response;
    }
}
