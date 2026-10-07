<?php

namespace App\Http\Middleware;

use App\Services\ComplaintAccess;
use Closure;
use Illuminate\Support\Facades\Auth;

class ComplaintPortalAccess
{
    public function handle($request, Closure $next, $ability = 'view_complaints')
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('complaint-portal.login');
        }
        if ((string) $user->type === ComplaintAccess::OFFICER_TYPE
            && (!$user->complaint_officer_active || (int) $request->session()->get('complaint_auth_version') !== (int) $user->complaint_auth_version)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('complaint-portal.login')->withErrors(['email' => __('complaint_portal.session_expired')]);
        }
        if ($ability === 'logout') {
            abort_unless((string) $user->type === ComplaintAccess::OFFICER_TYPE, 403);
        } else {
            ComplaintAccess::authorize($user, $ability);
        }
        app()->setLocale('ar');
        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, no-store');
        return $response;
    }
}
