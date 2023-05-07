@extends('layouts.app')
@section('title', 'Csapat részletei')

@section('content')

    @php
        $logo = $team->image ?? asset('images/default_game_cover.jpg');
    @endphp

    <div class="container">

        {{-- TODO: Session flashes --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>
                <h1>{{ $team->name }} ({{ $team->shortname }})</h1>
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

        <div class="row mt-3">
            <div class="col-12 col-lg-9">
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

            {{-- Oldalsav --}}
            <div class="col-12 col-lg-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Logó
                            </div>
                            <div class="card-body">
                                <img src="{{ $logo }}" class="img-fluid rounded-start" style="max-height: 200px;"
                                    alt="{{ $team->shortname . ' logo' }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Statisztikák
                            </div>
                            <div class="card-body">
                                <div class="small">
                                    <ul class="fa-ul">
                                        {{-- TODO: Read stats from DB --}}
                                        <li>
                                            <span class="fa-li"><i class=""></i></span>Folyamatban lévő mérkőzések:
                                            {{ $games_in_progress->count() }}
                                        </li>
                                        <li>
                                            <span class="fa-li"><i class="t"></i></span>Jövőbeli mérkőzések:
                                            {{ $games_in_future->count() }}
                                        </li>
                                        <li>
                                            <span class="fa-li"></i></span>Befejezett mérkőzések:
                                            {{ $games_finished->count() }}
                                        </li>
                                        <hr />
                                        <li>
                                            <span class="fa-li"><i class="fas fa-futbol"></i></span>Gólok:
                                            {{ $goals_scored }}
                                        </li>

                                        <li>
                                            <span class="fa-li"><i class="fas fa-futbol"></i></span>Kapott gólok:
                                            {{ $goals_conceded }}
                                        </li>
                                        {{-- nyert, vesztett, dontetlen --}}
                                        <li>
                                            <span class="fa-li"><i class="fas fa-trophy"></i></span>Nyert mérkőzések:
                                            {{ $won }}
                                        </li>
                                        <li>
                                            <span class="fa-li"><i class="fas fa-trophy"></i></span>Vesztett mérkőzések:
                                            {{ $lost }}
                                        </li>
                                        <li>
                                            <span class="fa-li"><i class="fas fa-trophy"></i></span>Döntetlen mérkőzések:
                                            {{ $drawn }}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                id="birthdate" name="birthdate" value="{{ old('birthdate') }}">

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
