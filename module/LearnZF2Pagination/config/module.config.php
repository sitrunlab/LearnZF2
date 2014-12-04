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
            'LearnZF2Pagination\Controller\Index' => 'LearnZF2Pagination\Factory\Controller\IndexControllerFactory'
        ]
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],

    'pagination_data' => [
        // @see http://www.imdb.com/list/ls055592025/
        'movies' => [
            [
                'title' => 'The Godfather',
                'year' => 1972,
            ],
            [
                'title' => 'The Shawshank Redemption',
                'year' => 1994,
            ],
            [
                'title' => 'Schindler\'s List',
                'year' => 1993,
            ],
            [
                'title' => 'Raging Bull',
                'year' => 1980,
            ],
            [
                'title' => 'Casablanca',
                'year' => 1942,
            ],
            [
                'title' => 'One Flew Over the Cuckoo\'s Nest',
                'year' => 1975,
            ],
            [
                'title' => 'Gone with the Wind',
                'year' => 1939,
            ],
            [
                'title' => 'Citizen Kane',
                'year' => 1941,
            ],
            [
                'title' => 'The Wizard of Oz',
                'year' => 1939,
            ],
            [
                'title' => 'Titanic',
                'year' => 1997,
            ],
        ],
        //@see http://en.wikipedia.org/wiki/Le_Monde%27s_100_Books_of_the_Century
        'books' => [
            [
                'title' => 'The Stranger',
                'year' => 1942,
            ],
            [
                'title' => 'In Search of Lost Time',
                'year' => 1913,
            ],
            [
                'title' => 'The Trial',
                'year' => 1925,
            ],
            [
                'title' => 'The Little Prince',
                'year' => 1943,
            ],
            [
                'title' => 'Man\'s Fate',
                'year' => 1933,
            ],
            [
                'title' => 'Journey to the End of the Night',
                'year' => 1932,
            ],
            [
                'title' => 'The Grapes of Wrath',
                'year' => 1939,
            ],
            [
                'title' => 'For Whom the Bell Tolls',
                'year' => 1940,
            ],
            [
                'title' => 'Le Grand Meaulnes',
                'year' => 1913,
            ],
            [
                'title' => 'Froth on the Daydream',
                'year' => 1947,
            ],
        ],
        // @see http://www.rollingstone.com/music/lists/500-greatest-albums-of-all-time-20120531
        'music' => [
            [
                'title' => 'The Beatles - Sgt. Pepper\'s Lonely Hearts Club Band',
                'year' => 1967,
            ],
            [
                'title' => 'The Beach Boys - Pet Sounds',
                'year' => 1966,
            ],
            [
                'title' => 'The Beatles - Revolver',
                'year' => 1966,
            ],
            [
                'title' => 'Bob Dylan - Highway 61 Revisited',
                'year' => 1965,
            ],
            [
                'title' => 'The Beatles - Rubber Soul',
                'year' => 1965,
            ],
            [
                'title' => 'Marvin Gaye - What\'s Going On',
                'year' => 1971,
            ],
            [
                'title' => 'The Rolling Stones - Exile on Main Street',
                'year' => 1972,
            ],
            [
                'title' => 'The Clash - London Calling',
                'year' => 1980,
            ],
            [
                'title' => 'Bob Dylan - Blonde on Blonde',
                'year' => 1966,
            ],
            [
                'title' => 'The Beatles - The White Album',
                'year' => 1968,
            ],
        ]
    ]
];
