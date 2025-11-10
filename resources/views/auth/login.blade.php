@extends('layouts.master')

@section('title')
Spotify Tracker :: Login
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
                    <i class="bi bi-music-note-beamed""></i>
                </div>
                
                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2">Bentornato su <span class="text-primary">Spotify Tracker</span></h2>
                    <p class="text-muted">Accedi</p>
                </div>
                @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
                @endif
                
                <!-- Login Form -->
                <form id="login-form" method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-envelope-at"></i>
                            </span>
                            <input name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <span class="invalid-input" id="invalid-email"></span>
                        @error('email')
                        <span class="invalid-input" style="display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                        @error('password')
                        <span class="invalid-input" style="display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                        <span class="invalid-input" id="invalid-password"></span>
                    </div>
                    
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Ricordami
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Password dimenticata?</a>
                    </div>
                    
                    <button form="login-form" type="submit" class="btn btn-success w-100 mb-4">
                        <i class="bi bi-box-arrow-in-right"></i> Accedi
                    </button>
                </form>
                
                <!-- Signup Link -->
                <div class="text-center">
                    <p class="text-muted mb-0">Non hai ancora un account? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #1db954;">Registrati qui</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection