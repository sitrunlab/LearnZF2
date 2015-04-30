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
    'authentication_basic' => [
        'adapter' => [
            'config' => [
                'accept_schemes' => 'basic',
                'realm'          => 'authentication',
                'nonce_timeout'  => 3600,
            ],
            'basic'  => __DIR__.'/auth/basic.txt',
        ],
    ],
    'authentication_digest' => [
        'adapter' => [
            'config' => [
                'accept_schemes' => 'digest',
                'realm'          => 'authentication',
                'digest_domains' => '/learn-zf2-authentication/digest',
                'nonce_timeout'  => 3600,
            ],
            'digest' => __DIR__.'/auth/digest.txt',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'LearnZF2Authentication\BasicAuthenticationAdapter' => 'LearnZF2Authentication\Factory\BasicAuthenticationAdapterFactory',
            'LearnZF2Authentication\DigestAuthenticationAdapter' => 'LearnZF2Authentication\Factory\DigestAuthenticationAdapterFactory',
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
