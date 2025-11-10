<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isUserOnline {
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function handle(Request $request, Closure $next){
        
        $expiresAt = Carbon::now()->addMinutes(1);
        Cache::put('user-is-online-' . auth()->user()->id, true, $expiresAt);
        
        
        return $next($request);
    }
}
