<?php

namespace LearnZF2Ajax\Form;

use Zend\Form\Element\Csrf as CsrfElement;
use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\Csrf;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);


        // File Input
        $file = new Element\File('file');
        $file
            ->setLabel('File Input')
            ->setAttributes(array(
                'id' => 'file',
                'multiple' => true,
            ));

        $this->add($file);

        $csrfValidator = new Csrf(array('name' => 'csrf',
            'salt' => 'asdsadasdsa'
        ));

        $csrf = new CsrfElement('csrf');
        $csrf->setCsrfValidator($csrfValidator);
        $this->add($csrf);

        //assign!
        $this->csrf = $csrf;

    }
}
