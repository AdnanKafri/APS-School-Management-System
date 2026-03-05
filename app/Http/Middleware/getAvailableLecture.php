<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\teachersController ;
class getAvailableLecture
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
        if(Auth::check() && auth()->user()->type== '1'){
            $scheduleController = new teacherscontroller();
            $teacher_id = $request->user()->teacher_id;
            $available_lecture = $scheduleController->available_schedule($teacher_id);
    
            // Pass the $available_lecture variable to the view
            view()->share('available_lecture888', $available_lecture);

            return $next($request);
        }
            return $next($request);

    }
}
