<?php return array (
  'router' => 
  array (
    'routes' => 
    array (
      'learn-zf2-themes' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/learn-zf2-themes',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'LearnZF2Themes\\Controller',
            'controller' => 'Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'default' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/[:controller[/:action]]',
              'constraints' => 
              array (
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              ),
              'defaults' => 
              array (
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'controllers' => 
  array (
    'factories' => 
    array (
      'LearnZF2Themes\\Controller\\Index' => 'LearnZF2Themes\\Factory\\Controller\\IndexControllerFactory',
    ),
  ),
  'service_manager' => 
  array (
    'factories' => 
    array (
      'initThemes' => 'LearnZF2Themes\\Factory\\ThemesFactory',
      'getThemesFromDir' => 'LearnZF2Themes\\Factory\\GetThemesFromDir',
    ),
    'invokables' => 
    array (
      'reloadService' => 'LearnZF2Themes\\Service\\ReloadService',
    ),
  ),
  'theme' => 
  array (
    'name' => 'red-theme',
  ),
);