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
namespace LearnZF2Log\Controller;

use Zend\Form\FormInterface;
use Zend\Log\Logger;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var array
     */
    protected $loggerConfig = [
        'writers' => [
            [
                'name' => 'stream',
                'options' => [
                    'stream' => 'php://output',
                    'formatter' => [
                        'name' => 'simple',
                        'options' => [
                            'format' => '%timestamp% %priorityName% (%priority%): %message%',
                        ],
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var int
     */
    protected $loggerPriority = Logger::EMERG;

    /**
     * @var FormInterface
     */
    protected $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $logContent = '';

        // initialize when no submit anymore
        $data = [];
        $data['logmessage'] = $this->form->get('logmessage')->getValue();
        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $data = $this->form->getData();

                $this->loggerPriority = $data['logpriority'];
                if ($data['logformat'] != 'simple') {
                    $this->loggerConfig['writers'][0]['options']['formatter']['name'] = $data['logformat'];
                    unset($this->loggerConfig['writers'][0]['options']['formatter']['options']);
                }
            }
        }

        $logger = new Logger($this->loggerConfig);

        // save log data to buffer and make it variable
        ob_start();
        $logger->log((int) $this->loggerPriority, $data['logmessage']);
        $logContent = ob_get_clean();

        return new ViewModel([
            'form' => $this->form,
            'logContent' => $logContent,
        ]);
    }
}
