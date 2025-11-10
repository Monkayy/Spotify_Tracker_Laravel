@extends('layouts.master')

@section('title')
Spotify Tracker :: Registrati
@endsection

@section('body')
<script>
    function isPasswordValid(pw){
        // Requisiti password:
        // 1) Almeno 8 caratteri
        // 2) Almeno una cifra
        // 3) Un carattere speciale tra ! - * [ ] $ & /)
        var regexpr = /^(?=.*[0-9])(?=.*[!-\*\[\]\$&\/]).{8,}$/;
        return regexpr.test(pw);
    }
    
    $(document).ready(function(){
        
        $('#togglePassword').on('click', function () {
            const $password = $('#password');
            const type = $password.attr('type') === 'password' ? 'text' : 'password';
            $password.attr('type', type);
            
            $(this).toggleClass('bi-eye bi-eye-slash');
        });
        
        $('#togglePasswordConfirm').on('click', function () {
            const $password = $('#passwordConfirm');
            const type = $password.attr('type') === 'password' ? 'text' : 'password';
            $password.attr('type', type);
            
            $(this).toggleClass('bi-eye bi-eye-slash');
        });
        $("#register-form").submit(function(event){
            var username = $("#register-form input[name=name]").val();
            var email = $("#register-form input[name=email]").val();
            var password = $("#register-form input[name=password]").val();
            var confirmPassword = $("#register-form input[name=password_confirmation]").val();
            var error = false;
            
            if (confirmPassword.trim() === "") {
                error = true;
                $("#invalid-confirm-password").text("La re-immissione della password è obbligatoria.");
                event.preventDefault();
                $("input[name='password_confirmation']").focus();
            } else {
                $("#invalid-confirm-password").text("");
            } 
            
            if (password.trim() === "") {
                error = true;
                $("#invalid-password").text("La password è obbligatoria.");
                event.preventDefault();
                $("#register-form input[name='password']").focus();
            } else if(!isPasswordValid(password)) {
                error = true;
                $("#invalid-password").html(`
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Almeno 8 caratteri</li>
                    <li>Almeno una cifra</li>
                    <li>Almeno un carattere speciale tra <code> ! - * [ ] $ & /)</code></li>
                </ul>
            `);
                event.preventDefault();
                $("#register-form input[name='password']").focus();
            } else {
                $("#invalid-password").text("");
            } 
            
            if (email.trim() === "") {
                error = true;
                $("#invalid-email").text("L'indirizzo email è obbligatorio.");
                event.preventDefault(); 
                $("#register-form input[name='email']").focus();
            } else {
                $("#invalid-email").text("");
            }
            
            // Verifica se il campo "name" è vuoto
            if (username.trim() === "") {
                error = true;
                $("#invalid-username").text("Il nome è obbligatorio.");
                event.preventDefault();
                $("input[name='name']").focus();
            } else {
                $("#invalid-username").text("");
            }
            
            // Se non c'è stato alcun errore allora procedi
            if(!error){
                if(confirmPassword.trim() !== password.trim()) {
                    $("#invalid-confirm-password").text("Immettere la stessa password due volte.");
                    event.preventDefault();
                    $("input[name='password_confirmation']").focus();
                } else {
                    $("#invalid-confirm-password").text("");
                    
                    // Solo se non ci sono errori, fai la chiamata AJAX
                    event.preventDefault();
                    
                    $.ajax({
                        type: 'GET',
                        url: '/ajaxUser',
                        data: {
                            email: email.trim(), 
                            username: username.trim()
                        },
                        success: function (data) {
                            if (data.found){
                                $("#invalid-email").text("L'email o lo username esiste già nel database.");
                            } else {
                                $("#register-form")[0].submit();
                            }
                        }
                    });
                }
            }
            
        });
    });
</script>

<div class="container-fluid d-flex align-items-center justify-content-center pt-5 vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="signup-card p-4 p-md-5">
                <!-- Logo/Icon -->
                <div class="music-icon">
                    <i class="bi bi-music-note-beamed""></i>
                </div>
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2">Unisciti a <span class="text-primary">Spotify Tracker!</span></h2>
                    <p class="text-muted">Scopri e traccia la tua musica preferita</p>
                </div>
                
                <!-- Registration Form -->
                <form id="register-form" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input name="name" type="text" class="form-control" placeholder="Username">
                        </div>
                        <span class="invalid-input" id="invalid-username"></span>
                    </div>
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope-at"></i>
                            </span>
                            <input name="email" type="email" class="form-control" placeholder="Email">
                        </div>
                        <span class="invalid-input" id="invalid-email"></span>
                    </div>
                    
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </span>
                        </div>
                        <span class="invalid-input text-danger" id="invalid-password"></span>
                    </div>
                    
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="passwordConfirm" name="password_confirmation" type="password" class="form-control" placeholder="Conferma password">
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash" id="togglePasswordConfirm"></i>
                            </span>
                        </div>
                        <span class="invalid-input text-danger" id="invalid-confirm-password"></span>
                    </div>
                    
                    <button form="register-form" type="submit" class="btn btn-success w-100 mb-4">
                        <i class="bi bi-door-open"></i>Registrati
                    </button>
                </form>
                
                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-muted mb-0">Hai già un account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #1db954;">Accedi qui</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection