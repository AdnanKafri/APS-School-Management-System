<?php

namespace App\Http\Controllers;

use App\Services\ComplaintWorkflowService;
use App\Services\ComplaintReferenceGenerator;
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

        list(, $reference) = app(ComplaintReferenceGenerator::class)->issue(function ($reference) use ($workflow, $validated) {
            return $workflow->submitStaff($validated, $reference);
        }, ['staff_reference', 'public_tracking_hash']);
        $request->session()->put('staff_feedback_confirmation', [
            'reference' => $reference,
            'issued_at' => now()->timestamp,
        ]);

        return redirect()->route('website.staff_feedback.confirmation.' . app()->getLocale());
    }

    public function confirmation(Request $request)
    {
        app()->setLocale($request->segment(1));
        $confirmation = $request->session()->get('staff_feedback_confirmation');
        if (!is_array($confirmation) || !isset($confirmation['reference'], $confirmation['issued_at'])
            || now()->timestamp - (int) $confirmation['issued_at'] > 1800) {
            $request->session()->forget('staff_feedback_confirmation');
            return redirect()->route('website.staff_feedback.' . app()->getLocale());
        }

        return response()->view('website.staff_feedback_confirmation', [
            'reference' => $confirmation['reference'],
        ])->withHeaders([
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'Referrer-Policy' => 'no-referrer',
            'X-Robots-Tag' => 'noindex, nofollow, noarchive',
        ]);
    }
}
