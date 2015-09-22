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

/**
 * Zend Framework (http://framework.zend.com/).
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 *
 * Modified by Abdul Malik Ikhsan <samsonasik@gmail.com> as part of LearnZF2 project.
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'download' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/download[/:module][/:compress]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Download',
                        'action' => 'learnmodule',
                    ),
                ),
            ),
            'credits' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/credits',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Credits',
                        'action' => 'index',
                    ),
                ),
            ),
            'contributors' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/contributors',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Contributors',
                        'action' => 'index',
                    ),
                ),
            ),
            'sitemapxml' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/sitemapxml',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Sitemap',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Application\Controller\Download' => 'Application\Factory\Controller\DownloadControllerFactory',
            'Application\Controller\Index' => 'Application\Factory\Controller\IndexControllerFactory',
            'Application\Controller\Contributors' => 'Application\Factory\Controller\ContributorsControllerFactory',
            'Application\Controller\Console' => 'Application\Factory\Controller\ConsoleControllerFactory',
        ),
        'invokables' => array(
            'Application\Controller\Sitemap' => 'Application\Controller\SitemapController',
            'Application\Controller\Credits' => 'Application\Controller\CreditsController',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'downloadbuttonlink' => 'Application\Factory\View\Helper\DownloadButtonLinkFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
            'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
            'error/404' => __DIR__.'/../view/error/404.phtml',
            'error/index' => __DIR__.'/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
    'console' => array(
        'contributors' => array(
            'output' => 'data/contributors/contributors.pson',
        ),
        'router' => array(
            'routes' => array(
                'contributors' => array(
                    'type' => 'Simple',
                    'options' => array(
                        'route' => 'get contributors',
                        'defaults' => array(
                            'controller' => 'Application\Controller\Console',
                            'action' => 'getcontributors',
                        ),
                    ),
                ),
            ),
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__.'/../src/Application/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'Application_driver',
                ),
            ),
        ),
    ),

);
