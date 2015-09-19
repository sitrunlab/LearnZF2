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

namespace LearnZF2Log\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class LogForm extends Form implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'logmessage',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Log message',
            ],
            'attributes' => [
                'value' => 'this is log message',
            ],
        ]);

        $this->add([
            'name' => 'logpriority',
            'type' => 'Select',
            'options' => [
                'value_options' => [
                    0 => 'EMERG',
                    1 => 'ALERT',
                    2 => 'CRIT',
                    3 => 'ERR',
                    4 => 'WARN',
                    5 => 'NOTICE',
                    6 => 'INFO',
                    7 => 'DEBUG',
                ],
                'label' => 'Log priority',
            ],
        ]);

        $this->add([
            'name' => 'logformat',
            'type' => 'Select',
            'options' => [
                'value_options' => [
                    'simple' => 'Simple',
                    'xml' => 'Xml',
                ],
                'label' => 'Log format',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'class' => 'form-control btn-primary',
                'type'  => 'submit',
                'value' => 'Submit log data',
                'id' => 'submitbutton',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name'     => 'logmessage',
                'required' => true,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ],
                    ],
                ],
            ],
        ];
    }
}
