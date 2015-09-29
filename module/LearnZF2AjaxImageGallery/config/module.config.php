<?php

return [
    'router' => [
        'routes' => [
            'learn-zf2-ajax-image-gallery' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/learn-zf2-ajax-image-gallery',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2AjaxImageGallery\Controller',
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
            'LearnZF2AjaxImageGallery\Controller\Index' => 'LearnZF2AjaxImageGallery\Factory\Controller\IndexControllerFactory',
        ],
    ],
    'form_elements' => [
        'factories' => [
            'LearnZF2AjaxImageGallery\Form\AjaxImageUploadForm' => 'LearnZF2AjaxImageGallery\Factory\Form\AjaxImageUploadFormFactory',
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_path_stack' => [
            'learn-zf2-ajax-image-gallery' => __DIR__.'/../view',
        ],
    ],
];
