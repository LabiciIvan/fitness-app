<?php

return [
    'types' => [
        'customerKey' => 'customer',
        'trainerKey' => 'trainer',
        'adminKey' => 'admin',
        'title' => ['trainer', 'customer', 'admin']
    ],
    'profiles' => [
        'sex' => ['male', 'female']
    ],
    'programs' => [
        'CRUD' => [
            'create' => 'Create program'
        ],
        'difficulty' => ['beginner', 'intermediate', 'advanced']
    ],
    'categories' => [
        'title' => [
            'Muscle Gain',
            'Weight Loss',
            'Strength',
            'Endurance',
            'Wellness',
            'General Fitness',
            'Rehabilitation / Recovery',
            'Sports Performance',
        ],
        'description' => [
            'Muscle Gain'                 => 'For hypertrophy, building size, improving aesthetics.',
            'Weight Loss'                 => 'Fat-loss, calorie-burning, cutting phases.',
            'Strength'                    => 'Powerlifting, heavy lifting, performance strength.',
            'Endurance'                   => 'Running, cycling, conditioning, stamina.',
            'Wellness'                    => 'Mobility, flexibility, yoga, light training, meditation',
            'General Fitness'             => 'Balanced training for people who want to move and feel healthy.',
            'Rehabilitation / Recovery'   => 'Physical therapy, injury recovery, corrective exercises.',
            'Sports Performance'          => 'Athlete-specific training (boxing, basketball, football, etc.)',
        ],
    ]
];
