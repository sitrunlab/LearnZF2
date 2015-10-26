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

namespace LearnZF2Themes;

use LearnZF2Themes\Service\ReloadService;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
{
    /**
     * @var \Zend\getServiceManager\ServiceManager
     */
    private $service = null;

    /**
     * Listen to the bootstrap event.
     *
     * @param EventInterface $event
     */
    public function onBootstrap(EventInterface $event)
    {
        $app = $event->getApplication();
        $this->service = $app->getServiceManager();
        $eventManager = $app->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        $eventManager->attach('render', [$this,'loadTheme'], 100);
        $sharedEventManager->attach(ReloadService::class, 'reload', [$this, 'reloadConfig'], 100);
    }

    /**
     * Listen for theme change and override Config.
     */
    public function reloadConfig()
    {
        $request = $this->service->get('Request');

        $config = $this->service->get('Config');
        $this->service->setAllowOverride(true);
        $config['theme']['name'] = $request->getPost()['themeName'];
        $this->service->setService('Config', $config);
        $this->service->setAllowOverride(false);
    }

    /**
     * Setup theme.
     */
    public function loadTheme()
    {
        return $this->service->get('initThemes');
    }

    /**
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ],
            ],
        ];
    }
}
