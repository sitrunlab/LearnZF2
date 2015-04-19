<?php

return [
    'router' => [
        'routes' => [
            'learn-zf2-authentication' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-authentication',
                    'defaults' => [
                        'controller'    => 'LearnZF2Authentication\Controller\Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'      => 'Segment',
                        'options'   => [
                            'route'         => '/:action',
                            'constraints'   => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],

        ],
    ],
    'authentication' => [
        'adapter' => [
            'config' => [
                'accept_schemes' => 'basic digest',
                'realm'          => 'authentication',
                'digest_domains' => '/learn-zf2-authentication/auth',
                'nonce_timeout'  => 3600,
                'proxy_auth'     => false,
            ],
            'basic' => __DIR__ . '/auth/basic.txt',
            'digest' => __DIR__ . '/auth/digest.txt',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'LearnZF2Authentication\AuthenticationAdapter' => 'LearnZF2Authentication\Factory\AuthenticationAdapterFactory',
        ],
    ],

    'controllers' => [
        'invokables' => [
            'LearnZF2Authentication\Controller\Index' => 'LearnZF2Authentication\Controller\IndexController',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
];
