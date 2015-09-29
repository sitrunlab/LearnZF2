<?php

return [
    'router' => [
        'routes' => [
            'learn-zf2-form-usage' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/learn-zf2-form-usage',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2FormUsage\Controller',
                        'controller' => 'Form',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'LearnZF2FormUsage\Controller\Form' => 'LearnZF2FormUsage\Factory\Controller\FormControllerFactory',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'learnzf2usage' => __DIR__.'/../view',
        ],
    ],
];
