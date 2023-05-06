@extends('layouts.app')
@section('title', 'Tabella')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>Tabella</h1>
            </div>
        </div>

        {{-- TODO: Session flashes --}}
        <div class="row mt-3">
            <div class="col-12 col-lg-9">

            </div>
        </div>

        {{--
            Egy csapat pontszámát a befejezett mérkőzései alapján kell számítani a következő módon:
                nyert mérkőzés: +3 pont
                döntetlen: +1 pont
                vesztes mérkőzés: +0 pont
        --}}

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
                                                    <h5 class="card-title">Csapat neve</h5>
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
                                                    <h5>Gólkülönbség</h5>
                                                </div>
                                                <div class="col text-center">
                                                    <h5>Elért pontszám</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php
                            $logo = $team->image ?? asset('images/default_game_cover.jpg');
                            $wins = $team->num_of_won_games();
                            $draws = $team->num_of_draw_games();
                            $loses = $team->num_of_lost_games();
                            $goal_difference = $team->goal_difference();
                            $points = $team->num_of_points();
                        @endphp

                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-center">
                                                <img src="{{ $logo }}" alt="Logo" class="img-fluid" style="max-height: 60px;">
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
                                                <h5>{{ $goal_difference }}</h5>
                                            </div>
                                            <div class="col text-center">
                                                <h5>{{ $points }}</h5>
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
