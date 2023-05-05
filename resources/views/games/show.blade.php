@extends('layouts.app')
{{-- TODO: Post title --}}
@section('title', 'View post: ')

@section('content')

    @php

    @endphp

    <div class="container">

        {{-- TODO: Session flashes --}}

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">

                {{-- TODO: Link --}}
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

            <h3>Események</h3>

            @forelse($events as $event)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
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
                        </div>
                    </div>
                </div>
            @empty
                Nincsen megjeleítendő esemény
            @endforelse
        </div>

        {{--
            Admin from Új esemény létrehozásához

            Ehhez meg kell adnia a következőket: hányadik játékpercben (1 és 90 közötti egész), milyen típusú esemény (gól, öngól, sárga lap, piros lap) történt és ki az érintett játékos.
            Alapvetően nem szükséges külön kiválasztani (vagy tárolni) a csapatot, hiszen azt a játékos személye egyértelműen meghatározza.
            Az érintett játékost egy listából (pl. legördülő menü vagy rádiógombok) lehet kiválasztani, amely csapat és mezszám szerint rendezett.

        --}}

        @auth
            @if (Auth::user()->is_admin && $game->finished == false && $game->start < now())
                <div class="mt-3">
                    <h3>Új esemény létrehozása</h3>
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="minute" class="form-label">Hányadik játékpercben történt az esemény?</label>
                            <input type="number" class="form-control" id="minute" name="minute" min="1"
                                max="90" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Milyen típusú esemény történt?</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="goal">Gól</option>
                                <option value="own_goal">Öngól</option>
                                <option value="yellow_card">Sárga lap</option>
                                <option value="red_card">Piros lap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="player" class="form-label">Ki az érintett játékos?</label>
                            <select class="form-select" id="player" name="player" required>
                                @php
                                    $players = $game->homeTeam->players->merge($game->awayTeam->players);
                                    // csapat és mezszám szerint rendezés
                                    $players = $players->sortBy([
                                        ['team_id', 'asc'],
                                        ['number', 'asc'],
                                    ]);
                                @endphp

                                @foreach ($players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->team->name }}
                                        , {{ $player->number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="game" value="{{ $game->id }}">
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    </form>
                </div>
            @endif
        @endauth


    </div>
@endsection
