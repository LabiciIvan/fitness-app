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
            'difficulty'    => fake()->randomElement(config('tables.programs.difficulty')),
            'logo'          => "https://picsum.photos/id/" . fake()->numberBetween(1, 100) . "/90/90",
        ];
    }
}
