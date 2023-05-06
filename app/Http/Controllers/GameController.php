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
        //
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
