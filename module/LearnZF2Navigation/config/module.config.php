<?php

use LearnZF2Navigation\Navigation\NavigationFactory;

return array(
    'router' => array(
        'routes' => array(

            'learn-zf2-navigation' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-navigation',
                    'defaults' => array(
                        'controller' => 'LearnZF2Navigation\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'LearnZF2Navigation\Controller\Index' => 'LearnZF2Navigation\Controller\IndexController',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            NavigationFactory::NAME => 'LearnZF2Navigation\Navigation\NavigationFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),

    'navigation' => array(
        NavigationFactory::NAME => array(
            array(
                'label' => 'Google',
                'uri' => 'https://www.google.com',
                'target' => '_blank',
            ),
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Modules',
                'uri' => '#',
                'pages' => array(
                    array(
                        'label' => 'LearnZF2Ajax',
                        'route' => 'learnZF2Ajax',
                    ),
                    array(
                        'label' => 'LearnZF2FormUsage',
                        'route' => 'learn-zf2-form-usage',
                    ),
                    array(
                        'label' => 'LearnZF2Barcode',
                        'route' => 'learn-zf2-barcode-usage',
                    ),
                    array(
                        'label' => 'LearnZF2Pagination',
                        'route' => 'learn-zf2-pagination',
                    ),
                    array(
                        'label' => 'LearnZF2Log',
                        'route' => 'learn-zf2-log',
                    ),
                ),
            ),
        ),
    ),
);
