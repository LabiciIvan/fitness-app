<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{

    private array $tags = [
        'Strength Training',
        'Cardio',
        'HIIT',
        'Weight Loss',
        'Muscle Gain',
        'Full Body',
        'Upper Body',
        'Lower Body',
        'Core Training',
        'Flexibility',
        'Mobility',
        'Endurance',
        'Bodyweight Training',
        'Home Workout',
        'Gym Workout',
        'Beginner',
        'Intermediate',
        'Advanced',
        'CrossFit',
        'Powerlifting',
        'Bodybuilding',
        'Warm-Up',
        'Cooldown',
        'Stretching',
        'Yoga',
        'Pilates',
        'Kettlebell',
        'Dumbbells',
        'Barbell',
        'Resistance Bands',
        'Functional Training',
        'Fat Burning',
        'Calisthenics',
        'Athletic Training',
        'Strength & Conditioning',
        'Balance Training',
        'Posture Correction',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->tags as $tag) {
            Tag::factory()->create(['tag' => $tag]);
        }

    }
}
