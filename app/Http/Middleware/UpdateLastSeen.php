<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function handle(Request $request, Closure $next){
        if (auth()->check()) {
            $user = auth()->user();

            if(!$user->last_seen || $user->last_seen->diffInMinutes(now()) > 5){

                $user->update([
                    'last_seen' => Carbon::now()
                ]);
            }
        }
        
        return $next($request);
    }
}
