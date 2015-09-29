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

namespace LearnZF2I18nTest;

use LearnZF2I18n\Module;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Console;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\Http;
use Zend\I18n\Translator\Translator;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Parameters;
use Zend\View\Model\ViewModel;

/**
 * Class ModuleTest.
 *
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    private $module;
    /**
     * @var Application
     */
    private $app;

    public function setUp()
    {
        $this->module = new Module();
        $app = $this->prophesize('Zend\Mvc\Application');

        $sm = new ServiceManager(new Config([
            'services' => [
                'translator' => Translator::factory(['locale' => 'id_ID']),
            ],
        ]));
        $app->getServiceManager()->willReturn($sm);

        $em = new EventManager();
        $em->setSharedManager(new SharedEventManager());
        $app->getEventManager()->willReturn($em);
        $this->app = $app->reveal();
    }

    public function testGetConfig()
    {
        $config = include __DIR__.'/../../../config/module.config.php';
        $this->assertEquals($config, $this->module->getConfig());
    }

    public function testGetAutoloaderConfig()
    {
        $expected = [
            'Zend\Loader\StandardAutoloader' => [
                StandardAutoloader::LOAD_NS => [
                    'LearnZF2I18n' => realpath(__DIR__.'/../../../src/LearnZF2I18n'),
                ],
            ],
        ];
        $this->assertEquals($expected, $this->module->getAutoloaderConfig());
    }

    public function testOnBootstrap()
    {
        $this->assertFalse(
            $this->app->getEventManager()->getSharedManager()->getListeners('LearnZF2I18n', MvcEvent::EVENT_DISPATCH)
        );

        $e = new MvcEvent();
        $e->setApplication($this->app);
        $this->module->onBootstrap($e);
        $this->assertCount(
            1,
            $this->app->getEventManager()->getSharedManager()->getListeners('LearnZF2I18n', MvcEvent::EVENT_DISPATCH)
        );
    }

    public function testInitCurrentLocaleOnNonHttpRequest()
    {
        $e = new MvcEvent();
        $e->setRequest(new Console\Request());
        $this->assertEquals('id_ID', $this->app->getServiceManager()->get('translator')->getLocale());
        $this->module->initCurrentLocale($e);

        // Test that current locale has not changed
        $this->assertEquals('id_ID', $this->app->getServiceManager()->get('translator')->getLocale());
    }

    public function testInitCurrentLocaleWithNoLangOnQuery()
    {
        $e = $this->createMvcEvent();
        $this->assertEquals('id_ID', $this->app->getServiceManager()->get('translator')->getLocale());
        $this->module->initCurrentLocale($e);

        // Test that current locale has changed to its default value, en_US
        $this->assertEquals('en_US', $this->app->getServiceManager()->get('translator')->getLocale());
    }

    public function testInitCurrentLocaleWithLangOnQuery()
    {
        $expected = 'es_ES';
        $e = $this->createMvcEvent($expected);
        $this->assertEquals('id_ID', $this->app->getServiceManager()->get('translator')->getLocale());
        $this->module->initCurrentLocale($e);

        // Test that current locale has changed to the one in the query
        $this->assertEquals($expected, $this->app->getServiceManager()->get('translator')->getLocale());
    }

    /**
     * Creates an MvcEvent object.
     *
     * @param null $lang
     *
     * @return MvcEvent
     */
    protected function createMvcEvent($lang = null)
    {
        $e = new MvcEvent();
        $e->setApplication($this->app);
        $e->setViewModel(new ViewModel());
        $request = new Http\Request();
        if (isset($lang)) {
            $request->setQuery(new Parameters(['lang' => $lang]));
        }
        $e->setRequest($request);

        return $e;
    }
}
