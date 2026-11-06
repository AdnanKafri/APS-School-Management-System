<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SchoolLoginNavigation;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Studentfcmtoken;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers { logout as protected frameworkLogout; }

    public function showLoginForm(\Illuminate\Http\Request $request)
    {
        return redirect()->to(app(SchoolLoginNavigation::class)->loginUrl($request));
    }

    public function redirectTo()
    {
        return app(SchoolLoginNavigation::class)->home(auth()->user()) ?: '/SMARMANger';
    }
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ((string) $user->type === \App\Services\ComplaintAccess::OFFICER_TYPE) {
            if (!$user->complaint_officer_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('complaint-portal.login')->withErrors(['email' => __('complaint_portal.invalid_credentials')]);
            }
            $request->session()->put('complaint_auth_version', (int) $user->complaint_auth_version);
            return redirect()->route('complaint-portal.index');
        }
        return redirect()->to(app(SchoolLoginNavigation::class)->afterLogin($request, $user, $this->redirectTo()));
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        // Preserve explicit student logout cleanup, never run it on a login GET.
        if (Auth::check() && (string) Auth::user()->type === '0') {
            Studentfcmtoken::where('s_fk', Auth::user()->student_id)->delete();
        }
        return $this->frameworkLogout($request);
    }
}
