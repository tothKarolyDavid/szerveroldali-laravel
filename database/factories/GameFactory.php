<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /*
    Game - egy mérkőzés
        id
        start (datetime)
        finished (logikai, alapértelmezetten hamis)
        időbélyegek
    */
    public function definition(): array
    {
        return [
            'start' => $this->faker->dateTime(),
            'finished' => $this->faker->boolean(),
        ];
    }
}
