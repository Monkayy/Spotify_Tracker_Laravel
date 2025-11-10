@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('active_isAdmin')
active
@endsection

@section('body')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
<body>
    <section class="hero-gradient d-flex align-items-start position-relative overflow-hidden" style="padding-top: 100px; min-height: 100vh;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <!-- Header Dashboard -->
                    <div class="text-center mb-5">
                        <h1 class="display-3 fw-bold text-white mb-3">
                            <i class="bi bi-speedometer2 me-3" style="color: #1db954;"></i>
                            Dashboard
                        </h1>
                        <p class="lead text-white-75 fs-5">
                            Monitora gli utenti e il loro stato di attività su Spotify
                        </p>
                        
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div> 
                        @endif
                        
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-dark bg-opacity-50 border-0 text-white backdrop-blur">
                                <div class="card-body text-center">
                                    <i class="bi bi-people-fill fs-1 mb-3" style="color: #1db954;"></i>
                                    <h3 class="fw-bold">{{ $users->count() ?? 0 }}</h3>
                                    <p class="mb-0">Utenti Totali</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-dark bg-opacity-50 border-0 text-white backdrop-blur">
                                <div class="card-body text-center">
                                    <i class="bi bi-circle-fill fs-1 mb-3 text-success"></i>
                                    <h3 class="fw-bold">{{ $online_users->count() ?? 0 }}</h3>
                                    <p class="mb-0">Utenti Online</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabella Utenti -->
                    <div class="card bg-dark bg-opacity-50 border-0 backdrop-blur">
                        <div class="card-header border-0 bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-white mb-0">
                                    <i class="bi bi-table me-2" style="color: #1db954;"></i>
                                    Utenti Registrati
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <i class="bi bi-person-circle me-2"></i>
                                                Utente
                                            </th>
                                            <th scope="col">
                                                <i class="bi bi-envelope me-2"></i>
                                                Email
                                            </th>
                                            <th scope="col">
                                                <i class="bi bi-music-note me-2"></i>
                                                Attività Spotify
                                            </th>
                                            <th scope="col">
                                                <i class="bi bi-calendar-event me-2"></i>
                                                Ultimo Accesso
                                            </th>
                                            <th scope="col">
                                                <i class="bi bi-gear me-2"></i>
                                                Azioni
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="users-table-body">
                                        @forelse($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($user->avatar_url)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                    @else
                                                    <i class="bi bi-person-circle fs-4 me-2 text-muted"></i>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                        @if($user->name)
                                                        <br><small class="text-muted">{{ $user->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <div id="spotify-activity-{{ $user->id }}">
                                                    @if($currTracksUsers[$user->id] ?? null)
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-play-circle-fill text-success me-2"></i>
                                                        <div>
                                                            <div class="fw-semibold">{{ $currTracksUsers[$user->id]['name'] }}</div>
                                                            <small class="text-muted">{{ $currTracksUsers[$user->id]['artists']['0']['name'] }}</small>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">
                                                        <i class="bi bi-pause-circle me-1"></i>
                                                        Non in ascolto
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $user->last_seen->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li><a class="dropdown-item" href="{{ route('user.show', $user->id) }}">
                                                            <i class="bi bi-eye me-2"></i>Visualizza Profilo
                                                        </a></li>
                                                        
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li class="text-center">
                                                            <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a href="{{ route('user.destroy.confirm', ['id' => $user->id]) }}" class="text-danger text-decoration-none">
                                                                    <i class="bi bi-trash me-2"></i>Elimina Utente
                                                                </a>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                                Nessun utente trovato
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
@endsection