<?php

return array(
    'router' => array(
        'routes' => array(
            'learn-zf2-authentication' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-authentication',
                    'defaults' => array(
                        'controller' => 'LearnZF2Authentication\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'authentication_basic' => array(
        'adapter' => array(
            'config' => array(
                'accept_schemes' => 'basic',
                'realm' => 'authentication',
                'nonce_timeout' => 3600,
            ),
            'basic' => __DIR__.'/auth/basic.txt',
        ),
    ),
    'authentication_digest' => array(
        'adapter' => array(
            'config' => array(
                'accept_schemes' => 'digest',
                'realm' => 'authentication',
                'digest_domains' => '/learn-zf2-authentication/digest',
                'nonce_timeout' => 3600,
            ),
            'digest' => __DIR__.'/auth/digest.txt',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'LearnZF2Authentication\BasicAuthenticationAdapter' => 'LearnZF2Authentication\Factory\BasicAuthenticationAdapterFactory',
            'LearnZF2Authentication\DigestAuthenticationAdapter' => 'LearnZF2Authentication\Factory\DigestAuthenticationAdapterFactory',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'LearnZF2Authentication\Controller\Index' => 'LearnZF2Authentication\Controller\IndexController',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
);
