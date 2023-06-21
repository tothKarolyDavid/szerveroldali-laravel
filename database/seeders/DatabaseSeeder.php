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

    function create_uses($num_of_users)
    {
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
    }

    function create_games()
    {
        $num_of_future_games = rand(1, 4);
        $num_of_games_in_progress = rand(3, 5);

        $teams = Team::all();
        $future_games_generated = 0;
        $games_in_progress_generated = 0;

        foreach ($teams as $home_team) {
            foreach ($teams as $away_team) {
                if ($home_team->id() != $away_team->id()) {
                    if ($future_games_generated < $num_of_future_games) {
                        // Jövőbeli mérkőzések
                        Game::factory()->create([
                            'home_team_id' => $home_team->id(),
                            'away_team_id' => $away_team->id(),
                            'start' => now()->addDays(rand(3, 30)),
                            'finished' => false,
                        ]);
                        $future_games_generated++;
                    } elseif ($games_in_progress_generated < $num_of_games_in_progress) {
                        // Folyamatban lévő mérkőzések
                        Game::factory()->create([
                            'home_team_id' => $home_team->id(),
                            'away_team_id' => $away_team->id(),
                            'start' => now()->subMinutes(rand(1, 90)),
                            'finished' => false,
                        ]);
                        $games_in_progress_generated++;
                    } else {
                        // Lejátszott mérkőzések
                        Game::factory()->create([
                            'home_team_id' => $home_team->id(),
                            'away_team_id' => $away_team->id(),
                            'start' => now()->subDays(rand(1, 30)),
                            'finished' => true,
                        ]);
                    }
                }
            }
        }
    }

    function create_events()
    {
        $num_of_goals = rand(1, 5);
        $num_of_own_goals = rand(0, 2);
        $num_of_yellow_cards = rand(1, 5);
        $num_of_red_cards = rand(0, 2);

        $games = Game::all()->where('finished', true)->union(Game::all()->where('finished', false)->where('start', '<', now()));

        $players = Player::all();
        foreach ($games as $game) {
            // Gólok
            for ($i = 0; $i < $num_of_goals; $i++) {
                $team = rand(true, false) ? $game->homeTeam : $game->awayTeam;
                $player = $players->where('team_id', $team->id())->random();
                Event::factory()->create([
                    'game_id' => $game->id(),
                    'player_id' => $player->id(),
                    'type' => 'goal',
                ]);
            }

            // Öngólok
            for ($i = 0; $i < $num_of_own_goals; $i++) {
                $team = rand(true, false) ? $game->homeTeam : $game->awayTeam;
                $player = $players->where('team_id', $team->id())->random();
                Event::factory()->create([
                    'game_id' => $game->id(),
                    'player_id' => $player->id(),
                    'type' => 'own_goal',
                ]);
            }

            // Sárga lapok
            for ($i = 0; $i < $num_of_yellow_cards; $i++) {
                $team = rand(true, false) ? $game->homeTeam : $game->awayTeam;
                $player = $players->where('team_id', $team->id())->random();
                Event::factory()->create([
                    'game_id' => $game->id(),
                    'player_id' => $player->id(),
                    'type' => 'yellow_card',
                ]);
            }

            // Piros lapok
            for ($i = 0; $i < $num_of_red_cards; $i++) {
                $team = rand(true, false) ? $game->homeTeam : $game->awayTeam;
                $player = $players->where('team_id', $team->id())->random();
                Event::factory()->create([
                    'game_id' => $game->id(),
                    'player_id' => $player->id(),
                    'type' => 'red_card',
                ]);
            }
        }
    }


    public function run(): void
    {
        $num_of_users = 10;
        $num_of_teams = 10;

        // Felhasználók létrehozása
        $this->create_uses($num_of_users);

        // Csapatok létrehozása
        $teams = Team::factory($num_of_teams)->create();

        // Játékosok létrehozása
        foreach ($teams as $team) {
            $playerNumbers = [];

            for ($i = 0; $i < rand(11, 15); $i++) {
                do {
                    $playerNumber = rand(1, 99);
                } while (in_array($playerNumber, $playerNumbers));

                Player::factory()->create([
                    'team_id' => $team->id(),
                    'number' => $playerNumber,
                ]);
            }
        }

        // Mérkőzések létrehozása
        $this->create_games();

        // Események létrehozása
        $this->create_events();

        // Kedvenc csapatok hozzárendelése a felhasználókhoz
        $users = User::all();
        $teams = Team::all();
        foreach ($users as $user) {
            $user->teams()->attach($teams->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
