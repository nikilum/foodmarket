<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authorized
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isXmlHttpRequest()) {
            if (Session::exists('user_email') === false)
                abort(403);
            else
                return $next($request);
        } else {
            if (Session::exists('user_email') === false)
                return redirect('login');
            else
                return $next($request);
        }
    }
}
