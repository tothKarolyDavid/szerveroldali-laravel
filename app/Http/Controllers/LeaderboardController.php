<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all()->sortBy('name');
        $teams = $teams->sortByDesc(function ($team, $key) {
            $stats = $team->statistics();
            return $stats['points'] * 1000 + $stats['goal_difference'];
        });

        return view('leaderboard', [
            'teams' => $teams,
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
