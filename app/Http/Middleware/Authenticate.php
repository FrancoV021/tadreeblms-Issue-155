<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Class Authenticate.
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route(home_route());
    //     }
    // }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Save the current URL to the intended session key
            session(['url.intended' => $request->fullUrl()]);

            // Redirect to the login route
            // return route(home_route());
            return session()->pull('url.intended', route(home_route()));
        }

        return null; // If JSON is expected, no redirect is needed
    }
}
