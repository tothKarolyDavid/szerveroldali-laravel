@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ellenőrizd az e-mail fiókodat') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Az új megerősítő linket elküldtük az e-mail fiókodba.') }}
                        </div>
                    @endif

                    {{ __('Mielőtt továbbmennél, kérlek ellenőrizd az e-mail fiókodat a megerősítő linkért.') }}
                    {{ __('Ha nem kaptad meg az e-mailt') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kattints ide egy újabb kérés küldéséhez') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
