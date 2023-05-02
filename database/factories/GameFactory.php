<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\Team;

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
        $teams = Team::all();
        $homeTeam = $teams->random();
        $awayTeam = $teams->where('id', '!=', $homeTeam->id())->random();

        return [
            'start' => $this->faker->dateTime(),
            'finished' => $this->faker->boolean(),

            'home_team_id' => $homeTeam->id(),
            'away_team_id' => $awayTeam->id(),
        ];
    }
}
