<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tijd>
 */
class ExhibitorFactoryTijden extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'datum' => $this->faker->date(),
            'begintijd' => $this->faker->time(),
            'eindtijd' => $this->faker->time(),

        ];
    }
}
