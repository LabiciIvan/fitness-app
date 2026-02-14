<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => fake()->words(2, true),
            'description'   => fake()->sentence(),
            'price'         => fake()->numberBetween(0, 50),
            'limit'         => fake()->numberBetween(0, 50),
            'schedule'      => [
                'days' => [1, 2, 3, 4, 5],
                'time' => [
                    1 => ['start' => '07:00', 'end' => '08:00'],
                    2 => ['start' => '07:00', 'end' => '08:00'],
                    3 => ['start' => '07:00', 'end' => '08:00'],
                    4 => ['start' => '07:00', 'end' => '08:00'],
                    5 => ['start' => '07:00', 'end' => '08:00'],
                ],
            ],
            'difficulty'    => fake()->randomElement(config('tables.programs.difficulty')),
            'logo'          => "https://picsum.photos/id/" . fake()->numberBetween(1, 100) . "/90/90",
        ];
    }
}
