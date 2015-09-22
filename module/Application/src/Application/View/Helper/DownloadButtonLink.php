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

namespace Application\View\Helper;

use Zend\Mvc\MvcEvent;
use Zend\View\Helper\AbstractHelper;

/**
 * Download Button Link View Helper.
 */
final class DownloadButtonLink extends AbstractHelper
{
    /**
     * @var MvcEvent
     */
    private $mvcEvent;

    /**
     * Construct mvcEvent property.
     */
    public function __construct(MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
    }

    /**
     * Download link.
     *
     * @param string $compress        'zip' | 'bz2' | other to make option
     * @param string $moduleNamespace
     *
     * @return string
     */
    public function __invoke($compress = 'zip', $moduleNamespace = '')
    {
        if ($moduleNamespace === '') {
            $controller = $this->mvcEvent->getRouteMatch()->getParam('controller');
            $moduleNamespace = substr($controller, 0, strpos($controller, '\\'));
        }

        return $this->view->url('download', array(
            'module' => $moduleNamespace,
            'compress' => $compress,
        ));
    }
}
