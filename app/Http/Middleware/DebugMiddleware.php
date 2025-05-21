<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class DebugMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('DebugMiddleware called', ['url' => $request->url()]);
        return $next($request);
    }
}
