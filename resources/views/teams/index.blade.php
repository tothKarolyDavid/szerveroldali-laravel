@extends('layouts.app')
@section('title', 'Csapatok')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>Csapatok</h1>
            </div>
            <div class="col-12 col-md-4">
                <div class="float-lg-end">
                    {{-- TODO: Links, policy --}}

                    @auth
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('teams.create') }}" role="button" class="btn btn-sm btn-success mb-1">
                                <i class="fas fa-plus-circle"></i>
                                Új csapat
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        {{-- TODO: Session flashes --}}
        <div class="row mt-3">
            <div class="col-12 col-lg-9">

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="row g-0 d-flex justify-content-center">
                    @forelse ($teams as $team)
                        @php
                            $team_logo = $team->image != null ? url($team->image) : asset('images/default_game_cover.jpg');
                        @endphp

                        <div class="card mt-3 me-3" style="width: 18rem;">
                            <img src="{{ $team_logo }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title align-text-bottom">{{ $team->name }}</h5>
                                <p class="card-text align-text-bottom">{{ $team->shortname }}</p>
                                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary align-bottom-bottom">Részletek</a>
                                <div class="text-center float-end">
                                    @auth
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
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            Nincsenek csapatok.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endsection
