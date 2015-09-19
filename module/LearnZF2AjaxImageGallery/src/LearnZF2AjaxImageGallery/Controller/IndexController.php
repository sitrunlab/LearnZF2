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

namespace LearnZF2AjaxImageGallery\Controller;

use LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Zend\Mvc\MvcEvent;
use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class IndexController extends AbstractActionController
{
    /**
     * @var array
     */
    protected $acceptCriteria = [
        'Zend\View\Model\JsonModel' => ['application/json'],
        'Zend\View\Model\ViewModel' => ['text/html'],
    ];

    /**
     * @var AjaxImageUploadForm
     */
    private $ajaxForm = null;

    /**
     * @var ViewModel|JsonModel
     */
    private $view;

    /**
     * @param AjaxImageUploadForm $form
     */
    public function __construct(AjaxImageUploadForm $form)
    {
        $this->view = new ViewModel();
        $this->ajaxForm = $form;
    }

    /**
     * @param MvcEvent $e
     */
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }

    /**
     * @return Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $this->acceptableviewmodelselector($this->acceptCriteria);

        $this->view->form = $this->ajaxForm;
        return $this->view;
    }

    /**
     * @return Json|null
     */
    protected function uploadAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->ajaxForm->setInputFilter($this->ajaxForm->getInputFilter());

            if ($request->isXmlHttpRequest()) {
                /**
                 * Silly hack, but I can't fix it.
                 *
                 * @var JsonModel $hack
                 */
               $hack = $this->prepareImages();
               echo Json::encode($hack->getVariables());
               die;
            }
        }
        return null;
    }

    /**
     * Deleted image with from a given src
     *
     * @method deleteimageAction
     *
     * @return bool
     */
    protected function deleteimageAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            if ($request->isXmlHttpRequest() && is_file("public".$data["img"])) {
                unlink("public".$data["img"]);
                return true;
            }
        }
        return false;
    }

    /**
     * Get all files from all folders and list them in the gallery
     * getcwd() is there to make the work with images path easier
     * 
     * @return JsonModel
     */
    protected function filesAction()
    {
        chdir(getcwd()."/public/");
        if (!is_dir('userfiles/images/')) {
            mkdir('userfiles/images/', 0750, true);
        }

        $dir = new \RecursiveDirectoryIterator('userfiles/', \FilesystemIterator::SKIP_DOTS);
        $it  = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
        $it->setMaxDepth(50);
        $files = [];
        $i = 0;
        foreach ($it as $file) {
            if ($file->isFile()) {
                $files[$i]["filelink"] = DIRECTORY_SEPARATOR.$file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();
                $files[$i]["filename"] = $file->getFilename();
                $i++;
            }
        }
        chdir(dirname(getcwd()));
        $model = new JsonModel();
        $model->setVariables(["files" => $files]);
        return $model;
    }

    /**
     * Upload all images async
     */
    private function prepareImages()
    {
        $adapter = new Http();
        /**
         * If validators are in the form, the adapter error messages won't be showed to the client
         */
        $size = new Size(['min'=>'10kB', 'max'=>'5MB','useByteString' => true]);
        $extension = new Extension(['jpg','gif','png','jpeg','bmp','webp','svg'], true);

        $adapter->setValidators([$size, new IsImage(), $extension]);

        if (!is_dir('public/userfiles/images/')) {
            mkdir('public/userfiles/images/', 0750, true);
        }

        $adapter->setDestination('public/userfiles/images/');
        return $this->uploadFiles($adapter);
    }

    /**
     * @param  Http $adapter
     * @return JsonModel
     */
    private function uploadFiles(Http $adapter)
    {
        $uploadStatus = [];

        foreach ($adapter->getFileInfo() as $key => $file) {
            if ($adapter->isValid($file["name"])) {
                $adapter->receive($file["name"]);
                if ($adapter->isReceived($file["name"]) && $adapter->isUploaded($file["name"])) {
                    $uploadStatus["successFiles"][] = $file["name"]." was successfully uploaded";
                } else {
                    $uploadStatus["errorFiles"][] = $file["name"]." was not uploaded";
                }
            } else {
                foreach ($adapter->getMessages() as $key => $msg) {
                    $uploadStatus["errorFiles"][] = $file["name"]." ".strtolower($msg);
                }
            }
        }

        $this->view->setTerminal(true);
        $this->getResponse()->getHeaders()->addHeaderLine('Accept', 'application/json; charset=utf-8');
        $model = new JsonModel($uploadStatus);
        $model->setTerminal(true);
        return $model;
    }
}
