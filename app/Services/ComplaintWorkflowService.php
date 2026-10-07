<?php

namespace App\Services;

use App\Complaint;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ComplaintWorkflowService
{
    public function submit(array $validated)
    {
        $complaint = Complaint::create([
            'type' => $validated['type'], 'student_name' => $validated['student_name'],
            'student_identifier' => $validated['student_identifier'] ?? null,
            'applicant_name' => $validated['applicant_name'], 'phone' => $validated['phone'],
            'class_name' => $validated['class_name'], 'section_name' => $validated['section_name'],
            'bus_number' => $validated['type'] === 'transport' ? ($validated['bus_number'] ?? null) : null,
            'complaint_text' => $validated['complaint_text'], 'status' => 'new',
            'viewed_at' => null, 'archived_at' => null,
        ]);
        try {
            app(AdminComplaintNotificationService::class)->notifyAuthorizedOfficers($complaint);
        } catch (\Throwable $exception) {
            app(AdminComplaintNotificationService::class)->safeFailureLog($complaint, $exception);
        }
        return $complaint;
    }

    public function listing($actor, array $filters)
    {
        ComplaintAccess::authorize($actor, 'view_complaints');
        $query = Complaint::query();
        foreach (['type' => ['academic', 'transport'], 'status' => ['new', 'viewed', 'in_progress', 'resolved', 'archived']] as $field => $values) {
            if (in_array($filters[$field] ?? '', $values, true)) {
                $query->where($field, $filters[$field]);
            }
        }
        return $query->orderByDesc('id');
    }

    public function detail($actor, $id)
    {
        ComplaintAccess::authorize($actor, 'view_complaints');
        return Complaint::with('handledBy')->findOrFail($id);
    }

    public function transition($actor, $id, $status)
    {
        ComplaintAccess::authorize($actor, 'view_complaints');
        ComplaintAccess::authorize($actor, $status === 'archived' ? 'archive_complaints' : 'manage_complaints');
        return DB::transaction(function () use ($actor, $id, $status) {
            $complaint = Complaint::whereKey($id)->lockForUpdate()->firstOrFail();
            if (!in_array($status, ['viewed', 'in_progress', 'resolved', 'archived'], true)) {
                throw ValidationException::withMessages(['status' => __('complaints.messages.invalid_status')]);
            }
            if ($status === $complaint->status) {
                return $complaint; // Retrying a completed action is idempotent.
            }
            if ($status !== 'archived' && (!in_array($status, ['viewed', 'in_progress', 'resolved'], true) || !$complaint->canTransitionTo($status))) {
                throw ValidationException::withMessages(['status' => __('complaints.messages.invalid_transition')]);
            }
            $previousStatus = $complaint->status;
            $previousHandler = $complaint->handled_by;
            $time = now();
            $complaint->status = $status;
            $complaint->viewed_at = $complaint->viewed_at ?: $time;
            if (in_array($status, ['in_progress', 'resolved'], true)) {
                $complaint->handled_by = $complaint->handled_by ?: $actor->id;
            }
            if ($status === 'resolved') {
                $complaint->resolved_at = $time;
            }
            if ($status === 'archived') {
                $complaint->archived_at = $time;
            }
            $complaint->save();
            DB::table('complaint_action_audits')->insert([
                'complaint_id' => $complaint->id, 'actor_id' => $actor->id,
                'action' => $status === 'archived' ? 'archive' : 'status_change',
                'previous_status' => $previousStatus, 'new_status' => $status,
                'previous_handler_id' => $previousHandler, 'new_handler_id' => $complaint->handled_by,
                'occurred_at' => $time,
            ]);
            return $complaint;
        }, 3);
    }
}
