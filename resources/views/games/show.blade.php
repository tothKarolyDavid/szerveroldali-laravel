@extends('layouts.app')
@section('title', 'Mérkőzés részletei')

@section('content')

    @php

    @endphp

    <div class="container">

        {{-- TODO: Session flashes --}}

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>

                <h1>{{ $title }}</h1>
            </div>

            <div class="col-12 col-md-4">
                <div class="float-lg-end">

                    {{-- TODO: Links, policy --}}
                    <a role="button" class="btn btn-sm btn-primary" href="#"><i class="far fa-edit"></i> Edit post</a>

                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal"><i
                            class="far fa-trash-alt">
                            <span></i> Delete post</span>
                    </button>

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- TODO: Title --}}
                        Are you sure you want to delete post <strong>N/A</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete-post-form').submit();">
                            Yes, delete this post
                        </button>

                        {{-- TODO: Route, directives --}}
                        <form id="delete-post-form" action="#" method="POST" class="d-none">

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <x-game-card :games="$game" type="show_one" />

            {{--
                Az admin felhasználó számára a mérkőzésrészletező oldalról lehetőség van a meccs lezárására, tehát befejezetté nyilvánítására.
                A lezárt meccshez további esemény nem rögzíthető, illetve a meccs ezután nem jelenik meg a folyamatban lévő mérkőzések szekciójában.
            --}}

            @auth
                @if (Auth::user()->is_admin && $game->finished == false && $game->start < now())
                    <div class="mt-3 mb-3">
                        <form action="{{ route('games.update', $game->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="finished" value="1">
                            <button type="submit" class="btn btn-sm btn-success"><h5>Mérkőzés lezárása</h5></button>
                        </form>
                    </div>
                @endif
            @endauth

            <h3>Események</h3>
            @forelse($events as $event)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex">
                                <p class="text-center">{{ $event->minute }}. perc</p>
                            </div>
                            <div class="col">
                                <p class="text-center">{{ $event->player->team->name }}</p>
                            </div>
                            <div class="col">
                                <p class="text-center">
                                    @php

                                        switch ($event->type) {
                                            case 'goal':
                                                $event_type = 'Gól';
                                                break;
                                            case 'own_goal':
                                                $event_type = 'Öngól';
                                                break;
                                            case 'yellow_card':
                                                $event_type = 'Sárga lap';
                                                break;
                                            case 'red_card':
                                                $event_type = 'Piros lap';
                                                break;
                                        }
                                    @endphp
                                    {{ $event_type }}
                                </p>
                            </div>
                            <div class="col">
                                <p class="text-center">{{ $event->player->name }}</p>
                            </div>
                            @auth
                                @if (Auth::user()->is_admin && $game->finished == false && $game->start < now())
                                    <div class="col">
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                            class="float-end">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                Nincsen megjeleítendő esemény
            @endforelse
        </div>


        {{-- Új esemény hozzáadása --}}

        @auth
            @if (Auth::user()->is_admin && $game->finished == false && $game->start < now())
                <div class="mt-3">
                    <h3>Új esemény létrehozása</h3>
                    <form action="{{ route('events.store') }}" method="POST">
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
                                    $players = $game->homeTeam->players->merge($game->awayTeam->players);
                                    $players = $players->sortBy([['team_id', 'asc'], ['number', 'asc']]);
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
                        <input type="hidden" name="game" value="{{ $game->id }}">
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    </form>
                </div>
            @endif
        @endauth


    </div>
@endsection
