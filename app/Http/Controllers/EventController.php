<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Event;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid_player_ids = Game::findOrFail($request->game)->homeTeam->players->pluck('id')->merge(Game::findOrFail($request->game)->awayTeam->players->pluck('id'));

        $request->validate([
            'minute' => ['required', 'integer', 'min:1', 'max:90'],
            'type' => ['required', 'in:goal,own_goal,red_card,yellow_card'],
            'player' => ['required', 'exists:players,id', Rule::in($valid_player_ids)],
        ]);

        // create the event
        Event::create([
            'game_id' => $request->game,
            'minute' => $request->minute,
            'type' => $request->type,
            'player_id' => $request->player,
        ]);

        // redirect to the game page
        return redirect()->route('games.show', ['game' => $request->game]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
