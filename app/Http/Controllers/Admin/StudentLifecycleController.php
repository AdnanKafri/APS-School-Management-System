<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Http\Controllers\Controller;
use App\Room;
use App\Student;
use App\StudentLifecycleEvent;
use App\Services\StudentLifecycleService;
use App\Year;
use Illuminate\Http\Request;

class StudentLifecycleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $students = Student::archived()
            ->with(['academicPlacements.room.classes', 'academicPlacements.year'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $like = '%' . addcslashes($search, '%_') . '%';
                    $q->where('first_name', 'like', $like)
                        ->orWhere('last_name', 'like', $like)
                        ->orWhere('first_name_en', 'like', $like)
                        ->orWhere('last_name_en', 'like', $like)
                        ->orWhere('public_record_number', 'like', $like);
                });
            })->orderBy('first_name')->paginate(25)->appends($request->query());

        return view('admin.student_lifecycle_archive', [
            'students' => $students,
            'years' => Year::orderByDesc('id')->get(),
            'classes' => Classe::orderBy('id')->get(),
            'events' => StudentLifecycleEvent::whereIn('student_id', $students->pluck('id'))->latest('occurred_at')->get()->groupBy('student_id'),
        ]);
    }

    public function archive(Request $request, StudentLifecycleService $service)
    {
        $data = $request->validate([
            'student_id' => 'required|integer',
            'reason' => 'required|string|max:1000',
        ]);
        $student = Student::operational()->whereKey($data['student_id'])->firstOrFail();
        try {
            $service->archiveStudent($student, $data['reason'], optional(auth()->user())->id);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', __($e->getMessage()) === $e->getMessage() ? __('student_lifecycle.errors.operation_failed') : __($e->getMessage()));
        }
        return back()->with('success', __('student_lifecycle.messages.archived'));
    }

    public function restore(Request $request, StudentLifecycleService $service)
    {
        $data = $request->validate([
            'student_id' => 'required|integer', 'year_id' => 'required|integer',
            'class_id' => 'required|integer', 'room_id' => 'required|integer',
            'reason' => 'required|string|max:1000',
        ]);
        $student = Student::archived()->whereKey($data['student_id'])->firstOrFail();
        try {
            $service->restoreStudent($student, $data['year_id'], $data['class_id'], $data['room_id'], $data['reason'], optional(auth()->user())->id);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', __($e->getMessage()) === $e->getMessage() ? __('student_lifecycle.errors.operation_failed') : __($e->getMessage()));
        }
        return back()->with('success', __('student_lifecycle.messages.restored'));
    }

    public function rooms(Request $request, $classId)
    {
        $yearId = (int) $request->get('year_id');
        return response()->json(Room::where('class_id', $classId)->where('year_id', $yearId)->orderBy('id')->get(['id', 'name']));
    }
}
