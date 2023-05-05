<div class="row g-0">
    @if ($type == 'in_progress')
        <h2>Folyamatban lévő mérkőzések</h2>
    @elseif ($type == 'in_future')
        <h2>Jövőbeli mérkőzések</h2>
    @elseif ($type == 'in_past')
        <h2>Lejátszott mérkőzések</h2>
    @endif

    @if ($type == 'show_one')
        @php
            $game = $games;
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

                        @if ($type != 'in_future')
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
                        @endif
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
                        <a href="{{ route('games.show', $game->id) }}" class="btn btn-primary">
                            <span>Részletek</span> <i class="fas fa-angle-right"></i>
                        </a>
                        <p class="card-text float-end"><small class="text-muted"><i class="far fa-calendar-alt"></i>
                                Meccs időpontja: {{ $game->start }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    @else
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

                            @if ($type != 'in_future')
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
                            @endif
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
                            <a href="{{ route('games.show', $game->id) }}" class="btn btn-primary">
                                <span>Részletek</span> <i class="fas fa-angle-right"></i>
                            </a>
                            <p class="card-text float-end"><small class="text-muted"><i class="far fa-calendar-alt"></i>
                                    Meccs időpontja: {{ $game->start }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div>
                <h3>Nincsen megjeleníthető mérkőzés</h3>
            </div>
        @endforelse
    @endif

</div>
