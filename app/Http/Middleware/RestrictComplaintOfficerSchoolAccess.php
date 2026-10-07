<?php

namespace App\Http\Middleware;

use App\Services\ComplaintAccess;
use Closure;

class RestrictComplaintOfficerSchoolAccess
{
    public function handle($request, Closure $next)
    {
        if ($request->is('complaint-portal', 'complaint-portal/*')) {
            app()->setLocale('ar');
        }
        $user = $request->user();
        if ($user && (string) $user->type === ComplaintAccess::OFFICER_TYPE && $request->isMethod('GET')
            && preg_match('~^(?:(?:ar|en)/)?(?:login|adh-login|home)$~', $request->path())) {
            return redirect()->route('complaint-portal.index');
        }
        // Prevent legacy authenticated school entry points from accepting this new type.
        if ($user && (string) $user->type === ComplaintAccess::OFFICER_TYPE
            && $request->path() !== 'SMARMANger'
            && preg_match('~(?:^|/)(?:SMT|SMARMANger|ADHAMMANger)(?:/|$)~', $request->path())) {
            abort(403);
        }
        return $next($request);
    }
}
