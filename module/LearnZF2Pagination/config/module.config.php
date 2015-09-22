<?php

return array(
    'router' => array(
        'routes' => array(

            'learn-zf2-pagination' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/learn-zf2-pagination',
                    'defaults' => array(
                        'controller' => 'LearnZF2Pagination\Controller\Index',
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

    'controllers' => array(
        'factories' => array(
            'LearnZF2Pagination\Controller\Index' => 'LearnZF2Pagination\Factory\Controller\IndexControllerFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__.'/../view',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
            'queryUrl' => 'LearnZF2Pagination\Factory\View\Helper\QueryUrlFactory',
        ),
    ),

    'pagination_data' => array(
        // @see http://www.imdb.com/list/ls055592025/
        'movies' => array(
            array(
                'title' => 'The Godfather',
                'category' => 'movies',
                'year' => 1972,
            ),
            array(
                'title' => 'The Shawshank Redemption',
                'category' => 'movies',
                'year' => 1994,
            ),
            array(
                'title' => 'Schindler\'s List',
                'category' => 'movies',
                'year' => 1993,
            ),
            array(
                'title' => 'Raging Bull',
                'category' => 'movies',
                'year' => 1980,
            ),
            array(
                'title' => 'Casablanca',
                'category' => 'movies',
                'year' => 1942,
            ),
            array(
                'title' => 'One Flew Over the Cuckoo\'s Nest',
                'category' => 'movies',
                'year' => 1975,
            ),
            array(
                'title' => 'Gone with the Wind',
                'category' => 'movies',
                'year' => 1939,
            ),
            array(
                'title' => 'Citizen Kane',
                'category' => 'movies',
                'year' => 1941,
            ),
            array(
                'title' => 'The Wizard of Oz',
                'category' => 'movies',
                'year' => 1939,
            ),
            array(
                'title' => 'Titanic',
                'category' => 'movies',
                'year' => 1997,
            ),
        ),
        //@see http://en.wikipedia.org/wiki/Le_Monde%27s_100_Books_of_the_Century
        'books' => array(
            array(
                'title' => 'The Stranger',
                'category' => 'books',
                'year' => 1942,
            ),
            array(
                'title' => 'In Search of Lost Time',
                'category' => 'books',
                'year' => 1913,
            ),
            array(
                'title' => 'The Trial',
                'category' => 'books',
                'year' => 1925,
            ),
            array(
                'title' => 'The Little Prince',
                'category' => 'books',
                'year' => 1943,
            ),
            array(
                'title' => 'Man\'s Fate',
                'category' => 'books',
                'year' => 1933,
            ),
            array(
                'title' => 'Journey to the End of the Night',
                'category' => 'books',
                'year' => 1932,
            ),
            array(
                'title' => 'The Grapes of Wrath',
                'category' => 'books',
                'year' => 1939,
            ),
            array(
                'title' => 'For Whom the Bell Tolls',
                'category' => 'books',
                'year' => 1940,
            ),
            array(
                'title' => 'Le Grand Meaulnes',
                'category' => 'books',
                'year' => 1913,
            ),
            array(
                'title' => 'Froth on the Daydream',
                'category' => 'books',
                'year' => 1947,
            ),
        ),
        // @see http://www.rollingstone.com/music/lists/500-greatest-albums-of-all-time-20120531
        'music' => array(
            array(
                'title' => 'The Beatles - Sgt. Pepper\'s Lonely Hearts Club Band',
                'category' => 'music',
                'year' => 1967,
            ),
            array(
                'title' => 'The Beach Boys - Pet Sounds',
                'category' => 'music',
                'year' => 1966,
            ),
            array(
                'title' => 'The Beatles - Revolver',
                'category' => 'music',
                'year' => 1966,
            ),
            array(
                'title' => 'Bob Dylan - Highway 61 Revisited',
                'category' => 'music',
                'year' => 1965,
            ),
            array(
                'title' => 'The Beatles - Rubber Soul',
                'category' => 'music',
                'year' => 1965,
            ),
            array(
                'title' => 'Marvin Gaye - What\'s Going On',
                'category' => 'music',
                'year' => 1971,
            ),
            array(
                'title' => 'The Rolling Stones - Exile on Main Street',
                'category' => 'music',
                'year' => 1972,
            ),
            array(
                'title' => 'The Clash - London Calling',
                'category' => 'music',
                'year' => 1980,
            ),
            array(
                'title' => 'Bob Dylan - Blonde on Blonde',
                'category' => 'music',
                'year' => 1966,
            ),
            array(
                'title' => 'The Beatles - The White Album',
                'category' => 'music',
                'year' => 1968,
            ),
        ),
    ),
);
