<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function id()
    {
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

    public function getTeamScores()
    {
        $home_team_score = 0;
        $away_team_score = 0;
        $events = $this->events;
        $home_team_id = $this->home_team_id;
        $away_team_id = $this->away_team_id;

        foreach ($events as $event) {
            $team_id = $event->player->team->id;
            $event_type = $event->type;

            if ($team_id == $home_team_id && $event_type == 'goal') {
                $home_team_score++;
            } elseif ($team_id == $away_team_id && $event_type == 'goal') {
                $away_team_score++;
            } elseif ($team_id == $home_team_id && $event_type == 'own_goal') {
                $away_team_score++;
            } elseif ($team_id == $away_team_id && $event_type == 'own_goal') {
                $home_team_score++;
            }
        }

        return [
            'home_team_score' => $home_team_score,
            'away_team_score' => $away_team_score,
        ];
    }
}
