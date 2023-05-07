<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\Player;
use App\Models\Game;
use App\Models\Team;

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
        return [
            'type' => $this->faker->randomElement(['goal', 'goal', 'goal', 'own_goal', 'yellow_card', 'red_card']),
            'minute' => $this->faker->numberBetween(1, 90),
        ];
    }
}
