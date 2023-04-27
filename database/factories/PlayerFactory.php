<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /*
    Player - egy játékos adatai
        id
        name (string)
        number (integer, a játékos mezszáma)
        birthdate (date)
        időbélyegek
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->numberBetween(1, 99),
            'birthdate' => $this->faker->date(),
        ];
    }
}
