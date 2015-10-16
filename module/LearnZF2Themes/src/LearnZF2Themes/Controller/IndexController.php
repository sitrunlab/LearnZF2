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

namespace LearnZF2Themes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use DirectoryIterator;

/**
 * @author Stanimir Dimitrov <stanimirdim92@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var ViewModel
     */
    private $view = null;

    /**
     * Holds current theme information.
     *
     * @var array
     */
    private $themeInfo = [];

    /**
     * @method __construct
     *
     * @param array $themeInfo
     */
    public function __construct(array $themeInfo = [])
    {
        $this->view = new ViewModel();
        $this->themeInfo = $themeInfo;
    }

    /**
     * @param MvcEvent $event
     */
    public function onDispatch(MvcEvent $event)
    {
        parent::onDispatch($event);
    }
    /**
     * This action shows the list of all contents.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $this->view->themes = $this->getThemesFromDir();

        /*
         * Load theme name in settings.
         */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $filename = 'module/LearnZF2Themes/config/module.config.php';
            $settings = include $filename;
            $settings['theme']['name'] = $request->getPost()['themeName'];

            file_put_contents($filename, '<?php return '.var_export($settings, true).';');
            $this->redirect()->toUrl('/learn-zf2-themes');
        }

        return $this->view;
    }

    /**
     * Look into Themes module and get all aviable themes.
     *
     * @method getThemesFromDir
     *
     * @return array containg all themes configurations
     */
    private function getThemesFromDir()
    {
        $path = 'module/LearnZF2Themes/themes/';
        $dir = new DirectoryIterator($path);
        $themesConfig = [];

        foreach ($dir as $file) {
            if ($file->isDir() && !$file->isDot()) {
                $hasConfig = $path.$file->getBasename().'/config/module.config.php';

                if (is_file($hasConfig)) {
                    $themesConfig['themes'][$file->getBasename()] = include $hasConfig;
                }
            }
        }

        return $themesConfig;
    }
}
