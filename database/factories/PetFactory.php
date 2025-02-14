<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'species' => $this->faker->word,
            'breed' => $this->faker->word,
            'age' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->randomElement(['available', 'sold']),
            'detail' => $this->faker->sentence,
            'photo' => $this->faker->word,
        ];
    }
}
