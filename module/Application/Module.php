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

namespace Application;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module  implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $services;

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $this->services = $e->getApplication()->getServiceManager();

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
        $eventManager->attach(MvcEvent::EVENT_RENDER, [$this, 'onRender']);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Handle layout on 'dispatch' event.
     *
     * @param MvcEvent $e
     */
    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $activeController = $routeMatch->getParam('controller');

        $listController1Columns = [
            'Application\Controller\Index',
            'Application\Controller\Credits',
            'Application\Controller\Contributors',
        ];

        $controller = $e->getTarget();
        if (!$e->getViewModel()->terminate()) {
            if (!in_array($activeController, $listController1Columns)) {
                $controllerClass = get_class($controller);
                $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));

                $fbMeta['title'] = 'Real Live Learn ZF2';
                $fbMeta['description'] = '';

                // set title prepend of module desc...
                $moduleDetail = $this->services->get('Doctrine\ORM\EntityManager')->getRepository('Application\Entity\ModuleList')->findOneBy([
                    'moduleName' => $moduleNamespace,
                ]);

                if ($moduleDetail) {
                    $this->services->get('ViewHelperManager')->get('headTitle')->prepend($moduleDetail->getModuleDesc());
                    $title = $moduleDetail->getModuleDesc();
                    $description = $moduleDetail->getModuleDesc();

                    $fbMeta['title'] = $title.'-'.$fbMeta['title'];
                    $fbMeta['description'] = $description.'-'.$fbMeta['description'];
                }

                $e->getViewModel()->setVariable('fbMeta', $fbMeta);

                $e->getViewModel()->setVariable('modulenamespace', $moduleNamespace);
                $controller->layout('layout/2columns');
            } else {
                $controller->layout('layout/1columns');
            }
        }
    }

    /**
     * Set variable layout on 'render' event.
     *
     * @param MvcEvent $e
     */
    public function onRender(MvcEvent $e)
    {
        if (!$e->getViewModel()->terminate()) {
            $entityManager = $this->services->get('Doctrine\ORM\EntityManager');
            $e->getViewModel()
              ->setVariable('modules_list', $entityManager->getRepository('Application\Entity\ModuleList')->findAll());
        }
    }

    /**
     * Get console usage description.
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'get contributors' => 'get contributors list',
        ];
    }

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    /**
     * @return array
     */
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
