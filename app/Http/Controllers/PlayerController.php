<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
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
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:players,name'],
            'number' => ['required', 'integer', 'min:1', 'max:99', 'unique:players,number'],
            'birthdate' => ['required', 'date', 'before:now'],
        ]);

        $request->merge([
            'birthdate' => date('Y-m-d', strtotime($request->birthdate)),
        ]);

        $player = Player::create([
            'name' => $request->name,
            'number' => $request->number,
            'birthdate' => $request->birthdate,
            'team_id' => $request->team,
        ]);

        return redirect()->route('teams.show', ['team' => $request->team])->with('success', 'Új játékos hozzáadva: ' . $player->name . '!');
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
        $player = Player::findOrFail($id);
        $team = $player->team_id;
        $player->delete();

        return redirect()->route('teams.show', ['team' => $team])->with('success', 'Játékos törölve: ' . $player->name . '!');
    }
}
