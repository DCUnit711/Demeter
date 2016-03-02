<?php

namespace App\Http\Middleware;

use Closure;

class RequestLogger
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
	\Log::info($request->ip()." accessed ".$request->path()." using method ".$request->method());
        return $next($request);
    }
}
