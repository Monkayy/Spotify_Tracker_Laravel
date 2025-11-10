<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Spotify {
    protected SpotifyTokenService $tokenService;
    
    public function __construct(SpotifyTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    
    protected function api(User $user){
        if (!$this->tokenService->refreshTokenIfNeeded($user)) {
            throw new \Exception('Unable to refresh Spotify token');
        }
        
        return Http::withToken($user->fresh()->spotify_access_token)
        ->baseUrl('https://api.spotify.com/v1');
    }
    
    public function currentlyPlaying(User $user): ?array{
        try {
            $response = $this->api($user)->get('/me/player/currently-playing');
            
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Spotify API error in currentlyPlaying', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    public function playerState(User $user){
        try {
            $response = $this->api($user)->get('/me/player');
            
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Spotify API error in playerState', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    public function listeningTimeToday(User $user): float {
        try {
            $response = $this->api($user)->get('/me/player/recently-played', [
                'limit' => 50,
            ]);
            
            if (!$response->successful()) {
                return 0;
            }
            
            $items = collect($response->json('items'));
            $today = $items->filter(fn($item) => Carbon::parse($item['played_at'])->isToday());
            
            $totalMs = $today->sum(fn($track) => $track['track']['duration_ms'] ?? 0);
            return round($totalMs / 1000 / 3600, 1);
        } catch (\Exception $e) {
            Log::error('Spotify API error in listeningTimeToday', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }
    
    public function listeningTimeByArtistWithPeriod($user, $artistNames){

        $artistMinutes = [];
        foreach ($artistNames as $artist) {
            $name = $artist['name'];
            $artistMinutes[$name] = 0;
        }
        
        try {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $response = $this->api($user)->get('/me/player/recently-played', [
                'limit' => 50,
            ]);
            
            if (!$response->successful()) {
                return 0;
            }
            
            $items = collect($response->json('items'));
            
            $periodTracks = $items->filter(function($item) use ($startDate, $endDate) {
                $playedAt = Carbon::parse($item['played_at']);
                return $playedAt->between($startDate, $endDate);
            });
            
            
            // Itero su tutte le tracce ascoltate nell'ultimo mese
            foreach ($periodTracks as $item) {
                $durationMs = $item['track']['duration_ms'] ?? 0;
                $trackArtists = collect($item['track']['artists']);
                
                
                // Itero su tutti i nomi di artisti passati come parametro al metodo
                foreach ($trackArtists as $trackArtist) {
                    foreach ($artistNames as $artist) {
                        $targetName = $artist['name'] ?? null;
                        
                        if ($targetName && stripos($trackArtist['name'], $targetName) !== false) {
                            $artistMinutes[$targetName] += $durationMs / 1000 / 60;
                            break;
                        }
                    }
                }
            }
            
            return array_map(function ($minutes) {
                $minutes = round($minutes);
                if ($minutes < 60) {
                    return "{$minutes} min";
                } else {
                    $hours = intdiv($minutes, 60);
                    $remaining = $minutes % 60;
                    return "{$hours}h " . ($remaining > 0 ? "{$remaining}min" : "");
                }
            }, $artistMinutes);

        } catch (\Exception $e) {
            Log::error('Spotify API error in listeningTimeByArtistWithPeriod', [
                'user_id' => $user->id,
                'artist' => $artistNames,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }
    
    public function topArtists(User $user, string $timeRange = 'medium_term', int $limit = 3) {
        try {
            $response = $this->api($user)->get('/me/top/artists', [
                'limit' => $limit,
                'time_range' => $timeRange,
            ]);
            
            return $response->successful() ? $response->json('items') : [];
        } catch (\Exception $e) {
            Log::error('Spotify API error in topArtists', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }
    
    public function topTracks(User $user, string $timeRange = 'medium_term', int $limit = 3): array
    {
        try {
            $response = $this->api($user)->get('/me/top/tracks', [
                'limit' => $limit,
                'time_range' => $timeRange,
            ]);
            
            return $response->successful() ? $response->json('items') : [];
        } catch (\Exception $e) {
            Log::error('Spotify API error in topTracks', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }
}