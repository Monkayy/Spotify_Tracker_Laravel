@extends('layouts.master')
@section('body')
<div class="container-fluid d-flex align-items-center justify-content-center pt-5 vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            <div class="signup-card p-4 p-md-5 rounded shadow">
                <!-- Logo/Icon -->
                <div class="text-center mb-4">
                    <div class="music-icon mb-3">
                        <i class="bi bi-exclamation-triangle justify-content-center" style="font-size: 3rem;"></i>
                    </div>
                </div>
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2">Oops! Qualcosa è andato storto</h2>
                    <p class="text-muted">La risorsa da te richiesta non è ottenibile</p>
                </div>
                
                <div class="d-grid gap-2 mb-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Torna Indietro
                    </a>
                </div>
                
                <div class="text-center">
                    <p class="text-muted mb-0 small">
                        Se il problema persiste, contatta il supporto tecnico
                    </p>
                    <p class="text-muted mb-0 small">
                        <span class="text-primary fw-semibold">Spotify Tracker</span> - Errore generato alle {{ now()->format('H:i:s') . ' UTC'}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection