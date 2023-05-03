<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function id() {
        return $this->id;
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'game_id');
    }

    public function homeTeamScore()
    {
        $score = 0;
        $events = $this->events;
        $home_team_id = $this->home_team_id;
        $away_team_id = $this->away_team_id;

        foreach ($events as $event) {
            if ($event->player->team->id == $home_team_id && $event->type == 'goal') {
                $score++;
            } elseif ($event->player->team->id == $away_team_id && $event->type == 'own_goal') {
                $score++;
            }
        }

        return $score;
    }

    public function awayTeamScore()
    {
        $score = 0;
        $events = $this->events;
        $home_team_id = $this->home_team_id;
        $away_team_id = $this->away_team_id;

        foreach ($events as $event) {
            if ($event->player->team->id == $away_team_id && $event->type == 'goal') {
                $score++;
            } elseif ($event->player->team->id == $home_team_id && $event->type == 'own_goal') {
                $score++;
            }
        }

        return $score;
    }
}
