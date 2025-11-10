<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SpotifyController extends Controller{
    public function redirectToProvider(){

        return Socialite::driver('spotify')->scopes(
            [
                'user-read-currently-playing',
                'user-read-recently-played',
                'user-top-read',
                'user-read-private',
                'user-read-playback-state',
                'user-read-email',
            ]
        )->redirect();
    }
            
    public function handleProviderCallback(){
        $spotifyUser = Socialite::driver('spotify')->user();
        
        $user = auth()->user();
        
        $user->update([
            'provider_id' => $spotifyUser->getId(),
            'spotify_access_token' => $spotifyUser->token,
            'spotify_refresh_token' => $spotifyUser->refreshToken,
            'spotify_token_expires_at' => Carbon::now()->addSeconds($spotifyUser->expiresIn),
            'avatar_url' => $spotifyUser->getAvatar(),
        ]);
        
        return redirect()->route('user.show',['user' => auth()->user()->id]);
    }

    public function disconnect(){
        $user = auth()->user();

        $user->update([
            'provider_id' => null,
            'spotify_access_token' => null,
            'spotify_refresh_token' => null,
            'avatar_url' => null,
        ]);
        
        return redirect()->back()->with('success_disconnected_spotify', 'Account Spotify scollegato con successo!');
    }
            
            
}
        
        