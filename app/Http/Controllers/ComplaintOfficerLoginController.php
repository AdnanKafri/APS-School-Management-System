<?php

namespace App\Http\Controllers;

use App\User;
use App\Services\ComplaintAccess;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ComplaintOfficerLoginController extends Controller
{
    use AuthenticatesUsers { login as protected traitLogin; }

    public function __construct()
    {
        app()->setLocale('ar');
    }

    public function showLoginForm()
    {
        app()->setLocale('ar');
        if (Auth::check()) {
            return ComplaintAccess::allows(Auth::user(), 'view_complaints')
                ? redirect()->route('complaint-portal.index')
                : $this->accessDenied();
        }
        return view('complaint_portal.login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return ComplaintAccess::allows(Auth::user(), 'view_complaints')
                ? redirect()->route('complaint-portal.index')
                : $this->accessDenied();
        }
        return $this->traitLogin($request);
    }

    public function accessDenied()
    {
        app()->setLocale('ar');
        return response()->view('complaint_portal.access_denied', [], 403)
            ->header('Cache-Control', 'private, no-store');
    }

    public function switchAccount(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('complaint-portal.login')->with('status', __('complaint_portal.account_switched'));
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only('email', 'password'), ['type' => ComplaintAccess::OFFICER_TYPE, 'complaint_officer_active' => 1]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate(['email' => 'required|string', 'password' => 'required|string'], __('complaint_portal.validation'), [
            'email' => __('complaint_portal.email'), 'password' => __('complaint_portal.password'),
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user && (string) $user->type === ComplaintAccess::OFFICER_TYPE
            && !$user->complaint_officer_active && Hash::check($request->input('password'), $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages(['email' => __('complaint_portal.inactive_account')]);
        }
        throw \Illuminate\Validation\ValidationException::withMessages(['email' => __('complaint_portal.invalid_credentials')]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => __('complaint_portal.login_throttle', ['seconds' => $this->limiter()->availableIn($this->throttleKey($request))]),
        ])->status(429);
    }

    protected function authenticated(Request $request, $user)
    {
        $request->session()->put('complaint_auth_version', (int) $user->complaint_auth_version);
        if (!ComplaintAccess::allows($user, 'view_complaints')) {
            return $this->accessDenied();
        }
        return redirect()->route('complaint-portal.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('complaint-portal.login');
    }
}
