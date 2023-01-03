<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Toeslag>
 */
class ExhibitorFactoryToeslagen extends Factory
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
            'toeslagbegintijd' => $this->faker->time(),
            'toeslageindtijd' => $this->faker->time(),
            'toeslagsoort' => $this->faker->name(),
        //    'toeslagpercentage' => $this->faker->numberBetween([int1 : int = 100], [int2 : int = 140]),
            'toeslagpercentage' => $this->faker->randomNumber(),
        //    'uurtarief' => $this->faker->numberBetween([int1 : int = 8], [int2 : int = 14]),
            'uurtarief' => $this->faker->randomNumber(),
            'userid' => $this->faker->randomNumber(7),

        ];
    }
}
