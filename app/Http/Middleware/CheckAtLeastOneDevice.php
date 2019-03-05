<?php

namespace App\Http\Middleware;

use Closure;

class CheckAtLeastOneDevice
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
        if ($request->user() && $request->user()->devices()->count() < 1) {
            return redirect()->route('setup.index');
        }


        return $next($request);
    }
}
