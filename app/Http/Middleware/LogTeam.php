<?php

namespace App\Http\Middleware;

use Closure;

class LogTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Log::info($request->route('team')->id);
        return $next($request);
    }
}
