<?php

namespace App\Http\Controllers;

use App\Services\ComplaintWorkflowService;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class StaffFeedbackController extends Controller
{
    public function create(Request $request)
    {
        app()->setLocale($request->segment(1));
        return view('website.staff_feedback');
    }

    public function store(Request $request, ComplaintWorkflowService $workflow)
    {
        app()->setLocale($request->segment(1));
        $limiter = app(RateLimiter::class);
        $rateKey = 'complaints:' . $request->ip();
        if ($limiter->tooManyAttempts($rateKey, 10)) {
            return redirect()->to($request->url())->withInput()->withErrors(['feedback' => __('complaints.validation.rate_limited')]);
        }
        $limiter->hit($rateKey, 600);

        if ($request->filled('website_url')) {
            return redirect()->to($request->url())->withInput()->withErrors(['feedback' => __('complaints.validation.spam_rejected')]);
        }

        $validated = $request->validate([
            'staff_name' => ['required', 'string', 'max:190'],
            'phone' => ['required', 'string', 'max:50'],
            'complaint_text' => ['required', 'string', 'min:20', 'max:5000'],
        ], [], [
            'staff_name' => __('staff_feedback.name'),
            'phone' => __('staff_feedback.phone'),
            'complaint_text' => __('staff_feedback.message'),
        ]);

        $workflow->submitStaff($validated);
        return redirect()->route('website.staff_feedback.' . app()->getLocale())->with('success', __('staff_feedback.success'));
    }
}
