@extends('layouts.app')
@section('title', 'Csapat részletei')

@section('content')

    @php

    @endphp

    <div class="container">

        {{-- TODO: Session flashes --}}

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>

                <h1>{{ $team->name }}</h1>
                <div class="text-center float-end">

                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    {{-- TODO: Links, policy --}}
                    @auth
                        @if (Auth::user()->is_admin)
                            <a role="button" class="btn btn-sm btn-primary" href="{{ route('teams.edit', $team->id) }}"
                                role="button">
                                <i class="far fa-edit"></i>
                                Csapat szerkesztése
                            </a>
                        @endif

                        <div class="float-end ms-3">
                            @if (Auth::user()->is_favorite_team($team->id))
                                <form action="{{ route('teams.unfavorite', $team->id) }}" method="POST">
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
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="mt-3">
            <h2>Mérkőzések</h2>
            @if (count($games_in_progress) != 0)
                <x-game-card :games="$games_in_progress" type="in_progress" />
            @endif
            @if (count($games_in_future) != 0)
                <x-game-card :games="$games_in_future" type="in_future" />
            @endif
            @if (count($games_finished) != 0)
                <x-game-card :games="$games_finished" type="in_past" />
            @endif


            <h3>Játékosok</h3>
            @foreach ($players as $player)
                @php
                    $stats = $player->statistics();

                    $goals = $stats['goals'];
                    $own_goals = $stats['own_goals'];
                    $red_cards = $stats['red_cards'];
                    $yellow_cards = $stats['yellow_cards'];
                @endphp

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            @if ($loop->first)
                                <div class="col d-flex">
                                    <p class="text-center">Név</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Mezszám</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Születési dátum</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Gólok</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Öngólok</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Piros lapok</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">Sárga lapok</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">

                                    </p>
                                </div>
                            @else
                                <div class="col d-flex">
                                    <p class="text-center">{{ $player->name }}</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">{{ $player->number }}</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">{{ $player->birthdate }}</p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">
                                        {{ $goals }}
                                    </p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">
                                        {{ $own_goals }}
                                    </p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">
                                        {{ $red_cards }}
                                    </p>
                                </div>
                                <div class="col d-flex">
                                    <p class="text-center">
                                        {{ $yellow_cards }}
                                    </p>
                                </div>

                                @auth
                                    @if (Auth::user()->is_admin && $player->events->count() == 0)
                                        <div class="col">
                                            <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                                class="float-end">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col">
                                        </div>
                                    @endif
                                @endauth
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Új játékos hozzáadása --}}

        @auth
            @if (Auth::user()->is_admin)
                <div class="mt-3">
                    <h3>Új játékos hozzáadása</h3>
                    <form action="{{ route('players.store') }}" method="POST">
                        @csrf

                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Játékos neve*</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="number" class="form-label">Játékos mezszáma</label>
                            <input type="number" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" value="{{ old('number') }}">
                            @error('number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="bithdate" class="form-label">Játékos születési dátuma*</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate"
                                name="birthdate" value="{{ old('birthdate') }}">

                            @error('birthdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="team" value="{{ $team->id }}">
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    </form>
                </div>
            @endif
        @endauth


    </div>
@endsection
