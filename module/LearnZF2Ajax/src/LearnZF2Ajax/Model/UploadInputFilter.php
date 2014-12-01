<?php
/**
 * Created by PhpStorm.
 * User: mockie
 * Date: 11/21/14
 * Time: 12:58 AM
 */

namespace LearnZF2Ajax\Model;


use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UploadInputFilter implements InputFilterAwareInterface {

    protected $inputFilter;

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $fileInput = new FileInput('file');
        $fileInput->setRequired(false);

//        $fileInput->getValidatorChain()->attachByName('filesize', ['max' => 2000800])
//            ->attachByName('fileextension', ['jpg','jpeg','png','gif'])
//            ->attachByName('fileimagesize', ['maxWidth' => 2000, 'maxHeight' => 2000]);

        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            [
                'target'    => './data/uploads/avatar.png',
                'randomize' => true,
            ]
        );

        $inputFilter->add($fileInput);

        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
} 