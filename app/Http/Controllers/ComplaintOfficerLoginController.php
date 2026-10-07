<?php

namespace App\Http\Controllers;

use App\Services\ComplaintAccess;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintOfficerLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        app()->setLocale('ar');
    }

    public function showLoginForm()
    {
        app()->setLocale('ar');
        if (Auth::check()) {
            ComplaintAccess::authorize(Auth::user(), 'view_complaints');
            return redirect()->route('complaint-portal.index');
        }
        return view('complaint_portal.login');
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
