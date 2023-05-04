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
        $away_team_id = $this->away_team_id;
        $home_team_id = $this->home_team_id;
        $home_team_score = 0;
        $away_team_score = 0;

        $events = $this->events;

        foreach ($events as $event) {
            $event_type = $event->type;
            $team_id = $event->player->team->id;

            if ($event_type == 'goal' && $team_id == $home_team_id) {
                $home_team_score += 1;
            } elseif ($event_type == 'goal' && $team_id == $away_team_id) {
                $away_team_score += 1;
            } elseif ($event_type == 'owngoal' && $team_id == $home_team_id) {
                $away_team_score += 1;
            } elseif ($event_type == 'owngoal' && $team_id == $away_team_id) {
                $home_team_score += 1;
            }
        }

        return [
            'home_team_score' => $home_team_score,
            'away_team_score' => $away_team_score
        ];
    }
}
