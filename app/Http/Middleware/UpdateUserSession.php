<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Use this correct class for type hinting

class UpdateUserSession
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            // Update the user's session status to 'Offline'
            $user->update([
                'session' => 'Offline',
            ]);
        }

        return $next($request);
    }
}
