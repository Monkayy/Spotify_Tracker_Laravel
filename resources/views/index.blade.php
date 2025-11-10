@extends('layouts.master')


@section('title')
Track your vibe
@endsection


@section('active_home')
active
@endsection

@section('login_register_buttons')
@if (auth()->check())
<div class="hstack gap-3">
    <a class="nav-link text-light" href="#" role="button" aria-expanded="false">
      <i class="bi bi-person-circle"></i>
      Bentornato {{ auth()->user()->name }}
    </a>
    <div class="vr"></div>
    <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link">
            <i class="bi bi-box-arrow-right"></i>
            Logout
          </button>
    </form>
</div>
@else
<div class="d-flex gap-2">
    <a href="{{ route('login') }}" class="btn btn-success shadow-sm text-decoration-none">
        <i class="bi bi-music-note me-1"></i>
        Login
    </a>
    <a href="{{ route('register') }}" class="btn btn-info shadow-sm text-decoration-none">
        <i class="bi bi-vinyl me-1"></i>
        Registrati
    </a>
</div>
@endif

@endsection


@section('body')
<body> 
    <section class="hero-gradient d-flex align-items-center position-relative overflow-hidden" style="padding-top: 80px;">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="position-absolute text-white-50 floating-note" style="top: 100px; left: 50px;">
                        <i class="bi bi-music-note-beamed fs-1"></i>
                    </div>
                    <div class="position-absolute text-white-50 floating-note" style="top: 100px; right: 50px; animation-delay: -1s;">
                        <i class="bi bi-music-note fs-1"></i>
                    </div>
                    
                    <h1 class="display-1 fw-bold text-white mb-4 ">
                        Segui il TUO ritmo<br>
                        <span style="color: #1db954;">della musica</span>
                    </h1>
                    
                    <p class="lead text-white mb-5 fs-4">
                        Creato per offrire l'esperienza di tracking migliore possibile.<br>
                        <span style="color: #1db954;" class="tagline">Senza limiti, senza costi.</span>
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center">
                        <a href="{{ route('register') }}" class="btn btn-lg px-5 py-3 rounded-pill fw-semibold btn-glow transition-all" style="background-color: #1db954; border-color: #1db954; color: white;">
                            <i class="bi bi-play-circle-fill me-2"></i>
                            Inizia Ora
                        </a>
                        <a href="{{ route('discover-more') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-semibold btn-glow transition-all">
                            <i class="bi bi-info-circle me-2"></i>
                            Scopri di Più
                        </a>
                    </div>
                    
                    <div class="row mt-5 justify-content-center">
                        <div class="col-auto">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 me-2 mb-2">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                Gratuito
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 me-2 mb-2">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                Facile da usare
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 mb-2">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                Senza limiti
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="position-absolute bottom-0 start-50 translate-middle-x text-white-50">
            <i class="bi bi-chevron-down fs-2 floating-note" style="animation-delay: -0.5s;"></i>
        </div>
    </section>
    @endsection