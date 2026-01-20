<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class TypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->randomElement(config('tables.types.title'))
        ];
    }

    public function trainer(): Factory {
        return $this->state(function (array $attributes) {
            return [
                'title' => config('tables.types.title.0')
            ];
        });
    }

    public function customer(): Factory {
        return $this->state(function (array $attributes) {
            return [
                'title' => config('tables.types.title.1')
            ];
        });
    }
}
