<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class isFriendWith
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
    public function handle(Request $request, Closure $next){
        $currentUser = auth()->user();
        $userId = $request->route('user') ?? $request->route('id');
        
        if ($currentUser->id == $userId) {
            return $next($request);
        }

        $targetUser = User::where('id',$userId)->first();
        
        if (!$targetUser) {
            return redirect()->back()
            ->with('error', 'Utente non trovato.');
        }
        
        if (!$currentUser->isFriendWith($targetUser) || $currentUser->role !== 'admin') {
            return redirect()->back()
            ->with('error', 'Non hai i permessi per visualizzare questo profilo. Devi essere amico di questo utente.');
        }
        
        return $next($request);
    }
}
