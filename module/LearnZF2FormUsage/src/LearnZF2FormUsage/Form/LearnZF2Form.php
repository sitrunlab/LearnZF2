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

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'options' => array(
                'label' => 'Gender',
                'value_options' => array(
                    '1' => 'Select your gender',
                    '2' => 'Female',
                    '3' => 'Male',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'value' => '1', //set selected to '1'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'hobby',
            'options' => array(
                'label' => 'Please choose one/more of the hobbies',
                'value_options' => array(
                    '1' => 'Cooking',
                    '2' => 'Writing',
                    '3' => 'Others',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'value' => '1', //set checked to '1'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'placeholder' => 'you@domain.com',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birth',
            'options' => array(
                'label' => 'Birth ( Y/m/d )',
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Address',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'direction',
            'options' => array(
                'label' => 'Please choose one of the directions',
                'value_options' => array(
                    '1' => 'Programming',
                    '2' => 'Design',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'value' => '1', //set checked to '1'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            array(
                'name' => 'id',
                'required' => false,
                'allow_empty' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ),
            array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            array(
                'name' => 'gender',
                'validators' => array(
                    array(
                        'name' => 'InArray',
                        'options' => array(
                            'haystack' => array(2,3),
                            'messages' => array(
                                'notInArray' => 'Please select your gender !',
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'name' => 'hobby',
                'required' => true,
            ),
            array(
                'name' => 'email',
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                    ),
                ),
            ),
            array(
                'name' => 'birth',
                'validators' => array(
                    array(
                        'name' => 'Between',
                        'options' => array(
                            'min' => '1970-01-01',
                            'max' => date('Y-m-d'),
                        ),
                    ),
                ),
            ),
            array(
                'name' => 'address',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            array(
                'name' => 'direction',
                'required' => true,
            ),
        );
    }
}
