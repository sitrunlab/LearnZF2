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
use Zend\Http;

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
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /* @var MvcEvent $e */
        $sharedManager = $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [$this, 'initAuthtentication'], 1);
    }

    public function initAuthtentication(MvcEvent $e)
    {
        /**
         * For simplicity for this tutorial, we will listen for different actions and apply different authentication schemes
         */
        if($e->getRouteMatch()->getParam("action") == "basic" || $e->getRouteMatch()->getParam("action") == "digest") {
            /* @var MvcEvent $e */
            $request  = $e->getRequest();
            $response = $e->getResponse();

            // Not HTTP? Stop!
            if (!($request instanceof Http\Request && $response instanceof Http\Response)) {
                return;
            }

            $sm = $e->getApplication()->getServiceManager();
            $authAdapter = $sm->get('LearnZF2Authentication\AuthenticationAdapter');
            $authAdapter->setRequest($request);
            $authAdapter->setResponse($response);
            $result = $authAdapter->authenticate();

            if ($result->isValid()) {
                return $e->getViewModel()->setVariable('identity', $result->getIdentity());
            }
            else {
                // Create a log function or just use the one from LearnZF2.
                //Also make sure to redirect to another page 404 for example
                foreach ($result->getMessages() as $msg) {
                    return $msg;
                }
            }
        }
    }
}
