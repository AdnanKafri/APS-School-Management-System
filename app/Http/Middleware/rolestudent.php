<?php

namespace App\Http\Middleware;

use Closure;
use App\Student;
use Illuminate\Support\Facades\Auth;

class rolestudent
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

        if (Auth::check() && auth()->user()->type == '0') {
            $studentId = auth()->user()->student_id;
            $routeStudentId = $request->route('student_id');
            $inputStudentId = $request->input('student_id');
            $ownsRequestedStudent = ($routeStudentId === null || (int) $routeStudentId === (int) $studentId)
                && ($inputStudentId === null || (int) $inputStudentId === (int) $studentId);

            if ($studentId && $ownsRequestedStudent && Student::operational()->whereKey($studentId)->exists()) {
                return $next($request);
            }

            // Keep the account and credentials intact, but prevent archived
            // students from using current Student Portal operations.
            Auth::logout();
            return redirect('/SMARMANger')->with('error', __('student_lifecycle.errors.account_archived'));
        }
        return redirect('/SMARMANger');

    }
}
