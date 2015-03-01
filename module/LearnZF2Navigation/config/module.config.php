<?php
use LearnZF2Navigation\Navigation\NavigationFactory;

return [
    'router' => [
        'routes' => [

            'learn-zf2-navigation' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-navigation',
                    'defaults' => [
                        'controller'    => 'LearnZF2Navigation\Controller\Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'      => 'Segment',
                        'options'   => [
                            'route'         => '[/:action]',
                            'constraints'   => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],

        ],
    ],

    'controllers' => [
        'invokables' => [
            'LearnZF2Navigation\Controller\Index' => 'LearnZF2Navigation\Controller\IndexController'
        ]
    ],

    'service_manager' => [
        'factories' => [
            NavigationFactory::NAME => 'LearnZF2Navigation\Navigation\NavigationFactory'
        ]
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],

    'navigation' => [
        NavigationFactory::NAME => [
            [
                'label' => 'Google',
                'uri' => 'https://www.google.com',
                'target' => '_blank'
            ],
            [
                'label' => 'Home',
                'route' => 'home'
            ],
            [
                'label' => 'Modules',
                'uri' => '#',
                'pages' => [
                    [
                        'label' => 'LearnZF2Ajax',
                        'route' => 'learnZF2Ajax'
                    ],
                    [
                        'label' => 'LearnZF2FormUsage',
                        'route' => 'learn-zf2-form-usage'
                    ],
                    [
                        'label' => 'LearnZF2Barcode',
                        'route' => 'learn-zf2-barcode-usage'
                    ],
                    [
                        'label' => 'LearnZF2Pagination',
                        'route' => 'learn-zf2-pagination'
                    ],
                    [
                        'label' => 'LearnZF2Log',
                        'route' => 'learn-zf2-log'
                    ]
                ]
            ]
        ]
    ]
];
