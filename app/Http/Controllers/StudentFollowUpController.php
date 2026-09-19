<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Room;
use App\Room_student;
use App\School_data;
use App\Student;
use App\StudentAcademicPlacement;
use App\StudentFollowUp;
use App\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFollowUpController extends Controller
{
    public function index(Request $request)
    {
        $student = Student::operational()
            ->with('details')
            ->findOrFail((int) Auth::user()->student_id);
        $year = Year::where('current_year', 1)->first();
        $room = null;

        if ($year) {
            $placement = StudentAcademicPlacement::where('student_id', $student->id)
                ->where('year_id', $year->id)
                ->where('status', StudentAcademicPlacement::STATUS_ACTIVE)
                ->orderByDesc('id')
                ->first();

            if ($placement && $placement->room_id) {
                $room = Room::whereKey($placement->room_id)
                    ->where('year_id', $year->id)
                    ->first();
            }

            if (!$room) {
                $roomStudent = Room_student::where('student_id', $student->id)
                    ->where('year_id', $year->id)
                    ->orderByDesc('id')
                    ->first();
                $room = $roomStudent
                    ? Room::whereKey($roomStudent->room_id)->where('year_id', $year->id)->first()
                    : null;
            }
        }

        $roomId = optional($room)->id;
        $class = optional($room)->classes;
        $school_data = School_data::first();
        $followUps = collect();
        $availableMonths = collect();
        $subjects = collect();
        $selectedMonth = Carbon::now('Asia/Damascus')->format('Y-m');
        $selectedLessonId = null;
        $pagination = null;

        if ($year) {
            $base = StudentFollowUp::query()
                ->where('student_id', $student->id)
                ->where('year_id', $year->id)
                ->whereNull('voided_at');

            $availableMonths = (clone $base)
                ->select('compliance_month')
                ->distinct()
                ->orderByDesc('compliance_month')
                ->pluck('compliance_month')
                ->map(function ($month) {
                    return Carbon::parse($month)->format('Y-m');
                })
                ->values();

            $monthOptions = (clone $availableMonths)->push($selectedMonth)->unique()->values();
            $requestedMonth = trim((string) $request->query('month', $selectedMonth));
            if (preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $requestedMonth)
                && $monthOptions->contains($requestedMonth)) {
                $selectedMonth = $requestedMonth;
            }

            $subjectIds = (clone $base)->select('lesson_id')->distinct()->pluck('lesson_id')->filter();
            $subjects = $subjectIds->isEmpty()
                ? collect()
                : Lesson::whereIn('id', $subjectIds)->orderBy('name')->get();

            $requestedLessonId = $request->query('lesson_id');
            if (is_scalar($requestedLessonId) && ctype_digit((string) $requestedLessonId)
                && $subjects->contains('id', (int) $requestedLessonId)) {
                $selectedLessonId = (int) $requestedLessonId;
            }

            $monthStart = Carbon::createFromFormat('Y-m', $selectedMonth, 'Asia/Damascus')->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $pagination = (clone $base)
                ->with(['teacher', 'lesson', 'year', 'term', 'room', 'classRoom'])
                ->whereBetween('compliance_month', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->when($selectedLessonId, function ($query) use ($selectedLessonId) {
                    $query->where('lesson_id', $selectedLessonId);
                })
                ->orderByDesc('observed_at')
                ->orderByDesc('id')
                ->paginate(30)
                ->appends($request->query());

            $followUps = $pagination->getCollection()->groupBy(function ($followUp) {
                return optional($followUp->lesson)->id ?: 'unknown';
            });
        }

        return view('students.student_follow_ups.index', compact(
            'school_data', 'student', 'year', 'room', 'roomId', 'class', 'followUps',
            'availableMonths', 'subjects', 'selectedMonth', 'selectedLessonId', 'pagination'
        ));
    }
}
