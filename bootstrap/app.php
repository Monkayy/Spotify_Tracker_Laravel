<?php

use App\Http\Middleware\isAdminMiddleware;
use App\Http\Middleware\isFriendWith;
use App\Http\Middleware\isRegisteredUserMiddleware;
use App\Http\Middleware\isUserOnline;
use App\Http\Middleware\LastSeenMiddleware;
use App\Http\Middleware\UpdateLastSeen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        //api: __DIR__.'/routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAdmin' => isAdminMiddleware::class,
            'isRegisteredUser' => isRegisteredUserMiddleware::class,
            'updateLastSeen' => UpdateLastSeen::class,
            'isUserOnline' => isUserOnline::class,
            'isFriendWith' => isFriendWith::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
