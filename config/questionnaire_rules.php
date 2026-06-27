<?php

return [

    1 => [

    ],

    2 => [

        [
            'source' => 'country',

            'target' => 'sub_region',

            'action' => 'filter',

            'mapping' => [

                'France' => [
                    'Burgundy (France)',
                    'Champagne (France)',
                    'Rhône Valley (France)',
                ],

                'Italy' => [
                    'Tuscany (Italy)',
                    'Piedmont (Italy)',
                    'Veneto (Italy)',
                ],

                'Spain' => [
                    'Rioja (Spain)',
                    'Ribera del Duero (Spain)',
                ],

                'USA' => [
                    'Napa Valley (USA)',
                    'Sonoma (USA)',
                ],

                'Australia' => [
                    'Barossa Valley (Australia)',
                    'Margaret River (Australia)',
                ],

                'India' => [
                    'India',
                ],

                'Rest of the World' => [
                    'Marlborough (New Zealand)',
                ]

            ]

        ],
        [
            'source' => 'wine_type',
            'target' => 'sub_region',
            'action' => 'hide_option',
            'when' => 'Red',
            'options' => [
                'Champagne (France)'
            ]
        ],
       

    ],

    3 => [
        [
            'source' => 'wine_type',
            'target' => 'tannin',
            'action' => 'skip_question',
            'when' => 'White'
        ],
        [
            'source' => 'wine_type',
            'target' => 'tannin',
            'action' => 'hide_option',
            'when' => 'Rosé',
            'options' => [
                'medium to high',
                'high'
            ]
        ],
        [
            'source' => 'region',
        
            'target' => 'country',
        
            'action' => 'filter',
        
            'mapping' => [
        
                'Domestic Indian' => [
                    'India'
                ],
        
                'Old World (France, Germany, Italy, Spain, Portugal, Austria)' => [
                    'France',
                    'Germany',
                    'Italy',
                    'Spain',
                    'Portugal',
                    'Austria'
                ],
        
                'New World (USA, Chile, Australia, Argentina,)' => [
                    'USA',
                    'Chile',
                    'Australia',
                    'Argentina',
                    'South Africa',
                    'New Zealand'
                ],
        
                'No Preference' => 'ALL',
        
            ]
        ],

    ],

    4 => [

    ]

];