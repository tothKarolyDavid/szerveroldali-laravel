<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /*
        Team - egy csapat
            id
            name (string, egyedi)
            shortname (string, egyedi, maximum 4 karakter)
            image (string, lehet null)
            időbélyegek
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name(),
            'shortname' => $this->faker->unique()->max(4),
        ];
    }
}
