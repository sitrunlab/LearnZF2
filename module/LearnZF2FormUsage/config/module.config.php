<?php

return array(
    'router' => array(
        'routes' => array(
            'learn-zf2-form-usage' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/learn-zf2-form-usage',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LearnZF2FormUsage\Controller',
                        'controller'    => 'Form',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'LearnZF2FormUsage\Controller\Form' => 'LearnZF2FormUsage\Controller\FormController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'learnzf2usage' => __DIR__ . '/../view',
        ),
    ),
);
