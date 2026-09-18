<?php

namespace App\Services;

use App\AdminComplaintNotification;
use App\Complaint;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminComplaintNotificationService
{
    const RECENT_LIMIT = 8;

    public function notifyAuthorizedAdmins(Complaint $complaint)
    {
        $admins = User::query()
            ->where('type', '2')
            ->get(['id']);

        DB::transaction(function () use ($complaint, $admins) {
            foreach ($admins as $admin) {
                AdminComplaintNotification::firstOrCreate([
                    'complaint_id' => $complaint->id,
                    'admin_id' => $admin->id,
                ]);
            }
        });
    }

    public function summaryFor($admin)
    {
        if (!$admin || !Gate::forUser($admin)->allows('manage_complaints')) {
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
                ->with(['complaint:id,type,status'])
                ->latest('id')
                ->limit(self::RECENT_LIMIT)
                ->get(),
            'operational_count' => Complaint::query()
                ->whereIn('status', ['new', 'viewed', 'in_progress'])
                ->count(),
        ];
    }

    public function markReadForAdmin($notificationId, $adminId)
    {
        return AdminComplaintNotification::query()
            ->where('id', $notificationId)
            ->where('admin_id', $adminId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function safeFailureLog(Complaint $complaint, \Throwable $exception)
    {
        Log::warning('Complaint notification generation failed', [
            'complaint_id' => $complaint->id,
            'exception' => get_class($exception),
        ]);
    }
}
