@extends('layouts.app')
@section('title', 'Új mérkőzés')

@php
    $teams = App\Models\Team::all()->sortBy('name');
@endphp

@section('content')
    <div class="container">
        <h1>Új mérkőzés</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>
        </div>

        {{-- TODO: action, method, enctype --}}
        <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">

            {{-- TODO: Validation --}}
            @csrf

            <div class="form-group row mb-3">
                <label for="home_team_id" class="col-sm-2 col-form-label">Hazai csapat*</label>
                <div class="col-sm-10">
                    <select class="form-control @error('home_team_id') is-invalid @enderror" id="home_team_id"
                        name="home_team_id">
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @if (old('home_team_id') == $team->id) selected @endif>
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
                            <option value="{{ $team->id }}" @if (old('away_team_id') == $team->id) selected @endif>
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
                        name="start" value="{{ old('start') }}">
                    @error('start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Mentés</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const coverImageInput = document.querySelector('input#cover_image');
        const coverPreviewContainer = document.querySelector('#cover_preview');
        const coverPreviewImage = document.querySelector('img#cover_preview_image');

        coverImageInput.onchange = event => {
            const [file] = coverImageInput.files;
            if (file) {
                coverPreviewContainer.classList.remove('d-none');
                coverPreviewImage.src = URL.createObjectURL(file);
            } else {
                coverPreviewContainer.classList.add('d-none');
            }
        }
    </script>
@endsection
