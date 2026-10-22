<?php

namespace App\Services;

use App\Complaint;
class PublicComplaintTrackingService
{
    public function submit(array $validated)
    {
        return app(ComplaintReferenceGenerator::class)->issue(function ($reference) use ($validated) {
            return app(ComplaintWorkflowService::class)->submit($validated, $this->digest($reference));
        }, 'public_tracking_hash');
    }

    public function digest($reference)
    {
        return hash('sha256', $reference);
    }

    public function find($reference, $studentIdentifier)
    {
        return Complaint::query()
            ->where('source', 'parent')
            ->where('public_tracking_hash', $this->digest($reference))
            ->where('student_identifier', $studentIdentifier)
            ->first();
    }

    public function publicStatus($status)
    {
        $key = in_array($status, ['new', 'viewed', 'in_progress', 'resolved', 'archived'], true)
            ? $status : 'unknown';

        return __('complaint_tracking.status.' . $key);
    }
}
