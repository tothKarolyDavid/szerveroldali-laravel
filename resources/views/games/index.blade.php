@extends('layouts.app')
@section('title', 'Mérkőzések')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>Mérkőzések</h1>
            </div>
            <div class="col-12 col-md-4">
                <div class="float-lg-end">
                    {{-- TODO: Links, policy --}}

                    <a href="#" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i>
                        Create post</a>

                    <a href="#" role="button" class="btn btn-sm btn-success mb-1"><i class="fas fa-plus-circle"></i>
                        Create category</a>

                </div>
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



                <div class="d-flex justify-content-center">
                    {{-- TODO: Pagination Bootsrap 5 --}}
                    {!! $games_finished->links() !!}
                </div>

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
                                @foreach ($games_in_future as $game)
                                    <a href="{{ route('games.show', $game->id) }}" class="text-decoration-none">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $game->homeTeam->shortname }} - {{ $game->awayTeam->shortname }}</span>
                                            <p class="card-text float-end"><small class="text-muted"><i
                                                        class="far fa-calendar-alt"></i>
                                                    {{ $game->start }}</small></p>
                                        </div>
                                    </a>
                                @endforeach
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
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
