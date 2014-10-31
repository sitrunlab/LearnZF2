<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Filter\Compress;

class DownloadController extends AbstractActionController
{
    /**
     * @var array
     */
    private $applicationConfig;

    /**
     * Construct applicationConfig
     *
     * @param array $applicationConfig
     */
    public function __construct(array $applicationConfig)
    {
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * Download module
     *
     * /download/:module
     */
    public function learnmoduleAction()
    {
        $module = $this->params()->fromRoute('module', '');
        $compress = $this->params()->fromRoute('compress', '');

        $applicationConfig = $this->getServiceLocator()->get('ApplicationConfig');
        $modules           = $applicationConfig['modules'];

        if (in_array($module, $modules)) {
            $archive    =  $module . '.' . (($compress == 'zip') ? 'zip' : 'bz2');
            $filter     = new Compress(array(
                'adapter' => ($compress == 'zip') ? 'Zip' : 'Bz2',
                'options' => array(
                    'archive' =>  './data/' . $archive,
                ),
            ));
            $compressed = $filter->filter('./module/' . $module);

            $response = $this->getResponse();

            //setting response header....
            $response->getHeaders()->addHeaderLine('Content-Disposition', 'attachment; filename="'. $archive  .'"');
            $response->getHeaders()->addHeaderLine('Content-Length', filesize('./data/' . $archive));
            // set response with get content of file
            $response->setContent(file_get_contents('./data/' . $archive));

            //remove file after no need
            @unlink('./data/' . $archive);

            return $response;
        }

        return new ViewModel();
    }
}
