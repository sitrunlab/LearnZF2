<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace LearnZF2FormUsage\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class LearnZF2Form extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('formname');
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'id',
            'attributes' => [
                'type'  => 'hidden',
            ],
        ]);

        $this->add([
            'name' => 'name',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'options' => [
                'label' => 'Gender',
                'value_options' => [
                    '1' => 'Select your gender',
                    '2' => 'Female',
                    '3' => 'Male',
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
                'value' => '1', //set selected to '1'
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'hobby',
            'options' => [
                'label' => 'Please choose one/more of the hobbies',
                'value_options' => [
                    '1' => 'Cooking',
                    '2' => 'Writing',
                    '3' => 'Others',
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
                'value' => '1', //set checked to '1'
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'placeholder' => 'you@domain.com',
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birth',
            'options' => [
                'label' => 'Birth ( Y/m/d )',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'name' => 'address',
            'attributes' => [
                'class' => 'form-control',
                'type' => 'textarea',
            ],
            'options' => [
                'label' => 'Address',
            ],
        ]);

        $this->add([
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'direction',
            'options' => [
                'label' => 'Please choose one of the directions',
                'value_options' => [
                    '1' => 'Programming',
                    '2' => 'Design',
                ],
            ],
            'attributes' => [
                'class' => 'form-control',
                'value' => '1', //set checked to '1'
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

    public function getInputFilterSpecification()
    {
        return [
            [
                'name'     => 'id',
                'required' => false,
                'allow_empty' => true,
                'filters'  => [
                    ['name' => 'Int'],
                ],
            ],
            [
                'name'     => 'name',
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
                            'min'      => 5,
                            'max'      => 255,
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'gender',
                'validators' => [
                    [
                        'name'    => 'InArray',
                        'options' => [
                            'haystack' => [2,3],
                            'messages' => [
                                'notInArray' => 'Please select your gender !',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'hobby',
                'required' => true
            ],
            [
                'name'     => 'email',
                'validators' => [
                    [
                        'name'    => 'EmailAddress',
                    ],
                ],
            ],
            [
                'name'     => 'birth',
                'validators' => [
                    [
                        'name'    => 'Between',
                        'options' => [
                            'min' => '1970-01-01',
                            'max' => date('Y-m-d'),
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'address',
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
                            'min'      => 5,
                            'max'      => 255,
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'direction',
                'required' => true
            ]
        ];
    }
}
