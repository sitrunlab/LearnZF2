<?php

namespace LearnZF2AjaxImageGallery\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class AjaxImageUploadForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct("upload");
    }

    public function init()
    {
        $this->setAttribute('action', "/learn-zf2-ajax-image-gallery/index/upload");
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'imageUpload',
            'type'  => 'File',
            'attributes' => [
                'class' => 'imgupload',
                'id' => 'imgajax',
                'multiple' => true,
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                "name"=>"imageUpload",
                "required" => false,
            ],
        ];
    }

}
