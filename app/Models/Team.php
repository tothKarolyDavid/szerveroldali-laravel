<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'shortname', 'image'];

    public function id() {
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

    public function num_of_won_games()
    {
        return $this->homeGames()->where('home_team_score', '>', 'away_team_score')->count() + $this->awayGames()->where('away_team_score', '>', 'home_team_score')->count();
    }

    public function num_of_lost_games()
    {
        return $this->homeGames()->where('home_team_score', '<', 'away_team_score')->count() + $this->awayGames()->where('away_team_score', '<', 'home_team_score')->count();
    }

    public function num_of_draw_games()
    {
        return $this->homeGames()->where('home_team_score', '=', 'away_team_score')->count() + $this->awayGames()->where('away_team_score', '=', 'home_team_score')->count();
    }

    public function num_of_scored_goals()
    {
        return $this->homeGames()->sum('home_team_score') + $this->awayGames()->sum('away_team_score');
    }

    public function num_of_conceded_goals()
    {
        return $this->homeGames()->sum('away_team_score') + $this->awayGames()->sum('home_team_score');
    }

    public function goal_difference()
    {
        return $this->num_of_scored_goals() - $this->num_of_conceded_goals();
    }

    public function num_of_points()
    {
        return $this->num_of_won_games() * 3 + $this->num_of_draw_games();
    }
}
