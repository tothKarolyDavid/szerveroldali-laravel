<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use App\Models\Event;


class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'birthdate', 'team_id'];

    public function id() {
        return $this->id;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'player_id');
    }

    public function statistics()
    {
        $events = Event::where('player_id', $this->id)->get();
        $statistics = [
            'goals' => $events->where('type', 'goal')->count(),
            'own_goals' => $events->where('type', 'own_goal')->count(),
            'yellow_cards' => $events->where('type', 'yellow_card')->count(),
            'red_cards' =>  $events->where('type', 'red_card')->count(),
        ];

        return $statistics;
    }
}
