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
use Zend\File\Transfer\Adapter\Http;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Validator\File\Extension;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * @author  Stanimir Dimitrov <stanimirdim92@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var array
     */
    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array('application/json'),
        'Zend\View\Model\ViewModel' => array('text/html'),
    );

    /**
     * @var AjaxImageUploadForm
     */
    private $ajaxForm = null;

    /**
     * @var ViewModel
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
     * @return ViewModel
     */
    public function indexAction()
    {
        $this->acceptableviewmodelselector($this->acceptCriteria);

        $this->view->form = $this->ajaxForm;

        return $this->view;
    }

    /**
     * @return JsonModel
     */
    protected function uploadAction()
    {
        $request = $this->getRequest();
        $data = array();

        if ($request->isXmlHttpRequest()) {
            $data = $this->prepareImages();
        }

        return new JsonModel($data);
    }

    /**
     * Deleted image with from a given src.
     *
     * @method deleteimageAction
     *
     * @return bool
     */
    protected function deleteimageAction()
    {
        $request = $this->getRequest();
        $status = false;

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            if ($request->isXmlHttpRequest()) {
                if (is_file('public'.$data['img'])) {
                    unlink('public'.$data['img']);
                    $status = true;
                }
            }
        }

        return $status;
    }

    /**
     * Get all files from all folders and list them in the gallery
     * getcwd() is there to make the work with images path easier.
     * 
     * @return JsonModel
     */
    protected function filesAction()
    {
        chdir(getcwd().'/public/');

        $dir = new \RecursiveDirectoryIterator('userfiles/', \FilesystemIterator::SKIP_DOTS);
        $it = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
        $it->setMaxDepth(50);
        $files = array();
        $i = 0;
        foreach ($it as $file) {
            if ($file->isFile()) {
                $files[$i]['filelink'] = DIRECTORY_SEPARATOR.$file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();
                $files[$i]['filename'] = $file->getFilename();
                $i++;
            }
        }
        chdir(dirname(getcwd()));
        $model = new JsonModel();
        $model->setVariables(array('files' => $files));

        return $model;
    }

    /**
     * Upload all images async.
     *
     * @return array
     */
    private function prepareImages()
    {
        $adapter = new Http();

        $size = new Size(array('min' => '10kB', 'max' => '5MB','useByteString' => true));
        $extension = new Extension(array('jpg','gif','png','jpeg','bmp','webp','svg'), true);

        $adapter->setValidators(array($size, new IsImage(), $extension));

        $adapter->setDestination('public/userfiles/images/');

        return $this->uploadFiles($adapter);
    }

    /**
     * @param Http $adapter
     *
     * @return array
     */
    private function uploadFiles(Http $adapter)
    {
        $uploadStatus = array();

        foreach ($adapter->getFileInfo() as $key => $file) {
            if (!$adapter->isValid($file['name'])) {
                foreach ($adapter->getMessages() as $key => $msg) {
                    $uploadStatus['errorFiles'][] = $file['name'].' '.strtolower($msg);
                }
            }

            // @codeCoverageIgnoreStart
            if (!$adapter->receive($file['name'])) {
                $uploadStatus['errorFiles'][] = $file['name'].' was not uploaded';
            } else {
                $uploadStatus['successFiles'][] = $file['name'].' was successfully uploaded';
            }
            // @codeCoverageIgnoreEnd
        }

        return $uploadStatus;
    }
}
