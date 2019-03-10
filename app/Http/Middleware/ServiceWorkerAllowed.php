<?php

namespace App\Http\Middleware;

use Closure;

class ServiceWorkerAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $allowedPath = '/')
    {
        $response = $next($request);
        $response->header('Service-Worker-Allowed', $allowedPath);

        return $response;
    }
}
