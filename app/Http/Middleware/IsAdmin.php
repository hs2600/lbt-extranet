<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (!auth()->check() || (auth()->user()->email != 'horacio@lunadabaytile.com' && auth()->user()->email != 'oscar@lunadabaytile.com' && auth()->user()->email != 'hs2600@gmail.com')
        ) {
            return redirect(route('dashboard'));
        }

        return $next($request);
    }
}