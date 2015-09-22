<?php

return array(
    'router' => array(
        'routes' => array(

            'learn-zf2-barcode-usage' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-barcode',
                    'defaults' => array(
                        '__NAMESPACE__' => 'LearnZF2Barcode\Controller',
                        'controller' => 'Barcode',
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
            'LearnZF2Barcode\Controller\Barcode' => 'LearnZF2Barcode\Factory\Controller\BarcodeControllerFactory',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'BarcodeObjectPluginManager' => 'LearnZF2Barcode\Factory\Service\BarcodeObjectPluginManagerFactory',
        ),
    ),

    'form_elements' => array(
        'factories' => array(
            'LearnZF2Barcode\Form\BarcodeForm' => 'LearnZF2Barcode\Factory\Form\BarcodeFormFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'learn-zf2-barcode' => __DIR__.'/../view',
        ),
    ),
);
