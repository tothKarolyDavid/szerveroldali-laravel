<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Kérlek jelentkezz be, hogy kedvenceket tudj hozzáadni!');
        }

        $favorite_team_ids = auth()->user()->teams()->pluck('team_id');
        $games = Game::whereIn('home_team_id', $favorite_team_ids)
            ->orWhereIn('away_team_id', $favorite_team_ids)
            ->orderBy('start', 'asc')
            ->get();

        $games_in_progress = $games->where('finished', false)->where('start', '<', now()->addDays(1));
        $games_in_the_future = $games->where('finished', false)->where('start', '>', now());
        $games_finished = $games->where('finished', true);

        return view('favorites', [
            'games_in_progress' => $games_in_progress,
            'games_in_future' =>  $games_in_the_future,
            'games_finished' => $games_finished,
            'favorite_teams' => auth()->user()->teams,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('favorites');
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
