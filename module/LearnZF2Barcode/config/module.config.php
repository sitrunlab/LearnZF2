<?php
return [
    'router' => [
        'routes' => [

            'learn-zf2-barcode-usage' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-barcode',
                    'defaults' => [
                        '__NAMESPACE__' => 'LearnZF2Barcode\Controller',
                        'controller'    => 'Barcode',
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
            'LearnZF2Barcode\Controller\Barcode'
                =>  'LearnZF2Barcode\Factory\Controller\BarcodeControllerFactory',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'BarcodeObjectPluginManager' => 'LearnZF2Barcode\Factory\Service\BarcodeObjectPluginManagerFactory',
        ],
    ],

    'form_elements' => [
        'factories' => [
            'LearnZF2Barcode\Form\BarcodeForm' => 'LearnZF2Barcode\Factory\Form\BarcodeFormFactory',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'learn-zf2-barcode' => __DIR__.'/../view',
        ],
    ],
];
