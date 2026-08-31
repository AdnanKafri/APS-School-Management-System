<?php

namespace App\Http\Middleware;

use App\Student;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureOperationalStudent
{
    public function handle($request, Closure $next)
    {
        $studentId = $request->route('student_id');
        if ($studentId === null) {
            $studentId = $request->input('student_id');
        }

        if ($studentId !== null && !Student::operational()->whereKey($studentId)->exists()) {
            return response()->json([
                'status' => false,
                'code' => 'STUDENT_NOT_OPERATIONAL',
                'message' => __('student_lifecycle.errors.account_archived'),
            ], 403);
        }

        // A logged-in student may only address their own student id.
        if (Auth::check() && (string) auth()->user()->type === '0'
            && $studentId !== null
            && (int) $studentId !== (int) auth()->user()->student_id) {
            return response()->json([
                'status' => false,
                'code' => 'STUDENT_FORBIDDEN',
                'message' => __('student_lifecycle.errors.student_forbidden'),
            ], 403);
        }

        return $next($request);
    }
}
