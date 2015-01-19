<?php

namespace LearnZF2Ajax\Form;

use Zend\Form\Element\Csrf as CsrfElement;
use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Csrf;

class UploadForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        // File Input
        $file = new Element\File('file');
        $file
            ->setLabel('File Input')
            ->setAttributes([
                'id' => 'file',
                'multiple' => true,
            ]);

        $this->add($file);

        $csrf = new CsrfElement('csrf');
        $this->add($csrf);

        $this->csrf = $csrf;
    }

    public function getInputFilterSpecification()
    {
        return [
            'file' => [
                'required' => true,
                'validators' => [
                    [
                      'name' => 'filesize',
                      'options' => ['max' => 2000800],
                    ],
                    [
                      'name' => 'fileextension',
                      'options' => ['jpg','jpeg','png','gif'],
                    ],
                    [
                      'name' => 'fileimagesize',
                      'options' => ['maxWidth' => 2000, 'maxHeight' => 2000],
                    ],
                ],
                'filters' => [
                    [
                        'name' => 'filerenameupload',
                        'options' => ['target' => './data/uploads', 'randomize' => true]
                    ]
                ]
            ]
        ];
    }
}
