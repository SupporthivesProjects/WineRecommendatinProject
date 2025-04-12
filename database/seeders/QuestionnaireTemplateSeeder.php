<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionnaireTemplate;

class QuestionnaireTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level 1: First Sip (Basic)
        QuestionnaireTemplate::create([
            'name' => 'First Sip (Basic Level)',
            'level' => 'first_sip',
            'description' => 'A simple questionnaire to help beginners find wines they might enjoy.',
            'is_active' => true,
            'questions' => [
                [
                    'text' => 'What type of wine are you in the mood for?',
                    'type' => 'single',
                    'options' => ['Red', 'White', 'Rosé', 'Fruit']
                ],
                [
                    'text' => 'Would you like your wine to be still or sparkling?',
                    'type' => 'single',
                    'options' => ['Still', 'Sparkling/Champagne']
                ],
                [
                    'text' => 'Do you prefer your wine to be sweet or dry?',
                    'type' => 'single',
                    'options' => ['Sweet', 'Medium Sweet', 'Lightly Sweet', 'Dry']
                ],
                [
                    'text' => 'What kind of Flavor Profile are you looking at? (select up to two)',
                    'type' => 'multiple',
                    'options' => ['Fruit-Driven', 'Juicy/Fruit-Forward', 'Aromatic', 'Earthy', 'Mineral-Driven']
                ],
                [
                    'text' => 'How bold do you like your wine?',
                    'type' => 'single',
                    'options' => ['Light-bodied (Soft & Refreshing)', 'Medium-bodied (Balanced & Smooth)', 'Full-bodied (Rich & Intense)']
                ],
                [
                    'text' => 'How fruity do you want your wine to be?',
                    'type' => 'single',
                    'options' => ['Very Fruity', 'Slightly Fruity', 'Not Fruity']
                ],
                [
                    'text' => 'How old do you want your wine to be?',
                    'type' => 'single',
                    'options' => ['Young and Refreshing', 'Bold and Old']
                ],
                [
                    'text' => 'Would you like to explore wines from a specific region?',
                    'type' => 'single',
                    'options' => ['Any', 'India', 'France', 'Italy', 'Spain', 'Australia', 'USA', 'Rest of the World']
                ],
                [
                    'text' => 'What\'s your budget range?',
                    'type' => 'slider',
                    'min' => 300,
                    'max' => 1000000,
                    'step' => 100,
                    'default' => 5000
                ],
                [
                    'text' => 'Are you looking for a wine for a specific occasion?',
                    'type' => 'single',
                    'options' => ['Everyday sipping', 'Celebration', 'Gifting', 'Pairing with food (Coming Soon)']
                ]
            ]
        ]);

        // Level 2: Savy Sipper (Intermediate)
        QuestionnaireTemplate::create([
            'name' => 'Savy Sipper (Semi-Pro Level)',
            'level' => 'savy_sipper',
            'description' => 'A more detailed questionnaire for those with some wine knowledge.',
            'is_active' => true,
            'questions' => [
                [
                    'text' => 'What type of wine are you looking for?',
                    'type' => 'single',
                    'options' => ['Red', 'White', 'Rosé', 'Sparkling', 'Fruit Wine']
                ],
                [
                    'text' => 'Preferred taste profile?',
                    'type' => 'single',
                    'options' => ['Sweet', 'Semi-Sweet', 'Off-Dry (Lightly Sweet)', 'Dry (Not Sweet)']
                ],
                [
                    'text' => 'Preferred wine country? (you can select multiple options)',
                    'type' => 'multiple',
                    'options' => ['No Preference', 'India', 'France', 'Germany', 'Italy', 'Spain', 'Australia', 'USA', 'Rest of the World']
                ],
                [
                    'text' => 'Which sub-region would you like to explore? (Optional)',
                    'type' => 'single',
                    'options' => [
                        'No Preference',
                        'Bordeaux (France)', 
                        'Burgundy (France)', 
                        'Champagne (France)',
                        'Rhône Valley (France)',
                        'Tuscany (Italy)', 
                        'Piedmont (Italy)',
                        'Veneto (Italy)', 
                        'Rioja (Spain)',
                        'Ribera del Duero (Spain)', 
                        'Napa Valley (USA)',
                        'Sonoma (USA)', 
                        'Barossa Valley (Australia)',
                        'Margaret River (Australia)', 
                        'Marlborough (New Zealand)',
                        'Mosel (Germany)',
                        'Rheingau (Germany)',
                        'Douro (Portugal)',
                        'Nashik (India)',
                        'Bangalore (India)'
                    ]
                ],
                [
                    'text' => 'Which grape varietals do you prefer?',
                    'type' => 'multiple',
                    'options' => [
                        'Chardonnay',
                        'Riesling',
                        'Sauvignon Blanc',
                        'Chenin Blanc',
                        'Pinot Noir',
                        'Cabernet Sauvignon',
                        'Merlot',
                        'Syrah/Shiraz'
                    ]
                ],
                [
                    'text' => 'Preferred wine age?',
                    'type' => 'single',
                    'options' => [
                        'Refreshingly Young (1-3 years)',
                        'Fairly Young (3-5 years)',
                        'Slightly Aged (5-7 years)',
                        'Aged (>7 years)'
                    ]
                ],
                [
                    'text' => 'What flavor profiles interest you?',
                    'type' => 'multiple',
                    'options' => [
                        'Nuts, Dried, Cooked, Fresh, Caramel, Jammy',
                        'Earthy, Moldy, Petroleum, Sulfur, Minerality',
                        'Yeasty, Lactic, Floral, Spicy, Citrus, Berry, Fruity, Tropical',
                        'Herbaceous, Vegetative'
                    ]
                ],
                [
                    'text' => 'Are you looking for a wine for a specific occasion?',
                    'type' => 'single',
                    'options' => [
                        'Everyday sipping',
                        'Celebration',
                        'Gifting',
                        'Pairing with food (Coming Soon)'
                    ]
                ],
                [
                    'text' => 'What is your price range?',
                    'type' => 'slider',
                    'min' => 500,
                    'max' => 200000,
                    'step' => 500,
                    'default' => 10000
                ]
            ]
        ]);

        // Level 3: Pro (Advanced)
        QuestionnaireTemplate::create([
            'name' => 'Pro (Advanced Level)',
            'level' => 'pro',
            'description' => 'A comprehensive questionnaire for wine enthusiasts and professionals.',
            'is_active' => true,
            'questions' => [
                [
                    'text' => 'What type of wine are you looking for?',
                    'type' => 'single',
                    'options' => ['Red', 'White', 'Rosé', 'Sparkling', 'Fortified', 'Dessert', 'Orange/Skin Contact']
                ],
                [
                    'text' => 'Preferred taste profile?',
                    'type' => 'single',
                    'options' => ['Sweet', 'Semi-Sweet', 'Off-Dry', 'Dry', 'Bone Dry']
                ],
                [
                    'text' => 'Preferred wine country and region?',
                    'type' => 'multiple',
                    'options' => [
                        'Bordeaux (France)', 
                        'Burgundy (France)', 
                        'Champagne (France)',
                        'Rhône Valley (France)',
                        'Loire Valley (France)',
                        'Alsace (France)',
                        'Tuscany (Italy)', 
                        'Piedmont (Italy)',
                        'Veneto (Italy)',
                        'Sicily (Italy)', 
                        'Rioja (Spain)',
                        'Ribera del Duero (Spain)',
                        'Priorat (Spain)', 
                        'Napa Valley (USA)',
                        'Sonoma (USA)',
                        'Willamette Valley (USA)', 
                        'Barossa Valley (Australia)',
                        'Margaret River (Australia)',
                        'Hunter Valley (Australia)', 
                        'Marlborough (New Zealand)',
                        'Central Otago (New Zealand)',
                        'Mosel (Germany)',
                        'Rheingau (Germany)',
                        'Pfalz (Germany)',
                        'Douro (Portugal)',
                        'Dão (Portugal)',
                        'Nashik (India)',
                        'Bangalore (India)'
                    ]
                ],
                [
                    'text' => 'Which specific grape varietals are you interested in?',
                    'type' => 'multiple',
                    'options' => [
                        'Chardonnay',
                        'Riesling',
                        'Sauvignon Blanc',
                        'Chenin Blanc',
                        'Viognier',
                        'Gewürztraminer',
                        'Pinot Grigio/Gris',
                        'Albariño',
                        'Pinot Noir',
                        'Cabernet Sauvignon',
                        'Merlot',
                        'Syrah/Shiraz',
                        'Grenache/Garnacha',
                        'Tempranillo',
                        'Sangiovese',
                        'Nebbiolo',
                        'Malbec',
                        'Zinfandel',
                        'Petit Verdot',
                        'Cabernet Franc'
                    ]
                ],
                [
                    'text' => 'What vintage range are you looking for?',
                    'type' => 'single',
                    'options' => [
                        'Current release (1-2 years)',
                        'Young (3-5 years)',
                        'Medium age (5-10 years)',
                        'Mature (10-20 years)',
                        'Aged (20+ years)',
                        'Specific vintage (please specify in notes)'
                    ]
                ],
                [
                    'text' => 'What specific flavor profiles are you seeking?',
                    'type' => 'multiple',
                    'options' => [
                        'Primary fruit (fresh berries, stone fruit, citrus)',
                        'Secondary (yeast, lactic, butter, cream)',
                        'Tertiary (nuts, dried fruit, leather, tobacco, earth)',
                        'Oak influence (vanilla, toast, smoke, spice)',
                        'Minerality (flint, chalk, saline)',
                        'Herbaceous (grass, herbs, bell pepper)',
                        'Floral (rose, violet, jasmine)',
                        'Spice (pepper, cinnamon, clove)'
                    ]
                ],
                [
                    'text' => 'What structural elements are important to you?',
                    'type' => 'multiple',
                    'options' => [
                        'High acidity',
                        'Moderate acidity',
                        'Low acidity',
                        'High tannins',
                        'Moderate tannins',
                        'Soft tannins',
                        'Full body',
                        'Medium body',
                        'Light body',
                        'High alcohol',
                        'Moderate alcohol',
                        'Low alcohol'
                    ]
                ],
                [
                    'text' => 'Are you interested in any specific winemaking styles?',
                    'type' => 'multiple',
                    'options' => [
                        'Organic',
                        'Biodynamic',
                        'Natural/Low intervention',
                        'Sustainable',
                        'Traditional methods',
                        'Modern techniques',
                        'Amphora/Clay pot aged',
                        'Concrete egg fermented',
                        'Oak barrel aged',
                        'Stainless steel fermented',
                        'No preference'
                    ]
                ],
                [
                    'text' => 'What is your price range?',
                    'type' => 'slider',
                    'min' => 1000,
                    'max' => 500000,
                    'step' => 1000,
                    'default' => 25000
                ]
            ]
        ]);
    }
}
