<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use App\Services\Spotify;
use App\Services\SpotifyTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(){
        
        $dl = new DataLayer();
        $users = $dl->getAllUsers();
        $onlineUsers = $dl->getOnlineUsers();
        $tokenService = new SpotifyTokenService();
        $spotify = new Spotify($tokenService);
        $currTracksUsers = [];
        
        foreach($users as $user){
            if($spotify->currentlyPlaying($user) !== null)
                $currTracksUsers[$user->id] = ($spotify->currentlyPlaying($user))['item'];
        }
        
        return view('user.dashboard')
        ->with('users',$users)
        ->with('online_users',$onlineUsers)
        ->with('currTracksUsers',$currTracksUsers);
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        //
    }
    
    /**
    * Display the specified resource.
    */
    public function show(string $id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, string $id)
    {
        //
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        //
    }
}
