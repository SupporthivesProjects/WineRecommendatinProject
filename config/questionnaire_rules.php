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
                    'Loire Valley',
                    'Bordeaux',
                    'Burgundy',
                    'Rhone Valley',
                    'Languedoc-Roussillon',
                    'Provence',
                    'Alsace',
                    'Champagne',
                ],
                'Germany' => [
                    'Franken',
                    'Nahe',
                    'Pfalz',
                    'Mosel',
                    'Rheingau',
                    'Rheinhessen',
                ],
                'Italy' => [
                    'Tuscany',
                    'Veneto',
                    'Piedmont',
                    'Sicily',
                    'Umbria',
                    'Abruzzo',
                    'Friuli Venezia Giulia',
                    'Emilia-Romagna',
                    'Puglia',
                ],

                'Spain' => [
                    'Rioja',
                    'Ribera Del Duero',
                    'Penedes',
                    'Jerez',
                    'Castilla-La Mancha',
                ],
                'Australia' => [
                    'South Eastern Australia',
                    'Barossa Valley',
                    'South Australia',
                    'Eden Valley',
                    'Mclaren Vale',
                    'Margaret River',
                ],
                'USA' => [
                    'Oregon',
                    'Washington',
                    'Livermore Valley',
                    'Sonoma County',
                    'Napa Valley',
                    'Russian River Valley',
                    'Central Coast',
                ],
                'India' => [
                    'Nashik',
                    'Nandi Hills',
                    'Akluj',
                    'Sahyadri Valley',
                    'Karnataka',
                ],
                'Chile' => [                    
                    'Maipo Valley',
                    'Central Valley',
                    'Elqui Valley',
                    'Curico Valley',
                    'Maule Valley',
                    'Colchagua Valley',
                ],

                'Portugal' => [
                    'Madeira',
                    'Douro',
                    'Dao',
                    'Lisboa',
                    'Setubal',
                    'Vinho Verde',
                ],

                'New Zealand' => [
                    'Marlborough',
                    'Martinborough',
                    'Central Otago',
                ],

                'South Africa' => [
                    'Swartland',
                    'Stellenbosch',
                    'Paarl',
                    'Western Cape',
                    'Robertson Valley',
                    'Cape Town',
                ],
                'Argentina' => [
                    'Cafayate',
                    'Mendoza',
                    'Lujan De Cuyo',
                ]
            ]

        ],
        [
            'source' => 'wine_type',
            'target' => 'sub_region',
            'action' => 'hide_option',
            'when' => 'Red',
            'options' => [
                'Champagne'
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
        
                'Old World' => [
                    'France',
                    'Germany',
                    'Italy',
                    'Spain',
                    'Portugal',
                    'Austria'
                ],
        
                'New World' => [
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