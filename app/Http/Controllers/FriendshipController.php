<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use App\Models\User;
use App\Services\Spotify;
use App\Services\SpotifyTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FriendshipController extends Controller{
    public function index(){
        $dl = new DataLayer();
        $friends_list = $dl->getFriends(auth()->user());
        $onlineFriends = $dl->getOnlineFriends(auth()->user());
        $users_list = $dl->getAllUsers();
        $pending_requests = $dl->getPendingRequests(auth()->user());
        $currTracksFriends = [];
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        
        
        foreach($friends_list as $friend){
            if($spotify->currentlyPlaying($friend) !== null)
                $currTracksFriends[$friend->id] = ($spotify->currentlyPlaying($friend))['item'];
        }
        
        if($friends_list !== null){
            return view('user.friends')
            ->with('friends_list',$friends_list)
            ->with('onlineFriendsCount',$onlineFriends->count())
            ->with('users_list',$users_list)
            ->with('pending_requests',$pending_requests)
            ->with('currTrackFriends',$currTracksFriends);
        }
        
        return view('user.friends');
    }
    
    public function sendRequest(Request $request){
        $currentUser = auth()->user();
        $targetUser = User::findOrFail($request->user_id);
        
        if ($currentUser->isFriendWith($targetUser)) {
            return redirect()->back()->with('info', 'Sei già amico con questo utente.');
        }
        
        if ($currentUser->hasSentFriendRequestTo($targetUser)) {
            return redirect()->back()->with('info', 'Richiesta di amicizia già inviata.');
        }
        
        if ($currentUser->hasFriendRequestFrom($targetUser)) {
            return redirect()->back()->with('info', 'Questo utente ti ha già inviato una richiesta di amicizia.');
        }
        
        $currentUser->befriend($targetUser);
        
        return redirect()->back()->with('success', 'Richiesta di amicizia inviata con successo!');
    }
    
    public function acceptRequest(Request $request) {
        $user = auth()->user();
        $dl = new DataLayer();
        $targetUser = $dl->getUser($request->id);
        
        if (!$targetUser) {
            return redirect()->back()->with('error', 'Utente non trovato.');
        }
        
        // Verifica se esiste effettivamente una richiesta pendente
        if (!$user->hasFriendRequestFrom($targetUser)) {
            return redirect()->back()->with('error', 'Nessuna richiesta di amicizia trovata.');
        }
        
        $result = $user->acceptFriendRequest($targetUser);
        
        if ($result) {
            return redirect()->back()->with('success', 'Richiesta di amicizia accettata!');
        } else {
            return redirect()->back()->with('error', 'Errore nell\'accettazione della richiesta.');
        }
    }
    
    public function declineRequest(Request $request){
        $user = auth()->user();
        $dl = new DataLayer();
        $targetUser = $dl->getUser($request->id);
        
        if (!$targetUser) {
            return redirect()->back()->with('error', 'Utente non trovato.');
        }
        
        if (!$user->hasFriendRequestFrom($targetUser)) {
            return redirect()->back()->with('error', 'Nessuna richiesta di amicizia trovata.');
        }
        
        $result = $user->acceptFriendRequest($targetUser);
        
        if ($result) {
            return redirect()->back()->with('success', 'Richiesta di amicizia rifiutata');
        } else {
            return redirect()->back()->with('error', 'Errore nel rifiuto della richiesta.');
        }
    }
}
