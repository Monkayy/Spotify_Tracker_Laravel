<!DOCTYPE html>
<html lang="it" data-bs-theme="dark">
<head>
  <title>@yield('title')</title>
  <meta charset="UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{url('/')}}/css/user_profile_style.css" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  
  <script src="{{ url('/') }}/js/updateCurrentSong.js"></script>
  <script src="{{ url('/') }}/js/updateTopTracks.js"></script>
  <script src="{{ url('/') }}/js/updateTopArtists.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class=@yield('body_class')>
  <nav class="navbar navbar-dark fixed-top border-body navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('logos/spotify-icon.svg') }}" width="30" height="30"> 
        <span id="navbar-brand-title">Spotify Tracker</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link @yield('active_home') text-light" aria-current="page" href="{{ route('home') }}">
              <i class="bi bi-house me-1"></i>
              Home
            </a>
          </li>
          @if (auth()->check())
            @if (auth()->user()->role === 'admin')
            <li class="nav-item">
              <a class="nav-link @yield('active_isAdmin') text-light" aria-current="page" href="{{ route('dashboard.index') }}">
                <i class="bi bi-wrench"></i>
                Dashboard
              </a>
            </li>
            @endif
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @yield('active_profile') text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-list"></i>
              Il mio account
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('user.show',['user' => auth()->user()->id]) }}">
                <i class="bi bi-file-person-fill"></i>
                Il mio profilo
              </a></li>
              <li><a class="dropdown-item" href="{{ route('user.edit', ['user' => auth()->user()->id]) }}">
                <i class="bi bi-gear-wide-connected"></i>
                Impostazioni
              </a></li>
              <li><a class="dropdown-item text-light" href="{{ route('friends.index', ['id' => auth()->user()->id]) }}">
                <i class="bi bi-people me-1"></i>
                I miei amici
              </a></li>
            </ul>
          </li>
          @endif
          
        </ul>
        @yield('login_register_buttons')
      </div>
    </div>
  </nav>
  
  @yield('body')
  
</body>
</html>