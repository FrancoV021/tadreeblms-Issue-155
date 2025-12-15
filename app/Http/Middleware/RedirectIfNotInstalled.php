<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_INSTALLED', false) === false) {
            // allow installer routes
            if ($request->is('install') || $request->is('install/*')) {
                return $next($request); // show installer
            }

            // redirect everything else to installer
            return redirect('/install');
        }

        return $next($request);
    }
}
