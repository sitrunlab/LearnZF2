<?php

return [
    'router' => [
        'routes' => [
            'LearnZF2AjaxImageGallery' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-ajax-image-gallery',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2AjaxImageGallery\Controller',
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
        'invokables' => [
            'LearnZF2AjaxImageGallery\Controller\Index' => 'LearnZF2AjaxImageGallery\Controller\IndexController',
        ],
    ],
    'view_manager' => [
        'invokables' => [
            'LearnZF2AjaxImageGallery\Controller\Index' => 'LearnZF2AjaxImageGallery\Controller\IndexController',
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
