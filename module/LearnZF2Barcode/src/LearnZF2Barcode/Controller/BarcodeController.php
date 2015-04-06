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

namespace LearnZF2Barcode\Controller;

use Zend\Barcode\Barcode;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BarcodeController extends AbstractActionController
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * Construct the form.
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * Use the form to get barcode image from selected barcode object.
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        //default value without post parameter
        $barcodeOptions = array('text' => '123456789');
        $barcode = Barcode::factory('codabar', 'image', $barcodeOptions);

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $barcodeOptions = array('text' => $this->form->getData()['barcode-object-text']);
                $barcode = Barcode::factory($this->form->getData()['barcode-object-select'], 'image', $barcodeOptions);
            }
        }

        imagegif($barcode->draw(), './data/barcode.gif');

        return new ViewModel([
            'form' => $this->form,
        ]);
    }

    /**
     * Show image barcode.
     */
    public function getbarcodeimageAction()
    {
        $response = $this->getResponse();

        if (file_exists('./data/barcode.gif')) {
            $response->getHeaders()->addHeaderLine('Content-Type', 'image/gif');
            $response->getHeaders()->addHeaderLine('Content-Length', filesize('./data/barcode.gif'));
            // set response with get content of gif
            $response->setContent(file_get_contents('./data/barcode.gif'));

            //remove file after no need
            @unlink('./data/barcode.gif');
        } else {
            $response->getHeaders()->addHeaderLine('Content-Type', 'text/html');
            $response->setContent('barcode not found');
        }

        return $response;
    }
}
