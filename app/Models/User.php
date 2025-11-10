<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Multicaret\Acquaintances\Traits\Friendable;

class User extends Authenticatable implements CanResetPassword{
    use HasApiTokens, HasFactory, Notifiable;
    use Friendable;

    protected $fillable = [
        'name',
        'password',
        'email',
        'provider_id',
        'spotify_access_token',
        'spotify_refresh_token',
        'avatar_url',
        'is_admin',
        'is_active',
        'last_seen'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'spotify_access_token',
        'spotify_refresh_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'last_seen' => 'datetime',
    ];
}
