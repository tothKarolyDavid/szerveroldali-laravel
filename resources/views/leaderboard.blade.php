@extends('layouts.app')
@section('title', 'Tabella')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>Tabella</h1>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="row g-0">
                    @foreach ($teams as $team)
                        @if ($loop->first)
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col text-center">
                                                    <h5 class="card-title">Logó</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5 class="card-title">Csapatnév</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Győzelmek</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Döntetlenek</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Vereségek</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Gólok</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Kapott gólok</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Gólkülönbség</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Elért pontszám</h5>
                                                </div>
                                                <div class="col text-center">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php
                            $logo = $team->image ?? asset('images/default_game_cover.jpg');
                            $stats = $team->statistics();
                            $wins = $stats['won'];
                            $draws = $stats['drawn'];
                            $loses = $stats['lost'];
                            $scored_goals = $stats['goals_scored'];
                            $received_goals = $stats['goals_conceded'];
                            $goal_difference = $stats['goal_difference'];
                            $points = $stats['points'];
                        @endphp

                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-center">
                                                <img src="{{ $logo }}" alt="Logo" class="img-fluid rounded"
                                                    style="max-height: 60px;">
                                            </div>
                                            <div class="col text-center">
                                                <h5 class="card-title">{{ $team->name }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $wins }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $draws }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $loses }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $scored_goals }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $received_goals }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $goal_difference }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $points }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                @auth
                                                    @if (Auth::user()->is_favorite_team($team->id))
                                                        <form action="{{ route('teams.unfavorite', $team->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-heart"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('teams.favorite', $team->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="far fa-heart"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
