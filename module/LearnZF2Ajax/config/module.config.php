<?php

return array(
    'router' => array(
        'routes' => array(

            'learnZF2Ajax' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-ajax',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LearnZF2Ajax\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'LearnZF2Ajax\Controller\Index' => 'LearnZF2Ajax\Factory\Controller\IndexControllerFactory',
        ),
    ),
    'view_manager' => array(
        'factories' => array(
            'LearnZF2Ajax\Controller\Index' => 'LearnZF2Ajax\Factory\Controller\IndexControllerFactory',
        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),
);
