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
        'factories' => [
            'LearnZF2Themes\Controller\Index' => 'LearnZF2Themes\Factory\Controller\IndexControllerFactory',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'initThemes' => 'LearnZF2Themes\Factory\ThemesFactory',
            'getThemesFromDir' => 'LearnZF2Themes\Factory\GetThemesFromDir',
            'reloadConfig' => 'LearnZF2Themes\Factory\ReloadConfigFactory',
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
   'theme' => [
        'name' => 'default',
    ],
];
