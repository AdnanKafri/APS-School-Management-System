<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class roleteacher
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

        if (!Auth::check()) return app(\App\Services\SchoolLoginNavigation::class)->guest($request);
        if(Auth::check() && auth()->user()->type== '1'){
            return $next($request);
        }
       return redirect('/SMARMANger');

    }
}
