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

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use DirectoryIterator;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
{
    /**
     * Listen to the bootstrap event.
     *
     * @param EventInterface $event
     */
    public function onBootstrap(EventInterface $event)
    {
        $app = $event->getApplication();
        $eventManager = $app->getEventManager();
        $eventManager->attach('render', [$this,'loadTheme'], 100);
    }

    /**
     * Setup theme.
     *
     * @param EventInterface $event
     */
    public function loadTheme(EventInterface $event)
    {
        return $event->getApplication()->getServiceManager()->get('initThemes');
    }

    public function getConfig()
    {
        $config =  include __DIR__.'/config/module.config.php';
        $dir = new DirectoryIterator(__DIR__.'/themes');

        foreach ($dir as $file) {
            if ($file->isDir() && !$file->isDot()) {
                $hasConfig = __DIR__.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$file->getBasename().'/config/module.config.php';

                if (is_file($hasConfig)) {
                    $config['themes'][$file->getBasename()] = include $hasConfig;
                }
            }
        }

        return $config;
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
