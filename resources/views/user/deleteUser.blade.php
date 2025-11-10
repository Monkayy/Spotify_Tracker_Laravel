@extends('layouts.master')

@section('title')
Conferma Cancellazione Account
@endsection

@section('active_home')
active
@endsection

@section('login_register_buttons')
@if (auth()->check())
<div class="hstack gap-3">
    <a class="nav-link text-light" href="#" role="button" aria-expanded="false">
        <i class="bi bi-person-circle"></i>
        {{ auth()->user()->name }}
    </a>
    <div class="vr"></div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link">
            <i class="bi bi-box-arrow-right me-1"></i>
            Logout
        </button>
    </form>
</div>
@endif
@endsection

@section('body')
<section class="hero-gradient d-flex align-items-center position-relative overflow-hidden min-vh-100" style="padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Conferma Cancellazione Account</h2>
                    </div>
                    
                    
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-semibold mb-3">
                                Sei davvero sicuro di voler cancellare l'account: {{ $user->name }}?
                            </h4>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-4 py-2 fs-6">
                                    <i class="bi bi-shield-exclamation me-1"></i>
                                    Questa azione è irreversibile!
                                </span>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center align-items-center gap-4">
                            <form method="POST" action="{{ route('user.destroy',['user'=>$user->id]) }}" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-semibold" style="width: 200px; height: 50px;">
                                    <i class="bi bi-trash-fill me-2"></i>
                                    Cancella
                                </button>
                            </form>
                            
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg rounded-pill fw-semibold d-flex align-items-center justify-content-center" style="width: 200px; height: 50px;">
                                <i class="bi bi-arrow-left me-2"></i>
                                Annulla
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection