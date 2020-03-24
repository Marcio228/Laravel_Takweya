<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
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
        if (Sentinel::check() && Sentinel::inRole('admin')) {
                return $next($request);
        } else {
            Session::put('loginRedirect', $request->url());
            return redirect('/login');
        }
    }
}
