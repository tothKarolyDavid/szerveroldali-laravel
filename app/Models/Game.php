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
        return $this->belongsTo(Team::class, 'home_team_id')->withTimestamps();
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id')->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'game_id')->withTimestamps();
    }
}
