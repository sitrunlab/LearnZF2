<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/application',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
            ],
            'download' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/download[/:module][/:compress]',
                    'defaults' => [
                        'controller' => 'Application\Controller\Download',
                        'action'     => 'learnmodule',
                    ],
                ],
            ],
            'credits' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/credits',
                    'defaults' => [
                        'controller' => 'Application\Controller\Credits',
                        'action'     => 'index',
                    ],
                ],
            ],
            'contributors' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/contributors',
                    'defaults' => [
                        'controller' => 'Application\Controller\Contributors',
                        'action'     => 'index',
                    ],
                ],
            ],
            'sitemapxml' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/sitemapxml',
                    'defaults' => [
                        'controller' => 'Application\Controller\Sitemap',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
    'controllers' => [
        'factories' => [
            'Application\Controller\Download' => 'Application\Factory\Controller\DownloadControllerFactory',
            'Application\Controller\Index' => 'Application\Factory\Controller\IndexControllerFactory',
            'Application\Controller\Contributors' => 'Application\Factory\Controller\ContributorsControllerFactory',
            'Application\Controller\Console' => 'Application\Factory\Controller\ConsoleControllerFactory',
        ],
        'invokables' => [
            'Application\Controller\Sitemap' => 'Application\Controller\SitemapController',
            'Application\Controller\Credits' => 'Application\Controller\CreditsController',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'downloadbuttonlink' => 'Application\Factory\View\Helper\DownloadButtonLinkFactory',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__.'/../view/layout/layout.phtml',
            'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
            'error/404'               => __DIR__.'/../view/error/404.phtml',
            'error/index'             => __DIR__.'/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
    'console' => [
        'contributors' => [
            'output' => 'data/contributors/contributors.pson',
        ],
        'router' => [
            'routes' => [
                'contributors' => [
                    'type' => 'Simple',
                    'options' => [
                        'route' => 'get contributors',
                        'defaults' => [
                            'controller' => 'Application\Controller\Console',
                            'action'     => 'getcontributors',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'doctrine' => [
        'driver' => [
            'Application_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Application/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' =>  'Application_driver',
                ],
            ],
        ],
    ],

];
