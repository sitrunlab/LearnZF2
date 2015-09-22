<?php

return array(
    'router' => array(
        'routes' => array(

            'learn-zf2-i18n' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-i18n',
                    'defaults' => array(
                        'controller' => 'LearnZF2I18n\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:action',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'LearnZF2I18n\Controller\Index' => 'LearnZF2I18n\Controller\IndexController',
        ),
    ),

    'service_manager' => array(
        'aliases' => array(
            'translator' => 'mvctranslator',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),

    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'base_dir' => __DIR__.'/../languages/phpArray',
                'type' => 'phpArray',
                'pattern' => '%s.php',
            ),
            array(
                'base_dir' => __DIR__.'/../languages/gettext',
                'type' => 'gettext',
                'pattern' => '%s.mo',
            ),
        ),
    ),
);
