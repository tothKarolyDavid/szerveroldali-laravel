@extends('layouts.app')
@section('title', 'Mérkőzés szerkesztése')

@php
    $teams = App\Models\Team::all()->sortBy('name');
@endphp

@section('content')
    <div class="container">
        <h1>Mérkőzés szerkesztése</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>
        </div>

        <form action="{{ route('games.update', ['game' => $game->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')

            @csrf

            <div class="form-group row mb-3">
                <label for="home_team_id" class="col-sm-2 col-form-label">Hazai csapat*</label>
                <div class="col-sm-10">
                    <select class="form-control @error('home_team_id') is-invalid @enderror" id="home_team_id"
                        name="home_team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @if (old('home_team_id', $game->home_team_id) == $team->id) selected @endif>
                                {{ $team->name }}</option>
                        @endforeach
                    </select>

                    @error('home_team_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="away_team_id" class="col-sm-2 col-form-label">Vendég csapat*</label>
                <div class="col-sm-10">
                    <select class="form-control
                @error('away_team_id') is-invalid @enderror"
                        id="away_team_id" name="away_team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @if (old('away_team_id', $game->away_team_id) == $team->id) selected @endif>
                                {{ $team->name }}</option>
                        @endforeach
                    </select>

                    @error('away_team_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="start" class="col-sm-2 col-form-label">Kezdés időpontja*</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control @error('start') is-invalid @enderror" id="start"
                        name="start" value="{{ old('start', $game->start) }}">
                    @error('start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- finished mezo bekerese --}}
            <div class="form-group row mb-3">
                <label for="finished" class="col-sm-2 col-form-label">Befejezett*</label>
                <div class="col-sm-10">
                    <select class="form-control @error('finished') is-invalid @enderror" id="finished" name="finished">
                        <option value="0" @if (old('finished', $game->finished) == 0) selected @endif>Nem</option>
                        <option value="1" @if (old('finished', $game->finished) == 1) selected @endif>Igen</option>
                    </select>
                    @error('finished')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Mentés</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const removeCoverInput = document.querySelector('input#remove_cover_image');
        const coverImageSection = document.querySelector('#cover_image_section');
        const coverImageInput = document.querySelector('input#cover_image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');
        // Render Blade to JS code:
        // TODO: Use attached image
        const defaultCover = `{{ asset('images/default_game_cover.jpg') }}`;

        removeCoverInput.onchange = event => {
            if (removeCoverInput.checked) {
                coverImageSection.classList.add('d-none');
            } else {
                coverImageSection.classList.remove('d-none');
            }
        }

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewImage.src = defaultCover;
            }
        }
    </script>
@endsection
