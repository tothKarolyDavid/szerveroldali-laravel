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

        {{--
            Az oldalon megjelenik az összes csapat neve, rövidítése és logója (ha van feltöltve, különben placeholder kép).
            Az egyes csapatokra kattintva továbblépünk az adott csapat részletező oldalára.
        --}}

        <div class="row mt-3">
            <div class="col-12">
                <div class="row g-0">
                    @forelse ($teams as $team)
                        @php
                            $team_logo = $team->image != null ? url($team->image) : asset('images/default_game_cover.jpg');
                        @endphp

                        <div class="card mt-3 me-3" style="width: 18rem;">
                            <img src="{{ $team_logo }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $team->name }}</h5>
                                <p class="card-text">{{ $team->shortname }}</p>
                                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary">Részletek</a>
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
