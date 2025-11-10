<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use App\Models\User;
use App\Services\Spotify;
use App\Services\SpotifyTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(){
        abort(501);
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create(){
        abort(501);
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request){
        abort(501);
    }
    
    public function show(string $id){
        $dl = new DataLayer();
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        $friends_list = $dl->getFriends(auth()->user());
        
        
        $user = $dl->getUser($id);
        
        if($user !== null && $user->provider_id){
            return view('user.profile', [
                'user' => $user,
                'friends' => $friends_list,
                'listeningTimeByArtistWithPeriod' => $spotify->listeningTimeByArtistWithPeriod($user,$spotify->topArtists($user, 'short_term')),
                'currentlyPlaying' => $spotify->currentlyPlaying($user),
                'playerState' => $spotify->playerState($user),
                'minutesToday' => $spotify->listeningTimeToday($user),
                'topArtistsShort' => $spotify->topArtists($user, 'short_term'),
                'topArtistsMedium' => $spotify->topArtists($user, 'medium_term'),
                'topArtistsLong' => $spotify->topArtists($user, 'long_term'),
                'topTracksShort' => $spotify->topTracks($user, 'short_term'),
                'topTracksMedium' => $spotify->topTracks($user, 'medium_term'),
                'topTracksLong' => $spotify->topTracks($user, 'long_term'),
            ]);
        } else {
            return view('errors.noSpotifyAccountConnected')
            ->with('errorMessage','Connetti il tuo account Spotify per accedere a questa pagina');
        }
    }
    
    
    public function edit(string $id){        
        
        $dl = new DataLayer();
        $user = $dl->getUser($id);
        if($user !== null){
            return view('user.settings')->with('user',$user);
        } else {
            return redirect()->route('home')
            ->with('error', 'Questo utente non esiste.');
        }
        
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, string $id){
        $dl = new DataLayer();
        $user = $dl->getUser($id);
        
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:users,name,' . $id
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $id
            ],
        ], [
            'name.required' => 'Il nome utente è obbligatorio.',
            'name.min' => 'Il nome utente deve avere almeno 3 caratteri.',
            'name.unique' => 'Questo nome utente è già in uso.',
            'email.required' => 'L\'email è obbligatoria.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'email.unique' => 'Questa email è già in uso.',
        ]);
        
        $user->update($validatedData);
        return redirect()->back()->with('success', 'Profilo aggiornato con successo!');
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id){
        $dl = new DataLayer();
        $user = $dl->getUser($id);
        $friends = $dl->getFriends($user);
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Utente non trovato.');
        }
        
        if (auth()->user()->id != $user->id && auth()->user()->role != 'admin') {
            return redirect()->route('home')->with('error', 'Non hai i permessi per eseguire questa operazione.');
        }

        $isSelfDelete = auth()->user()->id == $user->id;
        
        try {
            foreach($friends as $friend){
                $user->unfriend($friend);
            }
            $user->delete();
            
            if ($isSelfDelete) {
                auth()->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/')->with('success', 'Il tuo account è stato eliminato con successo.');
            }
            
            return redirect()->route('dashboard.index')->with('success', 'Utente ' . $user->name . ' eliminato con successo.');
            
        } catch (\Exception $e) {
            \Log::error('Errore durante l\'eliminazione dell\'utente ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Si è verificato un errore durante l\'eliminazione dell\'utente.');
        }
    }

    public function confirmDestroy($id){
        $dl = new DataLayer();
        $user = $dl->getUser($id);

        if($user !== null){
            return view('user.deleteUser')
                ->with('user',$user);
        }

        return view('errors.404');
    }
    
    public function liveStatus($userID){
        $dl = new DataLayer();
        $user = $dl->getUser($userID);
        
        if (!$user) {
            return response()->json(['error' => 'Utente non trovato'], 404);
        }
        
        $status = Cache::has('user-is-online-' . $user->id) ? 'Online' : 'Offline';
        
        Log::debug(Cache::has('user-is-online-' . $user->id));
        
        $last_seen = $user->last_seen != null 
        ? "Active " . Carbon::parse($user->last_seen)->diffForHumans()
        : "No data";
        
        return response()->json([
            'status' => $status,
            'last_seen' => $last_seen,
        ]);
    }
    
    public function ajaxCheckUser(Request $request)
    {
        $dl = new DataLayer();
        
        $username = $request->input('username');
        $email = $request->input('email');
        
        $userByName = $dl->getUserByName($username);
        $userByEmail = $dl->getUserByEmail($email);
        
        $found = $userByName !== null || $userByEmail !== null;
        
        return response()->json(['found' => $found]);
    }
    
    
    
    
    public function ajaxUpdateSong(Request $request){
        $dl = new DataLayer();
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        
        $user = $dl->getUserbyId($request->input('userID'));
        
        return response()->json([
            'currentlyPlaying' => $spotify->currentlyPlaying($user),
        ]);
    }
    
    public function ajaxGetTopArtists(Request $request){
        $userId = $request->input('userID');
        $timeRange = $request->input('time_range', 'short_term');
        
        $dl = new DataLayer();
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        
        $user = $dl->getUser($userId);
        
        if (!$user || !$user->provider_id) {
            return response()->json(['error' => 'Utente non trovato o account Spotify non connesso'], 404);
        }
        
        try {
            $topArtists = $spotify->topArtists($user, $timeRange);
            $listeningTime = $spotify->listeningTimeByArtistWithPeriod($user, $topArtists);
            
            return response()->json([
                'topArtists' => $topArtists,
                'listeningTime' => $listeningTime,
                'timeRange' => $timeRange
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Errore nel recupero dei top artisti: ' . $e->getMessage());
            return response()->json(['error' => 'Errore nel recupero dei dati'], 500);
        }
    }
    
    public function ajaxGetTopTracks(Request $request)
    {
        $userId = $request->input('userID');
        $timeRange = $request->input('time_range', 'short_term');
        
        $dl = new DataLayer();
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        
        // Trova l'utente
        $user = $dl->getUser($userId);
        
        if (!$user || !$user->provider_id) {
            return response()->json(['error' => 'Utente non trovato o account Spotify non connesso'], 404);
        }
        
        try {
            // Ottieni i top tracks per il time range selezionato
            $topTracks = $spotify->topTracks($user, $timeRange);
            
            return response()->json([
                'topTracks' => $topTracks,
                'timeRange' => $timeRange
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Errore nel recupero dei top tracks: ' . $e->getMessage());
            return response()->json(['error' => 'Errore nel recupero dei dati'], 500);
        }
    }
    
    
}