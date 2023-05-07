<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Game;
use App\Models\Event;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'shortname', 'image'];

    public function id()
    {
        return $this->id;
    }

    public function players()
    {
        return $this->hasMany(Player::class, 'team_id');
    }

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }

    public function statistics()
    {
        $won_count = 0;
        $lost_count = 0;
        $drawn_count = 0;
        $scored_goals = 0;
        $conceded_goals = 0;

        $homeGames = $this->homeGames->where('finished', '=', true);
        $awayGames = $this->awayGames->where('finished', '=', true);

        foreach ($homeGames as $game) {
            $scores = $game->getTeamScores();

            $scored_goals += $scores['home_team_score'];
            $conceded_goals += $scores['away_team_score'];

            if ($scores['home_team_score'] > $scores['away_team_score']) {
                $won_count += 1;
            } elseif ($scores['home_team_score'] < $scores['away_team_score']) {
                $lost_count += 1;
            } else {
                $drawn_count += 1;
            }
        }

        foreach ($awayGames as $game) {
            $scores = $game->getTeamScores();

            $scored_goals += $scores['away_team_score'];
            $conceded_goals += $scores['home_team_score'];

            if ($scores['home_team_score'] < $scores['away_team_score']) {
                $won_count += 1;
            } elseif ($scores['home_team_score'] > $scores['away_team_score']) {
                $lost_count += 1;
            } else {
                $drawn_count += 1;
            }
        }

        return [
            'won' => $won_count,
            'lost' => $lost_count,
            'drawn' => $drawn_count,
            'goals_scored' => $scored_goals,
            'goals_conceded' => $conceded_goals,
            'goal_difference' => $scored_goals - $conceded_goals,
            'points' => $won_count * 3 + $drawn_count
        ];
    }
}
