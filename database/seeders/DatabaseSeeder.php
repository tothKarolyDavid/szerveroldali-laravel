<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\Game;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $num_of_users = 10;
        $num_of_teams = 10;
        $num_of_players = 11 * $num_of_teams;
        $num_of_games = 2 * $num_of_teams;
        $num_of_events = $num_of_games * 5;

        // Felhasználók létrehozása
        for ($i = 1; $i <= $num_of_users; $i++) {
            User::factory()->create([
                'email' => 'user' . $i . '@szerveroldali.hu',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        }

        // Admin létrehozása
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@szerveroldali.hu',
            'password' => '$2y$10$egzsTuQ/eYDOEqFCMCOhBepkCzCLuT/686NlSt2Syop.OAmhMB172', // adminpwd
            'is_admin' => true,
        ]);

        Team::factory($num_of_teams)->create();
        Player::factory($num_of_players)->create();
        Game::factory($num_of_games)->create();
        Event::factory($num_of_events)->create();

        // Kedvenc csapatok hozzárendelése a felhasználókhoz
        $users = User::all();
        $teams = Team::all();
        foreach ($users as $user) {
            $user->teams()->attach($teams->random(rand(1, 3))->pluck('id')->toArray());
        }



    }
}
