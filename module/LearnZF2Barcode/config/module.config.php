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
            // ...
        ],
    ],
];
