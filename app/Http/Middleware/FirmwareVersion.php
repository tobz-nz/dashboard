<?php

namespace App\Http\Middleware;

use Closure;

class FirmwareVersion
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
        $response = $next($request);

        $response->header('X-Current-Firmware', app('cache')->get('firmware-version'));

        return $response;
    }
}
