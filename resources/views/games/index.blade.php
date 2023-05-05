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
                <x-game-card :games="$games_in_future" type="in_future" />
                <x-game-card :games="$games_finished" type="in_past" />



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
