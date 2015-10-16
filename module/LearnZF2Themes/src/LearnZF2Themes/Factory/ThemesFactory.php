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

final class ThemesFactory
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $headScript = $serviceLocator->get('ViewHelperManager')->get('HeadScript');
        $headLink = $serviceLocator->get('ViewHelperManager')->get('headLink');
        $themeName = $config['theme']['name']; // current theme name
        $dir = '/themes/'.$themeName.DIRECTORY_SEPARATOR;

        /*
         * Get theme name from config and load it.
         *
         * At this point the user has already been selected the theme he wants to use
         * from the themesAction. So we only need to see if there is such a theme
         * inside our themes array. If there is such theme, the system will select it
         * and append its files, else it will call the default theme.
         */
        if (isset($config['themes'][$themeName])) {
            $themes = $config['themes'][$themeName];
        } else {
            $themes = $config['themes']['default']; // default them by default
        }

        if (isset($themes['template_map'])) {
            $map = $serviceLocator->get('ViewTemplateMapResolver');
            $map->merge($themes['template_map']);
        }

        if (isset($themes['template_path_stack'])) {
            $stack = $serviceLocator->get('ViewTemplatePathStack');
            $stack->addPaths($themes['template_path_stack']);
        }

        if (isset($themes['css'])) {
            foreach ($themes['css'] as $key => $file) {
                $headLink->prependStylesheet($dir.$file);
            }
        }

        if (isset($themes['js'])) {
            foreach ($themes['js'] as $key => $file) {
                $headScript->prependFile($dir.$file);
            }
        }

        return new self();
    }
}
