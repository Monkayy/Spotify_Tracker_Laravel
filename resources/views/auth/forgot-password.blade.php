@extends('layouts.master')
@section('title')
Spotify Tracker :: Reset Password
@endsection
@section('active_home')
active
@endsection
@section('body')
<div class="container-fluid d-flex align-items-center justify-content-center pt-5 vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            <div class="signup-card p-4 p-md-5">
                <!-- Logo/Icon -->
                <div class="music-icon">
                    <i class="bi bi-music-note-beamed"></i>
                </div>
                
                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2">Reimposta la password</h2>
                    <p class="text-muted">Inserisci la mail con cui ti sei registrato per ricevere il link di reset</p>
                </div>
                
                @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                
                <form id="reset-form" method="post" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-envelope-at"></i>
                            </span>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Inserisci la tua email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <button form="reset-form" type="submit" class="btn btn-success w-100 mb-4">
                        <i class="bi bi-envelope-paper me-2"></i>Invia Link di Reset
                    </button>
                </form>
                
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Torna alla schermata di login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection