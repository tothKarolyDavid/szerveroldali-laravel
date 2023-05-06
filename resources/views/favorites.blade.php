{{--
    Ez az oldal csak bejelentkezett felhasználók számára elérhető.
    A nem bejelentkezett felhasználóknak ajánljuk fel a bejelentkezés vagy regisztráció lehetőségét, amely természetesen működjön is megfelelően!
    A bejelentkezett felhasználók minden olyan helyen, ahol csapatnév vagy rövidítés szerepel (pl. meccsek, csapatok, tabella) kedvencnek tudják jelölni a csapatukat egy gombra vagy ikonra kattintva.
    A már kedvencnek jelölt csapat ugyanígy el is távolítható a kedvencek közül.
    A kedvenceim oldalon a bejelentkezett felhasználók csak azokat a mérkőzéseket látják, amelyben valamelyik kedvencnek jelölt csapatuk részt vesz.
--}}

@extends('layouts.app')
@section('title', 'Kedvencek')
@section('content')

    @php
        use Illuminate\Support\Facades\Auth;
    @endphp

    @if (Auth::check())


        <div class="container">
            <div class="row justify-content-between">
                <div class="col-12 col-md-8">
                    <h1>Kedvencek</h1>
                </div>
                <div class="col-12 col-md-4">

                </div>
            </div>

            {{-- TODO: Session flashes --}}
            <div class="row mt-3">
                <div class="col-12 col-lg-9">

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-lg-9">
                    <x-game-card :games="$games_in_progress" type="in_progress" />
                    <x-game-card :games="$games_finished" type="in_past" />
                </div>


                {{-- Oldalsav --}}
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card bg-light">
                                <div class="card-header">
                                    Jővőbeli mérkőzések
                                </div>
                                <div class="card-body">
                                    {{-- TODO: Read categories from DB --}}
                                    @forelse ($games_in_future as $game)
                                        <a href="{{ route('games.show', $game->id) }}" class="text-decoration-none">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $game->homeTeam->shortname }} -
                                                    {{ $game->awayTeam->shortname }}</span>
                                                <p class="card-text float-end"><small class="text-muted"><i
                                                            class="far fa-calendar-alt"></i>
                                                        {{ $game->start }}</small></p>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="card-text">Nincs jövőbeli mérkőzés a kedvelt csapatok közül.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="card bg-light">
                                <div class="card-header">
                                    Kedvenc csapatok
                                </div>
                                <div class="card-body">
                                    <div class="small">
                                        <ul class="fa-ul">
                                            @forelse ($favorite_teams as $team)
                                                <li><span class="fa-li"><i class="fas fa-star"></i></span>
                                                    <a href="{{ route('teams.show', $team->id) }}"
                                                        class="text-decoration-none">{{ $team->name }} ({{ $team->shortname }})</a>
                                                </li>
                                            @empty
                                                <p class="card-text">Nincs kedvelt csapat.</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        {{-- A nem bejelentkezett felhasználóknak ajánljuk fel a bejelentkezés vagy regisztráció lehetőségét, amely természetesen működjön is megfelelően! --}}
        <h2>Kérlek jelentkezz be vagy regisztrálj!</h2>

    @endif
@endsection
