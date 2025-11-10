@extends('layouts.master')


@section('title')
Spotify Tracker :: Discover more
@endsection


@section('active_profile')
active
@endsection

@section('login_register_buttons')
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
@endsection


@section('body')

<section class="text-white py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="bi bi-music-note-beamed spotify-green me-3"></i>
                    Spotify Tracker
                </h1>
                <p class="lead">Il modo più semplice per tracciare e analizzare la tua musica preferita</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Scopri cosa puoi fare con Music Tracker</h2>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-spotify fs-1 spotify-green mb-3"></i>
                                <h5 class="card-title">Connessione a Spotify</h5>
                                <p class="card-text">Collega in maniera facile e veloce il tuo account Spotify per iniziare a tracciare tutto ciò che ascolti</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-graph-up fs-1 spotify-green mb-3"></i>
                                <h5 class="card-title">Statistiche Dettagliate</h5>
                                <p class="card-text">Visualizza grafici e analisi sui tuoi ascolti: artisti più ascoltati, generi preferiti e molto altro.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-clock-history fs-1 spotify-green mb-3"></i>
                                <h5 class="card-title">Cronologia Ascolti</h5>
                                <p class="card-text">Tieni traccia di tutto quello che ascolti e rivedi la tua storia musicale nel tempo.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-share fs-1 spotify-green mb-3"></i>
                                <h5 class="card-title">Condivisione</h5>
                                <p class="card-text">Condividi le tue statistiche musicali con gli amici e scopri i loro gusti musicali.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="border-secondary mx-auto" style="width: 80%; height: 5px">

<!-- How it works -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Come Funziona Spotify Tracker?</h2>
                
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="bg-secondary-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="badge bg-spotify fs-4">1</span>
                        </div>
                        <h5>Connetti Spotify</h5>
                        <p class="text-muted">Autorizza l'accesso al tuo account Spotify in modo sicuro attraverso le API ufficiali</p>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="bg-secondary-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="badge bg-spotify fs-4">2</span>
                        </div>
                        <h5>Inizia il Tracking</h5>
                        <p class="text-muted">Ecco fatto! Ora Spotify Tracker traccerà ogni tuo ascolto</p>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="bg-secondary-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <span class="badge bg-spotify fs-4">3</span>
                        </div>
                        <h5>Visualizza tutte le statistiche della tua musica</h5>
                        <p class="text-muted">Esplora i tuoi dati musicali attraverso grafici e analisi dettagliati progettati dal nostro team</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="border-secondary mx-auto" style="width: 80%; height: 5px">

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-5">Domande Frequenti</h2>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <p class="fw-bold">Il servizio che offrite è gratuito?</p>
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Assolutamente sì, Spotify Tracker è completamente gratuito, open source e senza alcun costo nascosto o
                                limite di utilizzo. Ci teniamo a far si che la vostra esperienza sia la migliore possibile, senza costi.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed mb-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <p class="fw-bold">I miei dati sono al sicuro?</p> 
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Assolutamente sì. Abbiamo la privacy dei nostri utenti a cuore e per questo cifriamo qualsiasi
                                dato che inserirete all'interno di Spotify Tracker, senza avere mai un accesso in chiaro ai vostri dati sensibili.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <p class="fw-bold">È necessario avere Spotify premium?</p> 
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No! Spotify Tracker è stato pensato come una risorsa utile a tutti gli utilizzatori di Spotify, premium o meno.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="border-secondary mx-auto" style="width: 80%; height: 5px">

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-6">
                <h2 class="mb-4">Pronto per iniziare?</h2>
                <p class="lead mb-4">Esplora il tuo universo musicale come mai prima d'ora</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="#" class="btn bg-spotify btn-lg px-4">
                        <i class="bi bi-person-plus"></i>
                        Registrati Ora!
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-house me-2"></i>
                        Torna alla home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection