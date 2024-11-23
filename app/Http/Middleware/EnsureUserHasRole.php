<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserHasRole
{
    public function handle($request, Closure $next)
    {
        Log::info('Middleware Check', [
            'Auth::check()' => Auth::check(),
            'Auth::id()' => Auth::id(),
            'Auth::user()' => Auth::user(),
        ]);

        $user = Auth::user();

        if (!$user || !$user->role) {
            Log::info('Middleware Role Check', [
                'Auth::user' => Auth::user(),
                'Auth::user()->role' => Auth::user()?->role,
            ]);

            return redirect()->route('login')->withErrors('You do not have access to this page.');
        }

        return $next($request);
    }
}
