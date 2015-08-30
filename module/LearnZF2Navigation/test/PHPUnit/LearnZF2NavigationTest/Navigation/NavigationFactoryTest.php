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

namespace LearnZF2NavigationTest\Navigation;

use LearnZF2Navigation\Navigation\NavigationFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Console\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * Class NavigationFactoryTest.
 *
 * @author Alejandro Celaya Alastrué <alejandro@alejandrocelaya.com>
 */
class NavigationFactoryTest extends TestCase
{
    /**
     * @var NavigationFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new NavigationFactory();
    }

    public function testCreateService()
    {
        $sm = new ServiceManager(new Config([
            'services' => [
                'config' => include __DIR__.'/../../../../config/module.config.php',
                'eventmanager' => new EventManager(),
                'router' => new TreeRouteStack(),
                'request' => new Request(),
                'routematch' => new RouteMatch([]),
            ],
        ]));

        $event = new MvcEvent();
        $event->setRequest($sm->get('request'))
              ->setRouter($sm->get('router'))
              ->setRouteMatch($sm->get('routematch'));

        $app = $this->prophesize('Zend\Mvc\Application');
        $app->getMvcEvent()->willReturn($event);

        $sm->setService('application', $app->reveal());

        $navigation = $this->factory->createService($sm);
        $this->assertInstanceOf('Zend\Navigation\Navigation', $navigation);
    }
}
