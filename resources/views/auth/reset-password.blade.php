@extends('layouts.master')
@section('title')
Spotify Tracker :: Nuova Password
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
                    <h2 class="fw-bold mb-2">Imposta Nuova Password <span class="text-primary">Spotify Tracker</span></h2>
                    <p class="text-muted">Inserisci la tua nuova password</p>
                </div>
                
                <!-- Error Messages -->
                @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                
                <!-- Reset Password Form - Updated to use Breeze route name -->
                <form id="password-reset-form" method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->token }}">
                    <input type="hidden" name="email" value="{{ $email ?? request('email') }}">
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-envelope-at"></i>
                            </span>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            placeholder="Email" value="{{ old('email', $email ?? request('email')) }}" required readonly>
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Nuova Password" required>
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Password Confirmation Field -->
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text border-end-0">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                            placeholder="Conferma Nuova Password" required>
                        </div>
                        @error('password_confirmation')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Password Requirements Info -->
                    <div class="mb-4">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            La password deve contenere almeno 8 caratteri
                        </small>
                    </div>
                    
                    <button form="password-reset-form" type="submit" class="btn btn-success w-100 mb-4">
                        <i class="bi bi-check-circle me-2"></i>Aggiorna Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection