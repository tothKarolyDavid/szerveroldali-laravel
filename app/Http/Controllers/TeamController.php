<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all()->sortBy('name');

        return view('teams.index', [
            'teams' => $teams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:teams'],
            'short_name' => ['required', 'string', 'max:4', 'unique:teams'],
        ]);

        if ($request->cover_image) {
            $path = $request->file('cover_image')->store('public/teams');
            $team = Team::create([
                'name' => $request->name,
                'shortname' => $request->short_name,
                'image' => Storage::url($path),
            ]);
        } else {
            $team = Team::create([
                'name' => $request->name,
                'shortname' => $request->short_name,
            ]);
        }

        return redirect()->route('teams.show', $team->id)->with('success', 'Új csapat hozzáadva: ' . $team->name . '!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = Team::findOrFail($id);
        $games = $team->homeGames->merge($team->awayGames)->sortBy('date', SORT_REGULAR, true);
        $players = $team->players->sortBy('name');

        $games_in_progress = $games->where('finished', false)->where('start', '<', now()->addDays(1));
        $games_in_the_future = $games->where('finished', false)->where('start', '>', now());
        $games_finished =  $games->where('finished', true)->sortBy('start', SORT_REGULAR, true);


        return view('teams.show', [
            'team' => $team,
            'games' => $games,
            'players' => $players,
            'games_in_progress' => $games_in_progress,
            'games_in_future' =>  $games_in_the_future,
            'games_finished' => $games_finished,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = Team::findOrFail($id);

        return view('teams.edit', [
            'team' => $team,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:teams,name,' . $team->id],
            'short_name' => ['required', 'string', 'max:4', 'unique:teams,shortname,' . $team->id],
        ]);

        if ($request->cover_image) {
            $path = $request->file('cover_image')->store('public/teams');
            $team->update([
                'name' => $request->name,
                'shortname' => $request->short_name,
                'image' => Storage::url($path),
            ]);
        } else {
            $team->update([
                'name' => $request->name,
                'shortname' => $request->short_name,
            ]);
        }

        return redirect()->route('teams.show', $team->id)->with('success', 'Csapat frissítve: ' . $team->name . '!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function unfavorite(string $id)
    {
        $team = Team::findOrFail($id);
        $user = auth()->user();

        $user->teams()->detach($team->id);

        return redirect()->back();
    }

    public function favorite(string $id)
    {
        $team = Team::findOrFail($id);
        $user = auth()->user();

        $user->teams()->attach($team->id);

        return redirect()->back();
    }
}
