<?php

return [
    'router' => [
        'routes' => [
            'learn-zf2-themes' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/learn-zf2-themes',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Themes\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'LearnZF2Themes\Controller\Index' => 'LearnZF2Themes\Controller\IndexController',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'initThemes' => 'LearnZF2Themes\Factory\ThemesFactory',
        ],
    ],
    'view_manager' => [
        'strategies' => [
            0 => 'ViewJsonStrategy',
        ],
    ],
    'theme' => [
        'name' => 'default',
    ],
];
