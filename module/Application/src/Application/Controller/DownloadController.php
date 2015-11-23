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
namespace Application\Controller;

use Zend\Filter\Compress;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DownloadController extends AbstractActionController
{
    /**
     * @var array
     */
    private $modulesList;

    /**
     * Construct $modulesList.
     *
     * @param array $modulesList
     */
    public function __construct(array $modulesList)
    {
        $this->modulesList = $modulesList;
    }

    /**
     * Download module.
     *
     * /download/:module
     */
    public function learnmoduleAction()
    {
        $module = $this->params()->fromRoute('module', '');
        $compress = $this->params()->fromRoute('compress', 'zip');

        $response = $this->getResponse();
        if (in_array($module, $this->modulesList)) {
            $currDateTime = date('Y-m-dHis');

            $fileToArchive = $module.'.'.(($compress === 'zip') ? 'zip' : 'bz2');
            $archive = $fileToArchive.'-'.$currDateTime;
            $filter = new Compress([
                'adapter' => ($compress === 'zip') ? 'Zip' : 'Bz2',
                'options' => [
                    'archive' => './data/'.$archive,
                ],
            ]);
            $compressed = $filter->filter('./module/'.$module);

            //setting response header....
            $response->getHeaders()->addHeaderLine('Content-Disposition', 'attachment; filename="'.$fileToArchive.'"');
            $response->getHeaders()->addHeaderLine('Content-Length', filesize($compressed));
            // set response with get content of file
            $response->setContent(file_get_contents($compressed));

            //remove file after no need
            @unlink('./data/'.$archive);

            return $response;
        }

        return new ViewModel();
    }
}
