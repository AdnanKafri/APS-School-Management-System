<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        Complaint::create([
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

        if (in_array($statusFilter, ['new', 'viewed', 'archived'], true)) {
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

        if ($complaint->status !== 'archived') {
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
}
