@extends('layouts.app')
@section('title', 'Új csapat hozzáadása')

@php
    $teams = App\Models\Team::all()->sortBy('name');
@endphp

@section('content')
    <div class="container">
        <h1>Új csapat hozzáadása</h1>
        <div class="mb-4">
            <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>
        </div>

        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Csapat neve*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="short_name" class="col-sm-2 col-form-label">Csapat név rövidítése*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('short_name') is-invalid @enderror" id="short_name"
                        name="short_name" value="{{ old('short_name') }}">

                    @error('short_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            @php
                $logo = old('cover_image') ? url(old('cover_image')) : asset('images/default_game_cover.jpg');
            @endphp
            <div class="form-group row mb-3">
                <label for="cover_image" class="col-sm-2 col-form-label">Csapat logó</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                            <div id="cover_preview" class="col-12 d-none">
                                <p>Logó előnézet:</p>
                                <img id="cover_preview_image" src="{{ $logo }}" alt="" width="200px">
                            </div>
                        </div>
                    </div>
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
