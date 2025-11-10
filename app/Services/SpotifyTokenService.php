<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyTokenService{
    public function refreshTokenIfNeeded(User $user): bool{
        if (!$this->isTokenExpired($user)) {
            return true;
        }

        if (!$user->spotify_refresh_token) {
            Log::warning('No refresh token available for user: ' . $user->id);
            return false;
        }

        return $this->refreshToken($user);
    }

    protected function isTokenExpired(User $user): bool{
        if (!$user->spotify_token_expires_at) {
            return true;
        }

        return Carbon::parse($user->spotify_token_expires_at)
            ->subMinutes(5)
            ->isPast();
    }

    protected function refreshToken(User $user): bool{
        try {
            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->spotify_refresh_token,
                'client_id' => config('services.spotify.client_id'),
                'client_secret' => config('services.spotify.client_secret'),
            ]);

            if (!$response->successful()) {
                Log::error('Failed to refresh Spotify token', [
                    'user_id' => $user->id,
                    'response' => $response->json()
                ]);
                return false;
            }

            $data = $response->json();

            $user->update([
                'spotify_access_token' => $data['access_token'],
                'spotify_token_expires_at' => Carbon::now()->addSeconds($data['expires_in']),
                'spotify_refresh_token' => $data['refresh_token'] ?? $user->spotify_refresh_token,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Exception while refreshing Spotify token', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}