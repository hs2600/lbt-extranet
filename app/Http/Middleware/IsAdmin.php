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
        //check if user is logged in
        //check if user is admin
        //check if user is internal (is using LBT email address)
        //If any condition is false, send user to login page. If user is already logged in, they will be redirectd to main page (collections)
        if (!auth()->check() || (auth()->user()->role != 'admin' || strpos(Auth::user()->email, "lunadabaytile.com") === false)
        ) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}