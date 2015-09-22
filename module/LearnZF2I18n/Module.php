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

namespace LearnZF2I18n;

use Zend\EventManager\EventInterface;
use Zend\Http;
use Zend\I18n\Translator\Translator;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class Module.
 *
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
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
        $sharedManager->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'initCurrentLocale'), 10);
    }

    public function initCurrentLocale(MvcEvent $e)
    {
        $request = $e->getRequest();
        if (!$request instanceof Http\Request) {
            return;
        }

        /** @var Translator $translator */
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $lang = $request->getQuery('lang', 'en_US');
        $translator->setLocale($lang);

        // Inject current language in view model
        $e->getViewModel()->setVariable('lang', $lang);
    }
}
