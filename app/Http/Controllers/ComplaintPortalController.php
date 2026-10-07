<?php

namespace App\Http\Controllers;

use App\Services\ComplaintWorkflowService;
use App\Services\AdminComplaintNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintPortalController extends Controller
{
    public function index(Request $request, ComplaintWorkflowService $workflow)
    {
        $filters = $request->only('type', 'status');
        return view('complaint_portal.index', [
            'complaints' => $workflow->listing($request->user(), $filters)->paginate(15)->appends($filters),
            'typeFilter' => $filters['type'] ?? 'all', 'statusFilter' => $filters['status'] ?? 'all',
            'notifications' => app(AdminComplaintNotificationService::class)->summaryFor($request->user()),
        ]);
    }

    public function show(Request $request, $id, ComplaintWorkflowService $workflow)
    {
        return view('complaint_portal.show', [
            'notifications' => app(AdminComplaintNotificationService::class)->summaryFor($request->user()),
            'complaint' => $workflow->detail($request->user(), $id),
            'audits' => DB::table('complaint_action_audits as a')->leftJoin('users as u', 'u.id', '=', 'a.actor_id')
                ->where('a.complaint_id', $id)->orderByDesc('a.id')->select('a.*', 'u.name as actor_name')->get(),
        ]);
    }

    public function status(Request $request, $id, ComplaintWorkflowService $workflow)
    {
        $data = $request->validate(['status' => 'required|in:viewed,in_progress,resolved'], [
            'status.required' => __('complaints.messages.invalid_status'), 'status.in' => __('complaints.messages.invalid_status'),
        ]);
        $workflow->transition($request->user(), $id, $data['status']);
        return redirect()->route('complaint-portal.show', $id)->with('success', __('complaints.messages.status_updated'));
    }

    public function archive(Request $request, $id, ComplaintWorkflowService $workflow)
    {
        $workflow->transition($request->user(), $id, 'archived');
        return redirect()->route('complaint-portal.show', $id)->with('success', __('complaints.messages.archived'));
    }

    public function openNotification(Request $request, $notificationId)
    {
        $complaintId = app(AdminComplaintNotificationService::class)->openFor($request->user(), $notificationId);
        return redirect()->route('complaint-portal.show', $complaintId);
    }

    public function notifications(Request $request)
    {
        $summary = app(AdminComplaintNotificationService::class)->summaryFor($request->user());
        return response()->json(['unread_count' => $summary['unread_count'], 'recent' => $summary['recent']->map(function ($receipt) {
            return ['id' => $receipt->id, 'complaint_id' => $receipt->complaint_id, 'read' => $receipt->read_at !== null];
        })]);
    }
}
