<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Contracts\Pagination\Paginator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all()->sortBy('start', SORT_REGULAR, true);

        $games_in_progress = $games->where('finished', false)->where('start', '<', now()->addDays(1));
        $games_in_the_future = $games->where('finished', false)->where('start', '>', now());
        $games_finished =  Game::where('finished', true)->orderBy('start', 'desc')->paginate(10);

        return view('games.index', [
            'games_in_progress' => $games_in_progress,
            'games_in_future' =>  $games_in_the_future,
            'games_finished' => $games_finished,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid_team_ids = Game::all()->pluck('home_team_id')->merge(Game::all()->pluck('away_team_id'));

        $request->validate([
            'home_team_id' => ['required', 'integer', 'different:away_team_id', 'in:' . $valid_team_ids->implode(',')],
            'away_team_id' => ['required', 'integer', 'different:home_team_id', 'in:' . $valid_team_ids->implode(',')],
            'start' => ['required', 'date', 'after:now'],
        ]);

        $request->merge([
            'start' => date('Y-m-d H:i:s', strtotime($request->start)),
        ]);

        $game = Game::create([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'start' => $request->start,
        ]);

        return redirect()->route('games.show', ['game' => $game->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.show', [
            'game' => $game,
            'title' => $game->homeTeam->name . ' vs ' . $game->awayTeam->name,
            'events' => $game->events->sortBy('minute', SORT_REGULAR, false),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.edit', [
            'game' => $game,
            'home_team_id' => $game->home_team_id,
            'away_team_id' => $game->away_team_id,
            'start' => $game->start,
            'finished' => $game->finished,
            'id' => $game->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $game = Game::findOrFail($id);
        $valid_team_ids = Game::all()->pluck('home_team_id')->merge(Game::all()->pluck('away_team_id'));

        $request->validate([
            'home_team_id' => ['required', 'integer', 'different:away_team_id', 'in:' . $valid_team_ids->implode(',')],
            'away_team_id' => ['required', 'integer', 'different:home_team_id', 'in:' . $valid_team_ids->implode(',')],
            'finished' => ['required', 'boolean'],
            'start' => ['required', 'date'],
        ]);

        $request->merge([
            'start' => date('Y-m-d H:i:s', strtotime($request->start)),
        ]);

        // ha megvaltozott egyik csapat, akkor a hozza tartozo esemenyeket toroljuk
        if ($game->home_team_id != $request->home_team_id) {
            $game->events()->where('team_id', $game->home_team_id)->delete();
        }
        if ($game->away_team_id != $request->away_team_id) {
            $game->events()->where('team_id', $game->away_team_id)->delete();
        }


        $game->update([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'finished' => $request->finished,
            'start' => $request->start,
        ]);

        return redirect()->route('games.show', ['game' => $game->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
