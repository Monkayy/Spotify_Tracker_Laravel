@extends('layouts.master')

@section('title')
Spotify Tracker :: Your Profile
@endsection


@section('active_profile')
active
@endsection


@section('body')
<script>
    
</script>
<div class="container" style="margin-top: 80px;">
    <!-- Profilo Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card profile-stats">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="{{ $user->avatar_url }}" 
                            alt="Profilo" class="rounded-circle mb-3" width="150" height="150">
                            <h4 class="text-spotify">{{ $user->name }}</h4>
                            <p class="text-secondary">Membro da {{ 
                                date_format($user->created_at, "d M Y" )  
                            }}</p>
                        </div>
                        <div class="col-md-9">
                            <div class="row text-center">
                                <div class="col">
                                    @php
                                        $hours = floor($minutesToday);
                                        $minutes = round(($minutesToday - $hours)*60);
                                    @endphp
                                    <div id="listening-time" class="stat-number">
                                        {{ $hours }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <small class="text-secondary">Ore di ascolto oggi</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sezione In Ascolto Ora -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="user-id-{{ $user->id }}" class="card now-playing">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-play-circle me-2"></i>In Ascolto Ora
                    </h5>
                </div>
                <div class="card-body">
                    @if ($currentlyPlaying)
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img id="currPlaying-albumCover" src="{{ $currentlyPlaying['item']['album']['images'][0]['url']  }}" alt="Album Cover" class="album-cover img-fluid"> <!--  -->
                        </div>
                        <div class="col-md-8">
                            <h4 id="currPlaying-songName" class="mb-1">{{ $currentlyPlaying['item']['name'] }}</h4>
                            <h6 id="currPlaying-artistName" class="text-spotify mb-2">{{ $currentlyPlaying['item']['artists'][0]['name'] }}</h6>
                            <p id="currPlaying-albumName" class="text-secondary mb-2">{{ $currentlyPlaying['item']['album']['name'] }}</p> <!-- -->
                            <div class="progress" style="height: 6px;">
                                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <div id="songDurations" class="d-flex justify-content-between mt-1">
                                <small data-progress="currPlaying-progress" id="{{ $currentlyPlaying['progress_ms'] }}" class="text-secondary">00:00</small>
                                <small id="currentTime"></small>
                                <small data-duration="currPlaying-duration" id="{{ $currentlyPlaying['item']['duration_ms'] }}" class="text-secondary"></small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <button data-isPlaying="{{ $playerState['is_playing'] }}" id="state-button" class="btn btn-spotify btn-lg rounded-circle mb-2">
                                <div id="icon-state-button">
                                </div>
                            </button>
                            <br>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-music-note-beamed text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Nessuna canzone in riproduzione</h5>
                        <p class="text-secondary mb-0">L'utente è attualmente offline o non sta ascoltando alcun brano</p>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Artisti e Brani -->
    <div class="row mb-4">
        <!-- Top Artisti -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-award me-2"></i>Top Artisti
                    </h5>
                </div>
                <select class="form-select" id="timeRangeArtist" name="time_range">
                    <option value="short_term">
                        Ultimo Mese
                    </option>
                    <option value="medium_term">
                        Ultimi 6 Mesi
                    </option>
                    <option value="long_term">
                        Ultimo anno
                    </option>
                </select>
                <div id="card-top-artists" class="card-body">
                    <div class="track-item p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-spotify me-3">#1</span>
                            <img src="{{ $topArtistsShort['0']['images']['0']['url'] }}" 
                            alt="Artista" class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $topArtistsShort['0']['name'] }}</h6>
                                <small class="text-secondary">{{ $listeningTimeByArtistWithPeriod[$topArtistsShort['0']['name']] }}</small>
                            </div>
                            <div class="text-end">
                                <div class="text-spotify">{{ $topArtistsShort['0']['popularity'] }}</div>
                                <small class="text-secondary">popolarità</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="track-item p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-secondary me-3">#2</span>
                            <img src="{{$topArtistsShort['1']['images']['0']['url']}}" 
                            alt="Artista" class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $topArtistsShort['1']['name'] }}</h6>
                                <small class="text-secondary">{{ $listeningTimeByArtistWithPeriod[$topArtistsShort['1']['name']] }}</small>
                            </div>
                            <div class="text-end">
                                <div class="text-spotify">{{ $topArtistsShort['1']['popularity'] }}</div>
                                <small class="text-secondary">popolarità</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="track-item p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning text-dark me-3">#3</span>
                            <img src="{{$topArtistsShort['2']['images']['0']['url']}}" 
                            alt="Artista" class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $topArtistsShort['2']['name'] }}</h6>
                                <small class="text-secondary">{{ $listeningTimeByArtistWithPeriod[$topArtistsShort['2']['name']] }}</small>
                            </div>
                            <div class="text-end">
                                <div class="text-spotify">{{ $topArtistsShort['2']['popularity'] }}</div>
                                <small class="text-secondary">popolarità</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Brani -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-music-note-beamed me-2"></i>Top Brani
                    </h5>
                </div>
                <select class="form-select" id="timeRangeTrack" name="time_range">
                    <option value="short_term">
                        Ultimo Mese
                    </option>
                    <option value="medium_term">
                        Ultimi 6 Mesi
                    </option>
                    <option value="long_term">
                        Ultimo anno
                    </option>
                </select>
                <div id="card-top-tracks" class="card-body">
                    @for ($i=0; $i<count($topArtistsShort); $i++)
                    <div class="track-item p-3 mb-3">
                        <div class="d-flex align-items-center">
                            @if ($i === 0)
                            <span class="badge badge-spotify me-3">{{ '#' . $i+1 }}</span>
                            @elseif ($i===1)
                            <span class="badge bg-secondary me-3">{{'#' .  $i+1 }}</span>
                            @elseif ($i===2)
                            <span class="badge bg-warning me-3 text-dark">{{ '#' . $i+1 }}</span>
                            @else
                            <span class="badge bg-body-secondary me-3">{{ '#' . $i+1 }}</span>
                            @endif
                            
                            <img src="{{ $topTracksShort[$i]['album']['images']['0']['url'] }}" 
                            alt="Album" class="album-cover me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $topTracksShort[$i]['name'] }}</h6>
                                <small class="text-secondary"> 
                                    @foreach ($topTracksShort[$i]['artists'] as $artist)
                                    {{ $artist['name'] }}@if (!$loop->last), @endif
                                    @endforeach
                                </small>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection