<?php

return [
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
                'priority' => 1.00,
                'changefreq' => 'always',
            ],
            [
                'label' => 'Contributors',
                'route' => 'contributors',
                'priority' => 0.80,
                'changefreq' => 'weekly',
            ],
            [
                'label' => 'Credits',
                'route' => 'credits',
            ],
        ],
    ],
];
