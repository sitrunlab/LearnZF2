<?php

return [
    'router' => [
        'routes' => [
            'learn-zf2-log' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-log',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Log\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'LearnZF2Log\Controller\Index' => 'LearnZF2Log\Controller\IndexController',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'learnzf2log' => __DIR__.'/../view',
        ],
    ],
];
