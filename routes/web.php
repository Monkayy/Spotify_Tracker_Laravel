<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'getHome'])->name('home');
Route::get('/discover-more', [HomeController::class, 'discoverMorePage'])->name('discover-more');

Route::middleware(['auth','isRegisteredUser','updateLastSeen'])->group(function() {

    Route::get('/user/{user}', [UserController::class, 'show'])
         ->name('user.show')
         ->middleware('isFriendWith');
         
    Route::resource('user', UserController::class)->except(['show']);
    
    Route::get('/api/user/{id}/profile-data', [UserController::class, 'getProfileData']);
    Route::get('/api/user/{id}/current-data', [UserController::class, 'getCurrentProfileData']);
    
    Route::get('/auth/spotify/redirect', [SpotifyController::class, 'redirectToProvider'])->name('spotify.redirect');
    Route::get('/auth/spotify/callback', [SpotifyController::class, 'handleProviderCallback'])->name('spotify.callback');
    Route::delete('/spotify/disconnect', [SpotifyController::class, 'disconnect'])->name('spotify.disconnect');
    
    Route::get('live-status/{id}', [UserController::class,'liveStatus']);
    
    Route::get('/ajaxUpdateCurrentSong',[UserController::class,'ajaxUpdateSong']);
    Route::get('/ajaxGetTopArtists', [UserController::class, 'ajaxGetTopArtists'])->name('ajax.top.artists');
    Route::get('/ajaxGetTopTracks', [UserController::class, 'ajaxGetTopTracks'])->name('ajax.top.tracks');
    
    Route::post('/{id}/friends/send', [FriendshipController::class, 'sendRequest'])->name('friends.sendRequest');
    Route::post('/{id}/friends/accept', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/{id}/friends/decline', [FriendshipController::class, 'declineRequest'])->name('friends.decline');

    Route::get('/user/{id}/destroy/confirm', [UserController::class, 'confirmDestroy'])->name('user.destroy.confirm');
    
    Route::middleware(['isUserOnline'])->group(function(){
        Route::get('/{id}/friends', [FriendshipController::class, 'index'])->name('friends.index');
    });
    
});

Route::middleware(['auth','isAdmin','updateLastSeen'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});