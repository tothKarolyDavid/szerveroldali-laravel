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

        // Csapatok létrehozása
        $teams = Team::factory($num_of_teams)->create();

        // Játékosok létrehozása
        foreach ($teams as $team) {
            Player::factory(11)->create([
                'team_id' => $team->id(),
            ]);
        }

        // Mérkőzések létrehozása
        foreach ($teams as $home_team) {
            foreach ($teams as $away_team) {
                if ($home_team->id() != $away_team->id()) {
                    Game::factory()->create([
                        'home_team_id' => $home_team->id(),
                        'away_team_id' => $away_team->id(),
                    ]);
                }
            }
        }

        // Események létrehozása
        $games = Game::all();
        $players = Player::all();
        foreach ($games as $game) {
            $num_of_events = rand(5, 10);
            for ($i = 0; $i < $num_of_events; $i++) {
                $team = rand(true, false) ? $game->homeTeam : $game->awayTeam;
                $player = $players->where('team_id', $team->id())->random();
                Event::factory()->create([
                    'game_id' => $game->id(),
                    'player_id' => $player->id(),
                ]);
            }
        }

        // Kedvenc csapatok hozzárendelése a felhasználókhoz
        $users = User::all();
        $teams = Team::all();
        foreach ($users as $user) {
            $user->teams()->attach($teams->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
