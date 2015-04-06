<?php
return [
    'router' => [
        'routes' => [

            'learn-zf2-pagination' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/learn-zf2-pagination',
                    'defaults' => [
                        'controller'    => 'LearnZF2Pagination\Controller\Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '[/:action]',
                            'constraints' => [
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            'LearnZF2Pagination\Controller\Index' => 'LearnZF2Pagination\Factory\Controller\IndexControllerFactory',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],

    'view_helpers' => [
        'factories' => [
            'queryUrl' => 'LearnZF2Pagination\Factory\View\Helper\QueryUrlFactory',
        ],
    ],

    'pagination_data' => [
        // @see http://www.imdb.com/list/ls055592025/
        'movies' => [
            [
                'title' => 'The Godfather',
                'category' => 'movies',
                'year' => 1972,
            ],
            [
                'title' => 'The Shawshank Redemption',
                'category' => 'movies',
                'year' => 1994,
            ],
            [
                'title' => 'Schindler\'s List',
                'category' => 'movies',
                'year' => 1993,
            ],
            [
                'title' => 'Raging Bull',
                'category' => 'movies',
                'year' => 1980,
            ],
            [
                'title' => 'Casablanca',
                'category' => 'movies',
                'year' => 1942,
            ],
            [
                'title' => 'One Flew Over the Cuckoo\'s Nest',
                'category' => 'movies',
                'year' => 1975,
            ],
            [
                'title' => 'Gone with the Wind',
                'category' => 'movies',
                'year' => 1939,
            ],
            [
                'title' => 'Citizen Kane',
                'category' => 'movies',
                'year' => 1941,
            ],
            [
                'title' => 'The Wizard of Oz',
                'category' => 'movies',
                'year' => 1939,
            ],
            [
                'title' => 'Titanic',
                'category' => 'movies',
                'year' => 1997,
            ],
        ],
        //@see http://en.wikipedia.org/wiki/Le_Monde%27s_100_Books_of_the_Century
        'books' => [
            [
                'title' => 'The Stranger',
                'category' => 'books',
                'year' => 1942,
            ],
            [
                'title' => 'In Search of Lost Time',
                'category' => 'books',
                'year' => 1913,
            ],
            [
                'title' => 'The Trial',
                'category' => 'books',
                'year' => 1925,
            ],
            [
                'title' => 'The Little Prince',
                'category' => 'books',
                'year' => 1943,
            ],
            [
                'title' => 'Man\'s Fate',
                'category' => 'books',
                'year' => 1933,
            ],
            [
                'title' => 'Journey to the End of the Night',
                'category' => 'books',
                'year' => 1932,
            ],
            [
                'title' => 'The Grapes of Wrath',
                'category' => 'books',
                'year' => 1939,
            ],
            [
                'title' => 'For Whom the Bell Tolls',
                'category' => 'books',
                'year' => 1940,
            ],
            [
                'title' => 'Le Grand Meaulnes',
                'category' => 'books',
                'year' => 1913,
            ],
            [
                'title' => 'Froth on the Daydream',
                'category' => 'books',
                'year' => 1947,
            ],
        ],
        // @see http://www.rollingstone.com/music/lists/500-greatest-albums-of-all-time-20120531
        'music' => [
            [
                'title' => 'The Beatles - Sgt. Pepper\'s Lonely Hearts Club Band',
                'category' => 'music',
                'year' => 1967,
            ],
            [
                'title' => 'The Beach Boys - Pet Sounds',
                'category' => 'music',
                'year' => 1966,
            ],
            [
                'title' => 'The Beatles - Revolver',
                'category' => 'music',
                'year' => 1966,
            ],
            [
                'title' => 'Bob Dylan - Highway 61 Revisited',
                'category' => 'music',
                'year' => 1965,
            ],
            [
                'title' => 'The Beatles - Rubber Soul',
                'category' => 'music',
                'year' => 1965,
            ],
            [
                'title' => 'Marvin Gaye - What\'s Going On',
                'category' => 'music',
                'year' => 1971,
            ],
            [
                'title' => 'The Rolling Stones - Exile on Main Street',
                'category' => 'music',
                'year' => 1972,
            ],
            [
                'title' => 'The Clash - London Calling',
                'category' => 'music',
                'year' => 1980,
            ],
            [
                'title' => 'Bob Dylan - Blonde on Blonde',
                'category' => 'music',
                'year' => 1966,
            ],
            [
                'title' => 'The Beatles - The White Album',
                'category' => 'music',
                'year' => 1968,
            ],
        ],
    ],
];
