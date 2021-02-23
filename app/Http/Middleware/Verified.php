<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Verified
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
            if (Session::exists('verified') === false) {
                abort(403);
            } else
                return $next($request);
        } else {
            if (Session::exists('verified') === false)
                return redirect('verify');
            else
                return $next($request);
        }
    }
}
