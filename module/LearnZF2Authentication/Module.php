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

namespace LearnZF2Authentication;

use Zend\EventManager\EventInterface;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class Module.
 *
 * @author Stanimir Dimitrov <s.dimitrov@weblunatix.com>
 */
class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    BootstrapListenerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /* @var MvcEvent $e */
        $sharedManager = $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'initAuthtentication'), 100);
    }

    public function initAuthtentication(MvcEvent $e)
    {
        /*
         * @var MvcEvent $e
         */
        $request = $e->getRequest();
        $response = $e->getResponse();
        $view = $e->getApplication()->getMvcEvent()->getViewModel();
        $sm = $e->getApplication()->getServiceManager();
        $authAdapter = $sm->get('LearnZF2Authentication\BasicAuthenticationAdapter');

        /*
         * Call the factory class and try to authenticate
         */
        if ($e->getRouteMatch()->getParam('action') === 'digest') {
            $authAdapter = $sm->get('LearnZF2Authentication\DigestAuthenticationAdapter');
        }
        $authAdapter->setRequest($request);
        $authAdapter->setResponse($response);

        if ($e->getRouteMatch()->getParam('action') === 'basic' || $e->getRouteMatch()->getParam('action') === 'digest') {
            $result = $authAdapter->authenticate();

            /*
             * Pass the information to the view and see what we got
             */
            if (!$result->isValid()) {
                /*
                 * Create a log function or just use the one from LearnZF2.
                 * Also make sure to redirect to another page, 404 for example
                 */
                foreach ($result->getMessages() as $msg) {
                    $view->authProblem = $msg;
                }

                return $view->authProblem;
            }

            return $view->identity = $result->getIdentity();
        }
    }
}
