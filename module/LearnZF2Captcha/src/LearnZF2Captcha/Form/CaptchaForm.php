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

namespace LearnZF2Captcha\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Form class that shows captchas.
 */
class CaptchaForm extends Form implements InputFilterProviderInterface
{
    /** @var array */
    private $captchaConfig;

    /** @var int captchaAdapterKey */
    private $captchaAdapterKey;

    /**
     * Constructor.
     *
     * Setup Captcha Config
     *
     * @param array $captchaConfig
     */
    public function __construct(array $captchaConfig, $captchaAdapterKey)
    {
        $this->captchaConfig = $captchaConfig;
        $this->captchaAdapterKey = $captchaAdapterKey;

        parent::__construct('Captcha Form');
    }

    /**
     * Collect Captcha options.
     *
     * @return array
     */
    private function collectValueOptions()
    {
        $options = array();
        foreach ($this->captchaConfig as $key => $config) {
            $options[$key] = $config['adapter_name'];
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setAttribute('id', 'captchaForm');
        $this->setAttribute('method', 'get');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'captcha_adapter',
            'options' => array(
                'label' => 'Choose Captcha Adapter',
                'value_options' => $this->collectValueOptions(),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'value' => $this->captchaAdapterKey,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => $this->captchaConfig[$this->captchaAdapterKey]['options']['label'],
                'captcha' => array(
                    'class' => $this->collectValueOptions()[$this->captchaAdapterKey],
                    'options' => $this->captchaConfig[$this->captchaAdapterKey]['options'],
                ),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submitCaptcha',
            'attributes' => array(
                'value' => 'Submit',
                'class' => 'submit',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getInputFilterSpecification()
    {
        return array(

        );
    }
}
