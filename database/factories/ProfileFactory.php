<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sex'          => fake()->randomElement(config('tables.profiles.sex')),
            'description'  => fake()->sentence(5),
            'country'      => fake()->country(),
            'city'         => fake()->city(),
            'phone'        => fake()->phoneNumber(),
            'logo'         => "https://picsum.photos/id/" . fake()->numberBetween(1, 100) . "/50/50",
            'complete'     => true
        ];
    }
}
