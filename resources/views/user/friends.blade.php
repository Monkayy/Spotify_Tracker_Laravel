@extends('layouts.master')


@section('title')
Spotify Tracker :: Your Friends
@endsection

@section('body_class')
friends
@endsection


@section('active_profile')
active
@endsection

@section('body')

<script>
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            $("#friendsTable tbody tr").each(function() {
                var rowText = $(this).text().toLowerCase();
                var found = rowText.indexOf(searchTerm) > -1;
                
                $(this).toggle(found);
            });
        });
    });
    
</script>


<div class="container" style="margin-top: 80px;">
    <div class="row mb-5">
        <div class="col">
            <h1 class="text-green text-center mb-5 fw-bold">
                <i class="bi bi-people-fill me-3"></i>Le Tue Amicizie
            </h1>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <h2 class="text-green mb-2">{{ $onlineFriendsCount }}</h2>
                            <p class="mb-1 fw-semibold">Amici Online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <h2 class="text-green mb-2">{{ auth()->user()->getFriendRequests()->count() }}</h2>
                            <p class="mb-1 fw-semibold">Richieste</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="card-body text-center p-4">
                            <h2 class="text-green mb-2">{{ auth()->user()->getFriends()->count() }}</h2>
                            <p class="mb-1 fw-semibold">Amici totali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mb-5">
        <div class="col-md-6">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show round-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show round-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show round-3" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <div class="search-container">
                <div class="input-group">
                    <input id='searchInput' type="text" class="form-control search-bar" placeholder="Cerca nuovi amici...">
                </div>
                
                <hr>
                
                <!-- Tabella risultati ricerca -->
                <div class="d-flex justify-content-center">
                    <div class="table-responsive rounded-3 overflow-hidden border" style="width: 85%; max-width: 600px;">
                        <table id="friendsTable" class="table table-hover mb-0">
                            <tbody>
                                @foreach ($users_list as $user)
                                @if ($user->name != auth()->user()->name && !auth()->user()->isFriendWith($user))
                                <tr>
                                    <td class="text-center align-middle" style="width: 60px;">
                                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                                        style="width: 35px; height: 35px;">
                                        <i class="bi bi-person text-secondary"></i>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $user->name }}</span>
                                </td>
                                <td class="text-end align-middle">
                                    <form method="POST" action="{{ route('friends.sendRequest', ['id' => $user->id]) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-person-plus me-1"></i>
                                            Aggiungi
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs custom-tabs mb-4" id="friendsTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#friends">
            <i class="bi bi-people me-2"></i>I Tuoi Amici
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#requests">
            <i class="bi bi-bell me-2"></i>Richieste
            @if (auth()->user()->getFriendRequests()->count() > 0)
                <span class="badge text-bg-danger rounded-pill"> {{ auth()->user()->getFriendRequests()->count() }}</span>
            @endif
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Lista Amici -->
    <div class="tab-pane fade show active" id="friends">
        <div class="row g-4">
            @foreach ($friends_list as $friend)
            <div class="col-md-6 col-lg-4">
                <div class="friend-activites-cards h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <i class="bi bi-person-fill text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $friend->name }}</h5>
                                    @if (Cache::has('user-is-online-' . $friend->id))
                                    <span class="text-success">Online</span>
                                    @else
                                    <span class="text-muted">Offline</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="status_{{ $friend->id }}">
                            <script>
                                window.setInterval(function() {
                                    $.ajax({
                                        url: '{{ url("live-status/" . $friend->id) }}'
                                        method: 'GET',
                                        success: function (result) {
                                            $('#status_{{ $friend->id }}').html("Stato: " + result.status + "<br/>Ultimo accesso: " + result.last_seen);
                                        }
                                    });
                                }, 10000);
                            </script>
                        </div>
                        @if ($currTrackFriends)
                        <div class="mb-3 p-2 rounded" style="background: rgba(29, 185, 84, 0.1);">
                            
                            <p class="small mb-0">
                                <i class="bi bi-music-note me-2"></i>
                                <strong>Sta ascoltando:</strong><br>
                                <span>{{ $currTrackFriends[$friend->id]['name'] }} - </span>
                                
                                @for ($i=0; $i<count($currTrackFriends[$friend->id]['artists']); $i++)
                                {{ $currTrackFriends[$friend->id]['artists'][$i]['name'] }}
                                @if ($i < count($currTrackFriends[$friend->id]['artists']) - 1), @endif
                                @endfor
                                
                            </p>
                            
                        </div>
                        @else
                        <strong class="mt-1">Non è online su spotify</strong><br>
                        @endif
                        <div class="d-flex">
                            <a class="btn btn-outline-light btn-sm flex-fill href="{{ route('user.show',['user' => $friend->id ]) }}">
                                <i class="bi bi-person me-1"></i>Profilo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div> 
    
    <!-- Richieste -->
    <div class="tab-pane fade" id="requests">
        <div class="row g-4">
            
            @foreach ($pending_requests as $req)
            <div class="col-md-6">
                <div class="friend-activites-cards" style="border-color: #f59e0b;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); width: 55px; height: 55px;">
                                    <i class="bi bi-person-fill text-white fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $req->name }}</h5>
                                    <p class="small text-muted mb-1">ti ha inviato una richiesta di amicizia</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <form method="POST" action="{{ route('friends.accept',['id' => $req->id]) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-lg"></i> Accetta
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('friends.decline', ['id' => $req->id]) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-lg"></i> Rifiuta
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection