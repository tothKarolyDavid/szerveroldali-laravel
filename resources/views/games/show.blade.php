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
                <a href="{{ route('games.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>

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
    </div>
@endsection
