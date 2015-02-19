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
        ]);

        $this->add([
            'name' => 'logpriority',
            'type' => 'Select',
            'options' => [
                'value_options' => [
                    'emerg' => 'EMERG',
                    'alert' => 'ALERT',
                    'crit' => 'CRIT',
                    'err' => 'ERR',
                    'warn' => 'WARN',
                    'notice' => 'NOTICE',
                    'info' => 'INFO',
                    'debug' => 'DEBUG',
                ],
                'label' => 'Log message',
            ],
        ]);

        $this->add([
            'name' => 'logformat',
            'type' => 'Select',
            'options' => [
                'value_options' => [
                    'Simple' => 'Simple',
                    'Xml' => 'Xml',
                ],
                'label' => 'Log message',
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
