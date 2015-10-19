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

/**
 * @author Stanimir Dimitrov <stanimirdim92@gmail.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * @var array
     */
    private $themesConfig = [];

    /**
     * @method __construct
     *
     * @param array $themesConfig Holds array with information about every theme
     */
    public function __construct(array $themesConfig = [])
    {
        $this->themesConfig = $themesConfig;
    }

    /**
     * This action shows the list of all themes.
     *
     * @method indexAction
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $filename = 'module/LearnZF2Themes/config/module.config.php';
            $settings = include $filename;
            $settings['theme']['name'] = $request->getPost()['themeName'];

            file_put_contents($filename, '<?php return '.var_export($settings, true).';');
            $this->redirect()->toUrl('/learn-zf2-themes');
        }

        return new ViewModel([
            'themes' => $this->themesConfig,
        ]);
    }
}
