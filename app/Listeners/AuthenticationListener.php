<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\User; // Make sure to import your User model
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon; // Use Carbon for timestamps

class AuthenticationListener
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login|Registered $event)
    {
        if ($event->user) {
            User::where('id', $event->user->id)->update([
                'last_seen' => Carbon::now(),
            ]);
        }
    }
}