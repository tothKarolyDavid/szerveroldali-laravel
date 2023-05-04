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
                <div class="row g-0">
                    @forelse ($games as $game)
                    @php
                        $scores = $game->getTeamScores();
                    @endphp
                    <div class="card mb-3" style="">
                        <div class="row g-0">
                            <div class="col">
                                <img src="{{ asset('images/default_post_cover.jpg') }}" class="img-fluid rounded-start h-100"
                                    alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col text-center">
                                            <h5 class="card-title">{{ $game->homeTeam->shortname }}</h5>
                                        </div>
                                        <div class="col text-center">

                                        </div>
                                        <div class="col text-center">
                                            <h5 class="card-title">{{ $game->awayTeam->shortname }}</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <h5 class="card-title">{{ $scores['home_team_score'] }}</h5>
                                        </div>
                                        <div class="col text-center">
                                            -
                                        </div>
                                        <div class="col text-center">
                                            <h5 class="card-title">{{ $scores['away_team_score'] }}</h5>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="col">
                                <img src="{{ asset('images/default_post_cover.jpg') }}" class="img-fluid rounded-end h-100"
                                    alt="">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div>
                                    <a href="#" class="btn btn-primary">
                                        <span>View post</span> <i class="fas fa-angle-right"></i>
                                    </a>
                                    <p class="card-text float-end"><small class="text-muted"><i class="far fa-calendar-alt"></i> Meccs időpontja: {{ $game->start }}</small></p>
                                </div>
                            </div>
                            {{-- TODO: Link --}}

                        </div>
                    </div>
                    @empty
                    <div>
                        <p>Nincs megjeleníthető mérkőzés</p>
                    </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center">
                    {{-- TODO: Pagination Bootsrap 5 --}}

                </div>

            </div>


            {{-- Oldalsav --}}
            <div class="col-12 col-lg-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Categories
                            </div>
                            <div class="card-body">
                                {{-- TODO: Read categories from DB --}}
                                @foreach (['primary', 'secondary', 'danger', 'warning', 'info', 'dark'] as $category)
                                    <a href="#" class="text-decoration-none">
                                        <span class="badge bg-{{ $category }}">{{ $category }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Statistics
                            </div>
                            <div class="card-body">
                                <div class="small">
                                    <ul class="fa-ul">
                                        {{-- TODO: Read stats from DB --}}
                                        <li><span class="fa-li"><i class="fas fa-user"></i></span>Users: N/A</li>
                                        <li><span class="fa-li"><i class="fas fa-layer-group"></i></span>Categories: N/A
                                        </li>
                                        <li><span class="fa-li"><i class="fas fa-file-alt"></i></span>Posts: N/A</li>
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
