<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Log;

class SessionCachedAuth
{
    public function handle($request, Closure $next)
    {
        Log::info('SessionCachedAuth called');
        if ($request->session()->has('user_data')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
