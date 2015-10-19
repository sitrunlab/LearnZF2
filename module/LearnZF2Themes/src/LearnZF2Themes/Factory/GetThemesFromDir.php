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

use DirectoryIterator;

/**
 * @author Stanimir Dimitrov <stanimirdim92@gmail.com>
 */
final class GetThemesFromDir
{
    /**
     * {@inheritdoc}
     */
    public function __invoke()
    {
        $path = 'module/LearnZF2Themes/themes/';
        $dir = new DirectoryIterator($path);
        $themesConfig = [];

        foreach ($dir as $file) {
            if ($file->isDir() && !$file->isDot()) {
                $hasConfig = $path.$file->getBasename().'/config/module.config.php';

                if (is_file($hasConfig)) {
                    $themesConfig['themes'][$file->getBasename()] = include $hasConfig;
                }
            }
        }
        return $themesConfig;
    }
}
