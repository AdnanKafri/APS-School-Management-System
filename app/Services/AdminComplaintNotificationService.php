<?php

namespace App\Services;

use App\AdminComplaintNotification;
use App\Complaint;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminComplaintNotificationService
{
    const RECENT_LIMIT = 8;

    public function notifyAuthorizedOfficers(Complaint $complaint)
    {
        $officers = User::query()
            ->where('type', ComplaintAccess::OFFICER_TYPE)
            ->where('complaint_officer_active', 1)
            ->with('role')->get()
            ->filter(function ($user) {
                return ComplaintAccess::allows($user, 'view_complaints') && ComplaintAccess::allows($user, 'receive_complaint_notifications');
            });

        DB::transaction(function () use ($complaint, $officers) {
            foreach ($officers as $officer) {
                AdminComplaintNotification::firstOrCreate([
                    'complaint_id' => $complaint->id,
                    'admin_id' => $officer->id,
                ]);
            }
        });
    }

    public function summaryFor($admin)
    {
        if (!ComplaintAccess::allows($admin, 'view_complaints') || !ComplaintAccess::allows($admin, 'receive_complaint_notifications')) {
            return [
                'unread_count' => 0,
                'recent' => collect(),
                'operational_count' => 0,
            ];
        }

        $base = AdminComplaintNotification::query()->where('admin_id', $admin->id);

        return [
            'unread_count' => (clone $base)->whereNull('read_at')->count(),
            'recent' => (clone $base)
                ->with(['complaint:id,type,status,student_name'])
                ->latest('id')
                ->limit(self::RECENT_LIMIT)
                ->get(),
            'operational_count' => Complaint::query()
                ->whereIn('status', ['new', 'viewed', 'in_progress'])
                ->count(),
        ];
    }

    protected function markReadForAdmin($notificationId, $adminId)
    {
        return AdminComplaintNotification::query()
            ->where('id', $notificationId)
            ->where('admin_id', $adminId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function openFor($actor, $notificationId)
    {
        ComplaintAccess::authorize($actor, 'view_complaints');
        ComplaintAccess::authorize($actor, 'receive_complaint_notifications');
        $receipt = AdminComplaintNotification::where('admin_id', $actor->id)->findOrFail($notificationId);
        Complaint::findOrFail($receipt->complaint_id);
        $this->markReadForAdmin($receipt->id, $actor->id);
        return $receipt->complaint_id;
    }

    public function safeFailureLog(Complaint $complaint, \Throwable $exception)
    {
        Log::warning('Complaint notification generation failed', [
            'complaint_id' => $complaint->id,
            'exception' => get_class($exception),
        ]);
    }
}
