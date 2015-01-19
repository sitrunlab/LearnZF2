<?php

return [
    'router' => [
        'routes' => [

            'learnZF2Ajax' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-ajax',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Ajax\Controller',
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
        ],
    ],
    'controllers' => [
        'factories' => [
            'LearnZF2Ajax\Controller\Index' => 'LearnZF2Ajax\Factory\Controller\IndexControllerFactory',
            'LearnZF2Ajax\Controller\Upload' => 'LearnZF2Ajax\Factory\Controller\UploadControllerFactory',
        ],
    ],
    'view_manager' => [
        'factories' => [
            'LearnZF2Ajax\Controller\Index' => 'LearnZF2Ajax\Factory\Controller\IndexControllerFactory',
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
];
