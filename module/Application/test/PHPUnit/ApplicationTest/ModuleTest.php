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

namespace ApplicationTest;

use Application\Controller\DownloadController;
use Application\Entity\ModuleList;
use Application\Module;
use PHPUnit_Framework_TestCase;
use Zend\Console\Console;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Console\RouteMatch;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\HeadTitle;
use Zend\View\HelperPluginManager;
use Zend\View\Model\ViewModel;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * @var ServiceManager
     */
    protected $sm;

    public function setUp()
    {
        $this->sm = new ServiceManager();
        $this->module = new Module();

        // Initialize private services property by using reflection
        $class = new \ReflectionClass('Application\Module');
        $smProperty = $class->getProperty('services');
        $smProperty->setAccessible(true);
        $smProperty->setValue($this->module, $this->sm);
    }

    public function testGetConsoleUsage()
    {
        $expected = [
            'get contributors' => 'get contributors list',
        ];
        $consoleAdapter = Console::detectBestAdapter();
        $this->assertEquals($expected, $this->module->getConsoleUsage(new $consoleAdapter()));
    }

    public function testOnDispatch()
    {
        // Create MvcEvent
        $e = new MvcEvent();
        $e->setViewModel(new ViewModel());
        $rm = new RouteMatch([]);
        $rm->setParam('controller', 'Application\Controller\Download');
        $e->setRouteMatch($rm);
        $e->setTarget(new DownloadController([]));

        // Create EntityManager and EntityRepository
        $moduleDetail = new ModuleList();
        $moduleDetail->setModuleDesc('Pretty description');
        $repo = $this->prophesize('Doctrine\ORM\EntityRepository');
        $repo->findOneBy(['moduleName' => 'Application'])->willReturn($moduleDetail);
        $em = $this->prophesize('Doctrine\ORM\EntityManager');
        $em->getRepository('Application\Entity\ModuleList')->willReturn($repo);
        $this->sm->setService('Doctrine\ORM\EntityManager', $em->reveal());

        // Create ViewHelperManager
        $headTitle = new HeadTitle();
        $vhm = new HelperPluginManager();
        $vhm->setService('headTitle', $headTitle);
        $this->sm->setService('ViewHelperManager', $vhm);

        $this->module->onDispatch($e);
        $fbMeta = $e->getViewModel()->getVariable('fbMeta');
        $this->assertEquals(sprintf('%s-Real Live Learn ZF2', $moduleDetail->getModuleDesc()), $fbMeta['title']);
        $this->assertEquals(sprintf('%s-', $moduleDetail->getModuleDesc()), $fbMeta['description']);
    }
}
