<?php

namespace App\Models;

class DataLayer{
    
    public function getUser($userID) {
        $user = User::find($userID);
        return $user;
    }

    public function getUserByName($username) {
        $user = User::where('name',$username)->first();
        return $user;
    }
    public function getUserbyId($userID) {
        $user = User::where('id',$userID)->first();
        return $user;
    }
    
    public function getAllUsers(){
        return User::all();
    }
    
    public function getUserByEmail($email){
        $user = User::where('email',$email)->first();
        
        return $user;
    }
    
    public function getFriends($user){
        if ($user) {
            return $user->getFriends();
        }
        
        return collect();
    }
    
    public function getOnlineFriends($user){
        $friends_list = $this->getFriends($user);
        return $friends_list->where('is_active',true);
    }

    public function getOnlineUsers(){
        return User::where('is_active',true);
    }
    
    public function getOfflineFriends($user){
        $friends_list = $this->getFriends($user);
        return $friends_list->where('is_active',false);
    }
    
    public function getPendingRequests($user){
        
        $requests = $user->getFriendRequests();
        
        $senderIDs = $requests->map(function ($request) {
            return $request->sender_id;
        })->unique()->values()->all();
        
        return User::whereIn('id',$senderIDs)->get();
    }
}
