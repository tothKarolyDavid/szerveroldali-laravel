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
                                    @if (Auth::user()->is_admin)
                                        <div class="col">
                                            <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                                                class="float-end">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Új esemény hozzáadása --}}

        @auth
            @if (Auth::user()->is_admin)
                <div class="mt-3">
                    <h3>Új játékos hozzáadása</h3>
                    <form action="{{ route('players.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 form-group">
                            <label for="minute" class="form-label">Hányadik játékpercben történt az esemény?</label>
                            <input type="number" class="form-control @error('minute') is-invalid @enderror" id="minute"
                                name="minute" value="{{ old('minute') ? old('minute') : '' }}">
                            @error('minute')
                                <div class="invalid-feedback">
                                    Nem megfelelő játékperc!
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 form-group">
                            <label for="type" class="form-label">Milyen típusú esemény történt?</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="goal" @if (old('type') == 'goal') selected @endif>Gól</option>
                                <option value="own_goal" @if (old('type') == 'own_goal') selected @endif>Öngól</option>
                                <option value="yellow_card" @if (old('type') == 'yellow_card') selected @endif>Sárga lap</option>
                                <option value="red_card" @if (old('type') == 'red_card') selected @endif>Piros lap</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    Nem megfelelő esemény típus!
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group">
                            <label for="player" class="form-label">Ki az érintett játékos?</label>
                            <select class="form-select @error('player') is-invalid @enderror" id="player" name="player">
                                @php

                                @endphp
                                @endphp

                                @foreach ($players as $player)
                                    <option @if (old('player') == $player->id) selected @endif value="{{ $player->id }}">
                                        {{ $player->name }} ({{ $player->team->name }}
                                        , {{ $player->number }})</option>
                                @endforeach
                            </select>
                            @error('player')
                                <div class="invalid-feedback">
                                    Nem létező játékos!
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
