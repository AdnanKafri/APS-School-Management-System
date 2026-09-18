<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\AdminComplaintNotification;
use App\Services\AdminComplaintNotificationService;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                'applicant_name' => __('complaints.fields.applicant_name'),
                'phone' => __('complaints.fields.phone'),
                'class_name' => __('complaints.fields.class_name'),
                'section_name' => __('complaints.fields.section_name'),
                'bus_number' => __('complaints.fields.bus_number'),
                'complaint_text' => __('complaints.fields.complaint_text'),
            ]
        );

        $complaint = Complaint::create([
            'type' => $validated['type'],
            'student_name' => $validated['student_name'],
            'applicant_name' => $validated['applicant_name'],
            'phone' => $validated['phone'],
            'class_name' => $validated['class_name'],
            'section_name' => $validated['section_name'],
            'bus_number' => $validated['type'] === 'transport' ? ($validated['bus_number'] ?? null) : null,
            'complaint_text' => $validated['complaint_text'],
            'status' => 'new',
            'viewed_at' => null,
            'archived_at' => null,
        ]);

        try {
            app(AdminComplaintNotificationService::class)->notifyAuthorizedAdmins($complaint);
        } catch (\Throwable $exception) {
            app(AdminComplaintNotificationService::class)->safeFailureLog($complaint, $exception);
        }

        return redirect()
            ->route('website.complaints')
            ->with('success', __('complaints.success'));
    }

    public function index(Request $request)
    {
        app()->setLocale('ar');

        $typeFilter = $request->query('type', 'all');
        $statusFilter = $request->query('status', 'all');

        $query = Complaint::query();

        if (in_array($typeFilter, ['academic', 'transport'], true)) {
            $query->where('type', $typeFilter);
        }

        if (in_array($statusFilter, ['new', 'viewed', 'in_progress', 'resolved', 'archived'], true)) {
            $query->where('status', $statusFilter);
        }

        $complaints = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        $baseCounts = Complaint::query();
        $counts = [
            'all' => (clone $baseCounts)->count(),
            'academic' => (clone $baseCounts)->where('type', 'academic')->count(),
            'transport' => (clone $baseCounts)->where('type', 'transport')->count(),
            'new' => (clone $baseCounts)->where('status', 'new')->count(),
            'viewed' => (clone $baseCounts)->where('status', 'viewed')->count(),
            'in_progress' => (clone $baseCounts)->where('status', 'in_progress')->count(),
            'resolved' => (clone $baseCounts)->where('status', 'resolved')->count(),
            'archived' => (clone $baseCounts)->where('status', 'archived')->count(),
        ];

        return view('admin.complaints.index', [
            'complaints' => $complaints,
            'counts' => $counts,
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function show($id)
    {
        app()->setLocale('ar');

        $complaint = Complaint::findOrFail($id);

        return view('admin.complaints.show', [
            'complaint' => $complaint,
        ]);
    }

    public function markViewed($id)
    {
        app()->setLocale('ar');

        $complaint = Complaint::findOrFail($id);

        if ($complaint->status === 'new') {
            $complaint->status = 'viewed';
            $complaint->viewed_at = $complaint->viewed_at ?: Carbon::now();
            $complaint->save();
        }

        return redirect()
            ->route('admin.complaints.show', $complaint->id)
            ->with('success', __('complaints.messages.marked_viewed'));
    }

    public function archive($id)
    {
        app()->setLocale('ar');

        $complaint = Complaint::findOrFail($id);
        $complaint->status = 'archived';
        $complaint->viewed_at = $complaint->viewed_at ?: Carbon::now();
        $complaint->archived_at = Carbon::now();
        $complaint->save();

        return redirect()
            ->route('admin.complaints.show', $complaint->id)
            ->with('success', __('complaints.messages.archived'));
    }

    public function updateStatus(Request $request, $id)
    {
        app()->setLocale('ar');

        $complaint = Complaint::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['viewed', 'in_progress', 'resolved'], true)) {
            return redirect()
                ->route('admin.complaints.show', $complaint->id)
                ->withErrors(['status' => __('complaints.messages.invalid_status')]);
        }

        if (!$complaint->canTransitionTo($status)) {
            return redirect()
                ->route('admin.complaints.show', $complaint->id)
                ->withErrors(['status' => __('complaints.messages.invalid_transition')]);
        }

        DB::transaction(function () use ($complaint, $status) {
            $complaint->status = $status;
            if ($status === 'viewed') {
                $complaint->viewed_at = $complaint->viewed_at ?: Carbon::now();
            }
            if (in_array($status, ['in_progress', 'resolved'], true)) {
                $complaint->handled_by = $complaint->handled_by ?: auth()->id();
            }
            if ($status === 'resolved') {
                $complaint->resolved_at = Carbon::now();
            }
            $complaint->save();
        });

        return redirect()
            ->route('admin.complaints.show', $complaint->id)
            ->with('success', __('complaints.messages.status_updated'));
    }

    public function pollNotifications(Request $request)
    {
        $summary = app(AdminComplaintNotificationService::class)
            ->summaryFor($request->user());

        return response()->json([
            'unread_count' => $summary['unread_count'],
            'recent' => $summary['recent']->map(function (AdminComplaintNotification $notification) {
                return [
                    'id' => $notification->id,
                    'complaint_id' => $notification->complaint_id,
                    'type' => optional($notification->complaint)->type,
                    'status' => optional($notification->complaint)->status,
                    'read' => !is_null($notification->read_at),
                    'created_at' => optional($notification->created_at)->toIso8601String(),
                    'url' => route('admin.complaints.notifications.open', $notification->id),
                ];
            })->values(),
        ]);
    }

    public function openNotification(Request $request, $notificationId)
    {
        $notification = AdminComplaintNotification::query()
            ->where('id', $notificationId)
            ->where('admin_id', $request->user()->id)
            ->firstOrFail();

        app(AdminComplaintNotificationService::class)
            ->markReadForAdmin($notification->id, $request->user()->id);

        return redirect()->route('admin.complaints.show', $notification->complaint_id);
    }
}
