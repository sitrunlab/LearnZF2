<?php
return [
    'router' => [
        'routes' => [

            'learn-zf2-pagination' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-pagination',
                    'defaults' => [
                        'controller'    => 'LearnZF2Pagination\Controller\Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '[/:action]',
                            'constraints' => [
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'invokables' => [
            'LearnZF2Pagination\Controller\Index' => 'LearnZF2Pagination\Controller\IndexController'
        ]
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
