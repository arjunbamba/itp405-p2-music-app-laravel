<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBlockedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Create middleware here, register middleware in kernel, attach to routes
        // if user that's logged in is blocked, we're going to redirect to blocked page
        if (Auth::user()->is_blocked) {
            return redirect()->route('blocked');
        }

        return $next($request);
    }
}
