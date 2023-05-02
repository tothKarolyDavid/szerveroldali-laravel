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
    private $current_team_id = 1;
    private $current_num_of_players = 0;

    public function definition(): array
    {
        $this->current_num_of_players++;
        $team_id = $this->current_team_id;

        if ($this->current_num_of_players == 11) {
            $this->current_team_id++;
            $this->current_num_of_players = 0;
        }

        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->numberBetween(1, 99),
            'birthdate' => $this->faker->date(),
            'team_id' => $team_id,
        ];
    }
}
