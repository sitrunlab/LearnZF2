<?php
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
];
