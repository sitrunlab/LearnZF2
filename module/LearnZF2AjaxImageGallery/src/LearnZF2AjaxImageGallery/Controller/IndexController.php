<?php

namespace LearnZF2AjaxImageGallery\Controller;

use LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
<<<<<<< HEAD
=======
use Admin\Form\ContentForm;
>>>>>>> initial commit of ajax image gallery
use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class IndexController extends AbstractActionController
{
<<<<<<< HEAD
    /**
     * @var array
     */
=======
>>>>>>> initial commit of ajax image gallery
    protected $acceptCriteria = [
        'Zend\View\Model\JsonModel' => ['application/json'],
        'Zend\View\Model\ViewModel' => ['text/html'],
    ];

<<<<<<< HEAD
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
    public function __construct(AjaxImageUploadForm $form = null)
    {
        $this->view = new ViewModel();
        $this->ajaxForm = $form;
    }

    /**
     * @param MvcEvent $e
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
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
     * @return Zend\Json\Json|null
     */
    protected function uploadAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->ajaxForm->setInputFilter($this->ajaxForm->getInputFilter());

            if ($request->isXmlHttpRequest()) {
                return $this->prepareImages();
            }
        }
        return null;
    }

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
=======
    public $view;

    public function __construct()
    {
        $this->view = new ViewModel();
    }

    public function indexAction()
    {
        $this->acceptableviewmodelselector($this->acceptCriteria);
        $form = new AjaxImageUploadForm();
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            // $form->setInputFilter($content->getInputFilter());
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if (!empty($data["imageUpload"]) && $this->getRequest()->isXmlHttpRequest()) {
                return $this->uploadImages();
            }
        }
        return $this->view;
>>>>>>> initial commit of ajax image gallery
    }

    /**
     * Get all files from all folders and list them in the gallery
     */
<<<<<<< HEAD
    protected function filesAction()
    {
        chdir(getcwd()."/public/");

        if (!is_dir('userfiles/images/')) {
            mkdir('userfiles/images/', 0750, true);
        }

        $dir = new \RecursiveDirectoryIterator('userfiles/', \FilesystemIterator::SKIP_DOTS);
        $it  = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
        $it->setMaxDepth(50);
=======
    public function filesAction()
    {
        $this->view->setTerminal(true);
        $dir = new \RecursiveDirectoryIterator('public/userfiles/', \FilesystemIterator::SKIP_DOTS);
        $it  = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
        $it->setMaxDepth(3);
>>>>>>> initial commit of ajax image gallery
        $files = [];
        $i = 0;
        foreach ($it as $file) {
            if ($file->isFile()) {
<<<<<<< HEAD
                $files[$i]["filelink"] = DIRECTORY_SEPARATOR.$file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();
                $files[$i]["filename"] = $file->getFilename();
                $i++;
            }
        }
        chdir(dirname(getcwd()));
        $model = new JsonModel();
        $model->setVariables(["files" => $files]);
        return $model;
=======
                $filepath = explode("public", $file->getRealPath()); // ugly workaround :(
                $files[$i]["link"] = Json::encode($filepath[1]);
                $files[$i]["filename"] = Json::encode($file->getFilename());
                $i++;
            }
        }
        return new JsonModel($files);
    }

    /**
     * Create directories
     * @return  void
     */
    private function createDirectories()
    {
        if (!is_dir('public/userfiles/')) {
            mkdir('public/userfiles/');
        }
        if (!is_dir('public/userfiles/'.date("Y_M"))) {
            mkdir('public/userfiles/'.date("Y_M"));
        }
        if (!is_dir('public/userfiles/'.date("Y_M").'/images/')) {
            mkdir('public/userfiles/'.date("Y_M").'/images/');
        }
>>>>>>> initial commit of ajax image gallery
    }

    /**
     * Upload all images async
<<<<<<< HEAD
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
     * @return Json
     */
    private function uploadFiles(Http $adapter = null)
    {
        $uploadStatus = [];

        foreach ($adapter->getFileInfo() as $key => $file) {
            if ($adapter->isValid($file["name"])) {
                $adapter->receive($file["name"]);
                if ($adapter->isReceived($file["name"]) && $adapter->isUploaded($file["name"])) {
                    $uploadStatus["successFiles"][] = $file["name"]. " was successfully uploaded";
                } else {
                    $uploadStatus["errorFiles"][] = $file["name"]. " was not uploaded";
                }
            } else {
                foreach ($adapter->getMessages() as $key => $msg) {
                    $uploadStatus["errorFiles"][] = $file["name"]." ".strtolower($msg);
                }
            }
        }
        // JsonModel doesn't work... It returns the page html even file upload s successful
        echo Json::encode($uploadStatus);
        exit;
    }
=======
     *
     * @param  array $files
     * @return Response containing headers with information about each image
     */
    private function uploadImages()
    {
        $this->view->setTerminal(true);
        $adapter = new Http();
        $size = new Size(['min'=>'10kB', 'max'=>'5MB','useByteString' => true]);
        $isImage = new IsImage();
        $extension = new Extension(['jpg','gif','png','jpeg','bmp','webp','svg'], true);

        $this->createDirectories();
        $adapter->setValidators([$size, $isImage, $extension]);
        $adapter->setDestination('public/userfiles/'.date("Y_M").'/images/');
        $this->upload($adapter);
    }

    /**
     * @param  Zend\File\Transfer\Adapter\Http $adapter
     */
    private function upload($adapter)
    {
        $this->view->setTerminal(true);
        $uploadStatus = [];
        if ($adapter->isValid('imageUpload')) {
            foreach ($adapter->getFileInfo() as $key => $file) {
                /**
                 * Skip the normal image upload input
                 */
                if ($key == "preview") {
                    continue;
                }

                if ($adapter->receive($file["name"])) {
                    $uploadStatus["successFiles"][] = $file["name"]." was uploaded successfully";
                } else {
                    $uploadStatus["errorFiles"][] = $file["name"]. " was not uploaded";
                }
            }
            echo Json::encode($uploadStatus);
            exit;
            // return new JsonModel(["uploadStatus" => Json::encode($uploadStatus)]);
        } else {
            foreach ($adapter->getMessages() as $key => $error) {
                $uploadStatus["errorFiles"][] = $error;
            }
            echo Json::encode($uploadStatus);
            exit;
            // return new JsonModel(["uploadStatus" => Json::encode($uploadStatus)]);
        }
    }

>>>>>>> initial commit of ajax image gallery
}
