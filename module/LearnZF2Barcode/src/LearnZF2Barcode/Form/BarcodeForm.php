<?php

namespace LearnZF2Barcode\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class BarcodeForm extends Form implements InputFilterProviderInterface
{
    /**
     * @var [] array of barcode object values
     */
    protected $objectSelectValues;

    /**
     * construct objectSelectValues value options
     */
    public function __construct(array $objectSelectValues)
    {
        $this->objectSelectValues = array_combine($objectSelectValues, $objectSelectValues);
        parent::__construct('barcode-form');
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'barcode-object-select',
            'options' => [
                'label' => 'Barcode Objects',
                'value_options' =>  $this->objectSelectValues,
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'barcode-object-text',
            'options' => [
                'value_options' =>  [],
            ],
            'attributes' => [
                'value' => '123456789',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'class' => 'form-control',
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getInputFilterSpecification()
    {
        return [

            [
                'name'     => 'barcode-object-select',
                'validators' => [
                    [
                        'name'    => 'InArray',
                        'options' => [
                            'haystack' => array_keys($this->objectSelectValues),
                            'messages' => [
                                'notInArray' => 'Please select the object select !',
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name'     => 'barcode-object-text',
                'required' => true,
                'filters'  => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
