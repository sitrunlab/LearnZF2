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

namespace LearnZF2Themes\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Stanimir Dimitrov <stanimirdim92@gmail.com>
 *
 * This is the class where all the magic happens!!!
 */
final class ThemesFactory
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $themesConfig = $serviceLocator->get('getThemesFromDir');
        $config = $serviceLocator->get('Config');
        $headScript = $serviceLocator->get('ViewHelperManager')->get('HeadScript');
        $headLink = $serviceLocator->get('ViewHelperManager')->get('headLink');
        $publicDir = '/themes/'.$config['theme']['name'].DIRECTORY_SEPARATOR;

        /*
         * Get theme name from config and load it.
         *
         * At this point the user has already been selected the new theme he wants to use
         * from indexAction.
         */
        $themes = $themesConfig['themes'][$config['theme']['name']];

        if (isset($themes['template_map'])) {
            $map = $serviceLocator->get('ViewTemplateMapResolver');
            $map->merge($themes['template_map']);
        }

        if (isset($themes['template_path_stack'])) {
            $stack = $serviceLocator->get('ViewTemplatePathStack');
            $stack->addPaths($themes['template_path_stack']);
        }

        foreach ($themes['css'] as $key => $file) {
            $headLink->prependStylesheet($publicDir.$file);
        }

        foreach ($themes['js'] as $key => $file) {
            $headScript->prependFile($publicDir.$file);
        }

        return new self();
    }
}
