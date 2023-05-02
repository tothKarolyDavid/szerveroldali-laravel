<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\Player;
use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /*
    Event - egy esemény egy mérkőzésen belül
        id
        type (enum - eseménytípusok: gól, öngól, sárga lap, piros lap)
        minute (integer, hanyadik percben történt az esemény)
        időbélyegek
    */
    public function definition(): array
    {
        $players = Player::all();
        $games = Game::all();

        $player = $players->random();
        $game = $games->random();

        return [
            'type' => $this->faker->randomElement(['goal', 'owngoal', 'yellowcard', 'redcard']),
            'minute' => $this->faker->numberBetween(1, 90),

            'player_id' => $player->id(),
            'game_id' => $game->id(),
        ];
    }
}
