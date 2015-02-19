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
     * @var Logger
     */
    protected $logger;

    /**
     * @var FormInterface
     */
    protected $form;

    public function __construct(Logger $logger, FormInterface $form)
    {
        $this->logger = $logger;
        $this->form = $form;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $writers = $this->logger->getWriters();
                foreach ($writers as $writer) {
                    if ($data['logformat'] == 'Xml') {
                        $writer->setFormatter($data['logformat']);
                        $this->logger->addWriter($writer);
                    }
                }
            }
        }

        return new ViewModel([
            'form' => $this->form,
        ]);
    }
}
