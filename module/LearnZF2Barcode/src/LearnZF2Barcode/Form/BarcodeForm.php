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
     * construct objectSelectValues value options.
     */
    public function __construct(array $objectSelectValues)
    {
        $this->objectSelectValues = array_combine($objectSelectValues, $objectSelectValues);
        parent::__construct('barcode-form');
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'barcode-object-select',
            'options' => array(
                'label' => 'Barcode Objects',
                'value_options' => $this->objectSelectValues,
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'barcode-object-text',
            'options' => array(
                'value_options' => array(),
            ),
            'attributes' => array(
                'value' => '123456789',
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

    /**
     * {@inheritdoc}
     */
    public function getInputFilterSpecification()
    {
        return array(

            array(
                'name' => 'barcode-object-select',
                'validators' => array(
                    array(
                        'name' => 'InArray',
                        'options' => array(
                            'haystack' => array_keys($this->objectSelectValues),
                            'messages' => array(
                                'notInArray' => 'Please select the object select !',
                            ),
                        ),
                    ),
                ),
            ),

            array(
                'name' => 'barcode-object-text',
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
                            'min' => 1,
                        ),
                    ),
                ),
            ),
        );
    }
}
