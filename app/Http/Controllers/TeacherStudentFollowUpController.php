<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Lesson;
use App\Message;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentFollowUp;
use App\Teacher;
use App\Teacher_room_lesson;
use App\Year;
use App\Services\StudentFollowUpService;
use App\Services\TeacherAssignmentPeriodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherStudentFollowUpController extends Controller
{
    private $followUps;

    public function __construct(StudentFollowUpService $followUps)
    {
        $this->followUps = $followUps;
    }

    public function index()
    {
        $teacher = $this->teacherOrFail();
        $year = Year::where('current_year', 1)->first();
        $message = Message::where('teacher_id', $teacher->id)->where('type', 1)->where('view', 0)->count();
        $assignments = collect();

        if ($year) {
            $assignments = Teacher_room_lesson::query()
                ->join('rooms', 'rooms.id', '=', 'teacher_room_lesson.room_id')
                ->join('classes', 'classes.id', '=', 'teacher_room_lesson.class_id')
                ->join('lessons', 'lessons.id', '=', 'teacher_room_lesson.lesson_id')
                ->where('teacher_room_lesson.teacher_id', $teacher->id)
                ->where('teacher_room_lesson.year_id', $year->id)
                ->where('rooms.year_id', $year->id)
                ->select([
                    'teacher_room_lesson.id', 'teacher_room_lesson.teacher_id', 'teacher_room_lesson.lesson_id',
                    'teacher_room_lesson.year_id', 'teacher_room_lesson.class_id', 'teacher_room_lesson.room_id',
                    'classes.name as class_name', 'rooms.name as room_name', 'lessons.name as lesson_name',
                ])
                ->orderBy('classes.name')
                ->orderBy('rooms.name')
                ->orderBy('lessons.name')
                ->get()
                ->unique(function ($assignment) {
                    return implode(':', [$assignment->lesson_id, $assignment->class_id, $assignment->room_id]);
                })
                ->values();
        }

        $now = $this->followUps->schoolNow();
        $assignmentProgress = $year
            ? $this->assignmentProgress($assignments, $teacher->id, $year, $now)
            : [];

        return view('teachers2.student_follow_ups.index', compact(
            'teacher', 'year', 'message', 'assignments', 'assignmentProgress', 'now'
        ));
    }

    public function roster($assignment)
    {
        $teacher = $this->teacherOrFail();
        $year = $this->followUps->activeYearOrFail();
        $assignment = $this->followUps->assignmentForTeacherOrFail($assignment, $teacher->id, $year);
        $periodService = app(TeacherAssignmentPeriodService::class);
        $periodService->openForAssignment($assignment, $this->followUps->schoolNow(), 'on_demand_assignment_sync');

        $room = Room::whereKey($assignment->room_id)->where('year_id', $year->id)->firstOrFail();
        $class = Classe::findOrFail($assignment->class_id);
        $lesson = Lesson::findOrFail($assignment->lesson_id);
        $message = Message::where('teacher_id', $teacher->id)->where('type', 1)->where('view', 0)->count();
        $month = $this->followUps->schoolNow()->copy()->startOfMonth()->toDateString();
        $now = $this->followUps->schoolNow();
        $filter = request('filter', 'all');
        $search = trim((string) request('search', ''));

        $studentsQuery = Student::query()
            ->select('students.*')
            ->join('room_student', 'room_student.student_id', '=', 'students.id')
            ->where('room_student.room_id', $room->id)
            ->where('room_student.year_id', $year->id)
            ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($studentQuery) use ($search) {
                    $studentQuery->where('students.first_name', 'like', '%' . $search . '%')
                        ->orWhere('students.last_name', 'like', '%' . $search . '%');
                });
            })
            ->when($filter === 'needs_follow_up', function ($query) use ($teacher, $lesson, $year, $room, $month, $now) {
                $query->whereNotExists(function ($followUpQuery) use ($teacher, $lesson, $year, $room, $month, $now) {
                    $followUpQuery->select(DB::raw(1))
                        ->from('student_follow_ups')
                        ->whereColumn('student_follow_ups.student_id', 'students.id')
                        ->where('student_follow_ups.teacher_id', $teacher->id)
                        ->where('student_follow_ups.lesson_id', $lesson->id)
                        ->where('student_follow_ups.year_id', $year->id)
                        ->where('student_follow_ups.room_id', $room->id)
                        ->where('student_follow_ups.compliance_month', $month)
                        ->where('student_follow_ups.compliance_half', $now->day <= 15 ? 1 : 2)
                        ->whereNull('student_follow_ups.voided_at');
                });
            })
            ->when($filter === 'complete', function ($query) use ($teacher, $lesson, $year, $room, $month) {
                foreach ([1, 2] as $half) {
                    $query->whereExists(function ($followUpQuery) use ($teacher, $lesson, $year, $room, $month, $half) {
                        $followUpQuery->select(DB::raw(1))
                            ->from('student_follow_ups')
                            ->whereColumn('student_follow_ups.student_id', 'students.id')
                            ->where('student_follow_ups.teacher_id', $teacher->id)
                            ->where('student_follow_ups.lesson_id', $lesson->id)
                            ->where('student_follow_ups.year_id', $year->id)
                            ->where('student_follow_ups.room_id', $room->id)
                            ->where('student_follow_ups.compliance_month', $month)
                            ->where('student_follow_ups.compliance_half', $half)
                            ->whereNull('student_follow_ups.voided_at');
                    });
                }
            })
            ->distinct()
            ->orderBy('students.first_name')
            ->orderBy('students.last_name');

        $students = $studentsQuery
            ->paginate(50)
            ->appends(request()->query());

        $followUpRows = StudentFollowUp::where('teacher_id', $teacher->id)
            ->where('lesson_id', $lesson->id)
            ->where('year_id', $year->id)
            ->where('room_id', $room->id)
            ->where('compliance_month', $month)
            ->whereNull('voided_at')
            ->select('student_id', 'compliance_half', DB::raw('count(*) as total'), DB::raw('max(observed_at) as last_observed_at'))
            ->groupBy('student_id', 'compliance_half')
            ->get();
        $allStatusByStudent = [];
        foreach ($followUpRows as $row) {
            if (!isset($allStatusByStudent[$row->student_id])) {
                $allStatusByStudent[$row->student_id] = ['first' => false, 'second' => false, 'count' => 0, 'last' => null];
            }
            $allStatusByStudent[$row->student_id][$row->compliance_half === 1 ? 'first' : 'second'] = true;
            $allStatusByStudent[$row->student_id]['count'] += (int) $row->total;
            if (!$allStatusByStudent[$row->student_id]['last'] || $row->last_observed_at > $allStatusByStudent[$row->student_id]['last']) {
                $allStatusByStudent[$row->student_id]['last'] = $row->last_observed_at;
            }
        }

        $activeStudentIds = Student::query()
            ->join('room_student', 'room_student.student_id', '=', 'students.id')
            ->where('room_student.room_id', $room->id)
            ->where('room_student.year_id', $year->id)
            ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->distinct()
            ->pluck('students.id');
        $activeStatuses = array_intersect_key($allStatusByStudent, array_flip($activeStudentIds->all()));
        $summary = [
            'total' => $activeStudentIds->count(),
            'complete' => collect($activeStatuses)->filter(function ($status) {
                return $status['first'] && $status['second'];
            })->count(),
            'needs_current' => max(0, $activeStudentIds->count() - collect($activeStatuses)->filter(function ($status) use ($now) {
                return $status[$now->day <= 15 ? 'first' : 'second'];
            })->count()),
        ];
        $statusByStudent = array_intersect_key($allStatusByStudent, array_flip($students->pluck('id')->all()));

        $serverNow = $now->format('Y-m-d H:i');
        return view('teachers2.student_follow_ups.roster', compact(
            'teacher', 'year', 'assignment', 'room', 'class', 'lesson', 'message', 'students',
            'statusByStudent', 'summary', 'month', 'now', 'serverNow', 'filter', 'search'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|integer',
            'student_id' => 'required|integer',
            'level' => 'nullable|in:weak,average,good,excellent',
            'note' => 'nullable|string',
        ]);

        $teacher = $this->teacherOrFail();
        $this->followUps->create(Auth::id(), $teacher->id, $request->assignment_id, $request->student_id, $request->only('level', 'note'));

        return redirect()->back()->with('success', __('student_follow_up.messages.created'));
    }

    public function history($assignment, $student)
    {
        $teacher = $this->teacherOrFail();
        $year = $this->followUps->activeYearOrFail();
        $assignment = $this->followUps->assignmentForTeacherOrFail($assignment, $teacher->id, $year);
        $student = Student::whereKey($student)->firstOrFail();
        $room = Room::whereKey($assignment->room_id)->where('year_id', $year->id)->firstOrFail();
        $class = Classe::findOrFail($assignment->class_id);
        $lesson = Lesson::findOrFail($assignment->lesson_id);
        $isCurrentStudent = Room_student::where('student_id', $student->id)
            ->where('room_id', $assignment->room_id)
            ->where('year_id', $year->id)
            ->exists();
        $hasAuthoredHistory = StudentFollowUp::where('teacher_id', $teacher->id)
            ->where('student_id', $student->id)
            ->where('lesson_id', $assignment->lesson_id)
            ->where('year_id', $assignment->year_id)
            ->where('room_id', $assignment->room_id)
            ->exists();
        if (!$isCurrentStudent && !$hasAuthoredHistory) {
            abort(403, __('student_follow_up.errors.student_not_allowed'));
        }
        $message = Message::where('teacher_id', $teacher->id)->where('type', 1)->where('view', 0)->count();
        $followUps = StudentFollowUp::where('teacher_id', $teacher->id)
            ->where('student_id', $student->id)
            ->where('lesson_id', $assignment->lesson_id)
            ->where('year_id', $assignment->year_id)
            ->where('room_id', $assignment->room_id)
            ->orderByDesc('observed_at')
            ->paginate(20);
        $now = $this->followUps->schoolNow();

        return view('teachers2.student_follow_ups.history', compact(
            'teacher', 'year', 'assignment', 'student', 'room', 'class', 'lesson', 'message', 'followUps', 'now'
        ));
    }

    public function update(Request $request, $followUp)
    {
        $request->validate([
            'level' => 'nullable|in:weak,average,good,excellent',
            'note' => 'nullable|string',
        ]);

        $teacher = $this->teacherOrFail();
        $followUp = StudentFollowUp::whereKey($followUp)->where('teacher_id', $teacher->id)->firstOrFail();
        $this->followUps->update($followUp, Auth::id(), $teacher->id, $request->only('level', 'note'));

        return redirect()->back()->with('success', __('student_follow_up.messages.updated'));
    }

    private function teacherOrFail()
    {
        $user = Auth::user();
        if (!$user || (string) $user->type !== '1' || !$user->teacher_id) {
            abort(403);
        }

        return Teacher::findOrFail($user->teacher_id);
    }

    private function assignmentProgress($assignments, $teacherId, Year $year, $now)
    {
        if ($assignments->isEmpty()) {
            return [];
        }

        $roomIds = $assignments->pluck('room_id')->unique()->values();
        $studentCounts = DB::table('room_student')
            ->join('students', 'students.id', '=', 'room_student.student_id')
            ->where('room_student.year_id', $year->id)
            ->whereIn('room_student.room_id', $roomIds)
            ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->select('room_student.room_id', DB::raw('count(distinct room_student.student_id) as total'))
            ->groupBy('room_student.room_id')
            ->pluck('total', 'room_id');

        $followUps = DB::table('student_follow_ups')
            ->join('room_student', function ($join) {
                $join->on('room_student.student_id', '=', 'student_follow_ups.student_id')
                    ->on('room_student.room_id', '=', 'student_follow_ups.room_id')
                    ->on('room_student.year_id', '=', 'student_follow_ups.year_id');
            })
            ->join('students', 'students.id', '=', 'student_follow_ups.student_id')
            ->where('student_follow_ups.teacher_id', $teacherId)
            ->where('student_follow_ups.year_id', $year->id)
            ->where('student_follow_ups.compliance_month', $now->copy()->startOfMonth()->toDateString())
            ->whereNull('student_follow_ups.voided_at')
            ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->whereIn('student_follow_ups.room_id', $roomIds)
            ->select([
                'student_follow_ups.lesson_id', 'student_follow_ups.room_id', 'student_follow_ups.student_id',
                DB::raw('max(case when student_follow_ups.compliance_half = 1 then 1 else 0 end) as first_done'),
                DB::raw('max(case when student_follow_ups.compliance_half = 2 then 1 else 0 end) as second_done'),
            ])
            ->groupBy('student_follow_ups.lesson_id', 'student_follow_ups.room_id', 'student_follow_ups.student_id')
            ->get()
            ->groupBy(function ($row) {
                return $row->lesson_id . ':' . $row->room_id;
            });

        $progress = [];
        foreach ($assignments as $assignment) {
            $key = $assignment->lesson_id . ':' . $assignment->room_id;
            $rows = $followUps->get($key, collect());
            $total = (int) ($studentCounts[$assignment->room_id] ?? 0);
            $completed = $rows->filter(function ($row) {
                return (int) $row->first_done === 1 && (int) $row->second_done === 1;
            })->count();
            $currentCompleted = $rows->filter(function ($row) use ($now) {
                return (int) ($now->day <= 15 ? $row->first_done : $row->second_done) === 1;
            })->count();

            $progress[$assignment->id] = [
                'total' => $total,
                'complete' => $completed,
                'needs_current' => max(0, $total - $currentCompleted),
            ];
        }

        return $progress;
    }
}
