<?php

namespace App\Http\Controllers;

use App\Services\PublicComplaintTrackingService;
use App\Services\ComplaintReferenceGenerator;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create(Request $request)
    {
        $type = $request->query('type', 'academic');
        if (!in_array($type, ['academic', 'transport'], true)) {
            $type = 'academic';
        }

        return view('website.complaints', [
            'activeType' => $type,
        ]);
    }

    public function store(Request $request)
    {
        if (is_string($request->input('student_identifier'))) {
            $request->merge(['student_identifier' => trim($request->input('student_identifier'))]);
        }

        $limiter = app(RateLimiter::class);
        $rateKey = 'complaints:' . $request->ip();

        if ($limiter->tooManyAttempts($rateKey, 10)) {
            return redirect()
                ->route('website.complaints')
                ->withInput()
                ->withErrors(['complaint' => __('complaints.validation.rate_limited')]);
        }

        $limiter->hit($rateKey, 600);

        if ($request->filled('website_url')) {
            return redirect()
                ->route('website.complaints')
                ->withInput()
                ->withErrors(['complaint' => __('complaints.validation.spam_rejected')]);
        }

        $requiredFieldMessage = fn (string $field) => __('complaints.validation.required_field', ['field' => $field]);
        $minComplaintMessage = fn (string $field, int $min) => __('complaints.validation.min_complaint', ['field' => $field, 'min' => $min]);

        $validated = $request->validate(
            [
                'type' => ['required', 'in:academic,transport'],
                'student_name' => ['required', 'string', 'max:190'],
                'student_identifier' => ['nullable', 'required_if:type,academic,transport', 'string', 'max:5', 'regex:~\A[0-9]{3}[/-][0-9]\z~'],
                'applicant_name' => ['required', 'string', 'max:190'],
                'phone' => ['required', 'string', 'max:50'],
                'class_name' => ['required', 'string', 'max:190'],
                'section_name' => ['required', 'string', 'max:190'],
                'bus_number' => ['nullable', 'string', 'max:190', 'required_if:type,transport'],
                'complaint_text' => ['required', 'string', 'min:20', 'max:5000'],
            ],
            [
                'type.required' => $requiredFieldMessage(__('complaints.fields.type')),
                'student_name.required' => $requiredFieldMessage(__('complaints.fields.student_name')),
                'student_identifier.required_if' => $requiredFieldMessage(__('complaints.fields.student_identifier')),
                'student_identifier.string' => __('complaints.validation.student_identifier_format'),
                'student_identifier.max' => __('complaints.validation.student_identifier_format'),
                'student_identifier.regex' => __('complaints.validation.student_identifier_format'),
                'applicant_name.required' => $requiredFieldMessage(__('complaints.fields.applicant_name')),
                'phone.required' => $requiredFieldMessage(__('complaints.fields.phone')),
                'class_name.required' => $requiredFieldMessage(__('complaints.fields.class_name')),
                'section_name.required' => $requiredFieldMessage(__('complaints.fields.section_name')),
                'bus_number.required_if' => __('complaints.validation.bus_required'),
                'complaint_text.required' => $requiredFieldMessage(__('complaints.fields.complaint_text')),
                'complaint_text.min' => $minComplaintMessage(__('complaints.fields.complaint_text'), 20),
            ],
            [
                'type' => __('complaints.fields.type'),
                'student_name' => __('complaints.fields.student_name'),
                'student_identifier' => __('complaints.fields.student_identifier'),
                'applicant_name' => __('complaints.fields.applicant_name'),
                'phone' => __('complaints.fields.phone'),
                'class_name' => __('complaints.fields.class_name'),
                'section_name' => __('complaints.fields.section_name'),
                'bus_number' => __('complaints.fields.bus_number'),
                'complaint_text' => __('complaints.fields.complaint_text'),
            ]
        );

        list(, $reference) = app(PublicComplaintTrackingService::class)->submit($validated);
        $request->session()->put('complaint_confirmation', [
            'reference' => $reference,
            'issued_at' => now()->timestamp,
        ]);

        return redirect()
            ->route('website.complaints.confirmation');
    }

    public function confirmation(Request $request)
    {
        $confirmation = $request->session()->get('complaint_confirmation');
        if (!is_array($confirmation) || !isset($confirmation['reference'], $confirmation['issued_at'])
            || now()->timestamp - (int) $confirmation['issued_at'] > 1800) {
            $request->session()->forget('complaint_confirmation');
            return redirect()->route('website.complaints');
        }

        return $this->privateView('website.complaint_confirmation', [
            'reference' => $confirmation['reference'],
        ]);
    }

    public function track()
    {
        return $this->privateView('website.complaint_tracking', ['complaint' => null, 'lookupFailed' => false]);
    }

    public function lookup(Request $request, PublicComplaintTrackingService $tracking)
    {
        $referenceInput = $request->input('reference', '');
        $identifierInput = $request->input('student_identifier', '');
        $reference = is_string($referenceInput) ? strtoupper(trim($referenceInput)) : '';
        $identifier = is_string($identifierInput) ? trim($identifierInput) : '';
        $limiter = app(RateLimiter::class);
        $ipKey = 'complaint-lookup-ip:' . hash('sha256', (string) $request->ip());
        $referenceKey = 'complaint-lookup-ref:' . $tracking->digest($reference);
        if ($limiter->tooManyAttempts($ipKey, 10) || $limiter->tooManyAttempts($referenceKey, 5)) {
            return $this->privateView('website.complaint_tracking', [
                'complaint' => null, 'lookupFailed' => false, 'rateLimited' => true,
            ], 429);
        }
        $limiter->hit($ipKey, 600);
        $limiter->hit($referenceKey, 600);

        $valid = app(ComplaintReferenceGenerator::class)->isSupported($reference)
            && (bool) preg_match('~\A[0-9]{3}[/-][0-9]\z~', $identifier);
        $complaint = $valid ? $tracking->find($reference, $identifier) : null;

        return $this->privateView('website.complaint_tracking', [
            'complaint' => $complaint, 'lookupFailed' => !$complaint,
            'publicStatus' => $complaint ? $tracking->publicStatus($complaint->status) : null,
            'reference' => $complaint ? $reference : null,
        ]);
    }

    private function privateView($name, array $data, $status = 200)
    {
        return response()->view($name, $data, $status)->withHeaders([
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'Referrer-Policy' => 'no-referrer',
            'X-Robots-Tag' => 'noindex, nofollow, noarchive',
        ]);
    }

    // Retired Admin endpoints neither expose complaint data nor enter the officer portal.
    public function index(Request $request) { abort(404); }
    public function show($id) { abort(410); }
    public function markViewed($id) { abort(410); }
    public function archive($id) { abort(410); }
    public function updateStatus(Request $request, $id) { abort(410); }
    public function pollNotifications(Request $request) { abort(410); }
    public function openNotification(Request $request, $notificationId)
    {
        abort(410);
    }
}
