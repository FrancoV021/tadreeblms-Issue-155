<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInstallation
{
    public function handle(Request $request, Closure $next)
    {
        
        // If installer not completed
        if (!file_exists(base_path('.env')) || env('APP_INSTALLED', false) === false || env('APP_INSTALLED', false) === 'false') {

            // Allow access to installer only
            if (!$request->is('install') && !$request->is('install/*')) {
                return redirect('/install');
            }
        }

        return $next($request);
    }
}
