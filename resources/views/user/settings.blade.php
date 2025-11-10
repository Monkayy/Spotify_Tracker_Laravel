@extends('layouts.master')


@section('title')
Spotify Tracker :: Settings
@endsection


@section('active_profile')
active
@endsection


@section('body')
<div class="container-fluid mt-5 pt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Profilo</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card sticky-top">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Impostazioni</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#profilo_utente" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person-circle"></i>
                        Il tuo profilo
                    </a>
                    <a href="#servizi" class="list-group-item list-group-item-action">
                        <i class="bi bi-link-45deg"></i>
                        Collega Spotify
                    </a>
                    <a href="#gestione_account" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-fill-gear"></i>
                        Account
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div id="profilo_utente" class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Informazioni Profilo</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    <form id="profileInfos" method="post" action="{{ route('user.update',['user' => auth()->user()->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nome Utente</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button form="profileInfos" type="submit" class="btn btn-success">
                            Salva Modifiche
                            <i class="bi bi-check2-circle"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div id="servizi" class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Collega il tuo account Spotify</h5>
                </div>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_disconnected_spotify') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                        <div>
                            <strong>Spotify</strong>
                            @if(auth()->user()->provider_id)
                            <div class="text-muted small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                Collegato come {{ auth()->user()->provider_id }}
                            </div>
                            @else
                            <div class="text-muted small">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                Non collegato
                            </div>
                            @endif
                        </div>
                        
                        @if(auth()->user()->provider_id)
                        <form method="POST" action="{{ route('spotify.disconnect') }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                            onclick="return confirm('Sei sicuro di voler scollegare il tuo account Spotify?')">
                            <i class="bi bi-unlink"></i>
                            Scollega Account
                        </button>
                    </form>
                    @else
                    <a href="{{ route('spotify.redirect') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-spotify"></i>
                        Collega Account
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div id="gestione_account" class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Gestione Account</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Cambia Password</h6>
                    <button class="btn btn-outline-success">Modifica Password</button>
                </div>
                <div class="mb-3">
                    <h6>Elimina Account</h6>
                    <a href="{{  route('user.destroy.confirm',['id' => auth()->user()->id]) }}" class="btn btn-outline-danger">
                        Elimina Account
                        <i class="bi bi-trash3-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection