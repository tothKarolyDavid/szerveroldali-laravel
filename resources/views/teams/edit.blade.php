@extends('layouts.app')
@section('title', 'Csapat szerkesztése')

@section('content')
    <div class="container">
        <h1>Csapat szerkesztése</h1>
        <div class="mb-4">
            {{-- TODO: Link --}}
            <a href="{{ route('home') }}"><i class="fas fa-long-arrow-alt-left"></i>Vissza a főoldalra</a>
        </div>

        <form action="{{ route('teams.update', ['team' => $team->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Csapat neve*</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $team->name) }}">

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
                        name="short_name" value="{{ old('short_name', $team->shortname) }}">

                    @error('short_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="cover_image" class="col-sm-2 col-form-label">Csapat logó</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="file" class="form-control-file" id="cover_image" name="cover_image">
                            </div>
                        </div>
                    </div>
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
