<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use App\Models\Team;


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
        $teams = Team::all();

        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->numberBetween(1, 99),
            'birthdate' => $this->faker->date(),

            'team_id' => $teams->random()->id(),
        ];
    }
}
