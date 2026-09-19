<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Lesson;
use App\Room;
use App\School_data;
use App\Student;
use App\StudentFollowUp;
use App\Teacher;
use App\TeacherAssignmentPeriod;
use App\Teacher_room_lesson;
use App\Year;
use App\Services\StudentFollowUpService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminStudentFollowUpController extends Controller
{
    public function index(Request $request)
    {
        $year = $this->activeYearOrFail();
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $teacherRows = $this->teacherSummaryQuery($year, $month, $now)->get();
        $summary = $this->landingSummary($teacherRows, $year, $month);
        $attention = $teacherRows->filter(function ($row) {
            return (int) $row->due_missing_contexts > 0;
        })->sortByDesc('due_missing_contexts')->take(5);

        return view('admin.student_follow_ups.index', array_merge([
            'year' => $year,
            'now' => $now,
            'months' => $months,
            'month' => $month,
            'summary' => $summary,
            'attention' => $attention,
        ], []));
    }

    public function teachers(Request $request)
    {
        $year = $this->activeYearOrFail();
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $filters = $this->filters($request, $year);
        $teachers = $this->teacherSummaryQuery($year, $month, $now, $filters)
            ->paginate(30)->appends($request->query());

        return view('admin.student_follow_ups.teachers', compact('year', 'now', 'months', 'month', 'filters', 'teachers') + ['filterOptions' => $this->filterOptions($year)]);
    }

    public function students(Request $request)
    {
        $year = $this->activeYearOrFail();
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $range = $this->monthRange($month);
        $filters = $this->filters($request, $year);
        $search = trim((string) $request->query('search', ''));
        $followUps = DB::table('student_follow_ups')->where('year_id', $year->id)->whereNull('voided_at')
            ->whereBetween('compliance_month', [$range['start']->toDateString(), $range['end']->toDateString()])
            ->select('student_id', DB::raw('COUNT(*) AS observation_count'), DB::raw('COUNT(DISTINCT CONCAT(teacher_id, ":", lesson_id)) AS teacher_subject_count'))
            ->groupBy('student_id');
        $studentQuery = Student::query()->select(['students.id', 'students.first_name', 'students.last_name', 'classes.name as class_name', 'rooms.name as room_name', DB::raw('COALESCE(month_rows.observation_count, 0) AS observation_count'), DB::raw('COALESCE(month_rows.teacher_subject_count, 0) AS teacher_subject_count')])
            ->join('student_academic_placements as placements', function ($join) use ($year, $now) {
                $join->on('placements.student_id', '=', 'students.id')->where('placements.year_id', $year->id)->where('placements.effective_from', '<=', $now->toDateTimeString())->where(function ($placement) use ($now) { $placement->whereNull('placements.effective_to')->orWhere('placements.effective_to', '>', $now->toDateTimeString()); });
            })->join('rooms', function ($join) use ($year) { $join->on('rooms.id', '=', 'placements.room_id')->where('rooms.year_id', $year->id); })->join('classes', 'classes.id', '=', 'placements.class_id')->leftJoinSub($followUps, 'month_rows', function ($join) { $join->on('month_rows.student_id', '=', 'students.id'); })
            ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE)
            ->when($filters['class_id'], function ($query, $id) { $query->where('placements.class_id', $id); })
            ->when($filters['room_id'], function ($query, $id) { $query->where('placements.room_id', $id); })
            ->when($search !== '', function ($query) use ($search) { $query->where(function ($students) use ($search) { $students->where('students.first_name', 'like', '%' . $search . '%')->orWhere('students.last_name', 'like', '%' . $search . '%')->orWhereRaw("CONCAT_WS(' ', students.first_name, students.last_name) LIKE ?", ['%' . $search . '%']); }); })
            ->orderBy('students.first_name')->orderBy('students.last_name');
        $students = ($search !== '' || $filters['room_id']) ? $studentQuery->paginate(30)->appends($request->query()) : null;
        $browseClasses = Classe::query()->select('classes.id', 'classes.name', DB::raw('COUNT(DISTINCT rooms.id) AS room_count'), DB::raw('COUNT(DISTINCT placements.student_id) AS student_count'))
            ->join('rooms', function ($join) use ($year) { $join->on('rooms.class_id', '=', 'classes.id')->where('rooms.year_id', $year->id); })
            ->leftJoin('student_academic_placements as placements', function ($join) use ($year, $now) { $join->on('placements.class_id', '=', 'classes.id')->on('placements.room_id', '=', 'rooms.id')->where('placements.year_id', $year->id)->where('placements.effective_from', '<=', $now)->where(function ($q) use ($now) { $q->whereNull('placements.effective_to')->orWhere('placements.effective_to', '>', $now); }); })
            ->groupBy('classes.id', 'classes.name')->havingRaw('COUNT(DISTINCT placements.student_id) > 0')->orderBy('classes.name')->get();
        $browseRooms = $filters['class_id'] ? Room::query()->select('rooms.id', 'rooms.name', 'rooms.class_id', DB::raw('COUNT(DISTINCT placements.student_id) AS student_count'))->leftJoin('student_academic_placements as placements', function ($join) use ($year, $now) { $join->on('placements.room_id', '=', 'rooms.id')->where('placements.year_id', $year->id)->where('placements.effective_from', '<=', $now)->where(function ($q) use ($now) { $q->whereNull('placements.effective_to')->orWhere('placements.effective_to', '>', $now); }); })->where('rooms.year_id', $year->id)->where('rooms.class_id', $filters['class_id'])->groupBy('rooms.id', 'rooms.name', 'rooms.class_id')->havingRaw('COUNT(DISTINCT placements.student_id) > 0')->orderBy('rooms.name')->get() : collect();
        return view('admin.student_follow_ups.students', compact('year', 'now', 'months', 'month', 'filters', 'students', 'search', 'browseClasses', 'browseRooms') + ['filterOptions' => $this->filterOptions($year)]);
    }

    public function teacher(Request $request, $teacher)
    {
        $year = $this->activeYearOrFail();
        $teacher = Teacher::findOrFail((int) $teacher);
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $filters = $this->filters($request, $year);
        $filters['teacher_id'] = $teacher->id;
        $teacherSummary = $this->summary($year, $month, $now, ['teacher_id' => $teacher->id]);
        $contexts = $this->complianceQuery($year, $month, $now, ['teacher_id' => $teacher->id])->get();
        foreach ($contexts as $context) $this->decorateCompliance($context, $month, $now);
        $classGroups = $contexts->groupBy('class_id')->map(function ($classRows) {
            $first = $classRows->first();
            return (object) ['id'=>$first->class_id, 'name'=>$first->class_name, 'sections'=>$classRows->pluck('room_id')->unique()->count(), 'students'=>$classRows->pluck('student_id')->unique()->count(), 'observations'=>$classRows->sum('observation_count')];
        })->values();
        $sectionGroups = collect();
        if ($filters['class_id']) {
            $sectionGroups = $contexts->where('class_id', $filters['class_id'])->groupBy('room_id')->map(function ($roomRows) {
                $first = $roomRows->first();
                return (object) ['id'=>$first->room_id, 'name'=>$first->room_name, 'class_id'=>$first->class_id, 'lessons'=>$roomRows->pluck('lesson_name')->unique()->values(), 'students'=>$roomRows->pluck('student_id')->unique()->count(), 'observations'=>$roomRows->sum('observation_count')];
            })->values();
        }
        $lessons = $filters['room_id'] ? $contexts->where('room_id', $filters['room_id'])->map(function ($row) { return (object) ['id'=>$row->lesson_id, 'name'=>$row->lesson_name]; })->unique('id')->values() : collect();
        if ($filters['room_id'] && !$filters['lesson_id'] && $lessons->count() === 1) $filters['lesson_id'] = $lessons->first()->id;
        $rows = $contexts
            ->when($filters['class_id'], function ($items) use ($filters) { return $items->where('class_id', $filters['class_id']); })
            ->when($filters['room_id'], function ($items) use ($filters) { return $items->where('room_id', $filters['room_id']); })
            ->when($filters['lesson_id'], function ($items) use ($filters) { return $items->where('lesson_id', $filters['lesson_id']); })
            ->when($filters['status'], function ($items) use ($filters) { return $items->filter(function ($row) use ($filters) { if ($filters['status'] === 'completed') return $row->monthly_status === 'completed'; if ($filters['status'] === 'no_follow_up') return (int) $row->observation_count === 0; return $row->monthly_status === 'incomplete'; }); })
            ->when($filters['search'] !== '', function ($items) use ($filters) { return $items->filter(function ($row) use ($filters) { return strpos($row->student_name, $filters['search']) !== false; }); })->values();
        return view('admin.student_follow_ups.teacher', compact('year', 'teacher', 'now', 'months', 'month', 'rows', 'teacherSummary', 'filters', 'classGroups', 'sectionGroups', 'lessons'));
    }

    public function storeOnBehalf(Request $request, $teacher, $student, StudentFollowUpService $followUps)
    {
        $request->validate(['assignment_id'=>'required|integer','level'=>'nullable|in:weak,average,good,excellent','note'=>'nullable|string']);
        $year = $this->activeYearOrFail(); $now = Carbon::now('Asia/Damascus');
        $teacher = Teacher::findOrFail((int) $teacher); $student = Student::operational()->findOrFail((int) $student);
        $assignment = $this->adminAssignmentOrFail($request, $teacher->id, $student->id, $year, $now);
        $followUps->createOnBehalf(Auth::id(), $teacher->id, $assignment->id, $student->id, $request->only('level','note'));
        return redirect()->route('admin.student_follow_ups.teacher', ['teacher'=>$teacher->id,'month'=>$request->input('month', $now->format('Y-m')),'class_id'=>$assignment->class_id,'room_id'=>$assignment->room_id,'lesson_id'=>$assignment->lesson_id,'search'=>$request->input('search')])->with('success', 'تمت إضافة المتابعة باسم المدرس بنجاح.');
    }

    public function report(Request $request, $student)
    {
        $year=$this->activeYearOrFail(); $student=Student::operational()->findOrFail((int)$student); $now=Carbon::now('Asia/Damascus'); $months=$this->availableMonths($year,$now); $month=$this->selectedMonth($request,$months,$now); $range=$this->monthRange($month);
        $followUps=StudentFollowUp::with(['teacher','lesson','room','classRoom'])->where('student_id',$student->id)->where('year_id',$year->id)->whereNull('voided_at')->whereBetween('compliance_month',[$range['start']->toDateString(),$range['end']->toDateString()])->orderBy('lesson_id')->orderBy('teacher_id')->orderBy('observed_at')->get();
        $placement=DB::table('student_academic_placements as p')->join('rooms','rooms.id','=','p.room_id')->join('classes','classes.id','=','p.class_id')->where('p.student_id',$student->id)->where('p.year_id',$year->id)->where('p.effective_from','<=',$now)->where(function($q)use($now){$q->whereNull('p.effective_to')->orWhere('p.effective_to','>',$now);})->select('classes.name as class_name','rooms.name as room_name')->first();
        $school=School_data::first();
        return view('admin.student_follow_ups.report', compact('year','student','month','followUps','placement','school'));
    }

    public function teacherComplianceReport(Request $request, $teacher)
    {
        $year=$this->activeYearOrFail(); $teacher=Teacher::findOrFail((int)$teacher); $now=Carbon::now('Asia/Damascus'); $months=$this->availableMonths($year,$now); $month=$this->selectedMonth($request,$months,$now); $filters=$this->filters($request,$year); $filters['teacher_id']=$teacher->id;
        $rows=$this->complianceQuery($year,$month,$now,$filters)->get(); foreach($rows as $row) $this->decorateCompliance($row,$month,$now);
        if ($filters['search'] !== '') $rows=$rows->filter(function($row)use($filters){return strpos($row->student_name,$filters['search'])!==false;})->values();
        $groups=$rows->groupBy(function($row){return $row->class_id.':'.$row->room_id.':'.$row->lesson_id;}); $school=School_data::first();
        return view('admin.student_follow_ups.teacher_compliance_report',compact('year','teacher','month','rows','groups','school','filters'));
    }

    public function teacherEvaluationsReport(Request $request, $teacher)
    {
        $year=$this->activeYearOrFail(); $teacher=Teacher::findOrFail((int)$teacher); $now=Carbon::now('Asia/Damascus'); $months=$this->availableMonths($year,$now); $month=$this->selectedMonth($request,$months,$now); $range=$this->monthRange($month); $filters=$this->filters($request,$year);
        $matchingStudents=$filters['search']!==''?Student::operational()->where(function($q)use($filters){$q->where('first_name','like','%'.$filters['search'].'%')->orWhere('last_name','like','%'.$filters['search'].'%')->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?",['%'.$filters['search'].'%']);})->pluck('id'):null;
        $followUps=StudentFollowUp::with(['teacher','lesson','room','classRoom'])->where('teacher_id',$teacher->id)->where('year_id',$year->id)->whereNull('voided_at')->whereBetween('compliance_month',[$range['start']->toDateString(),$range['end']->toDateString()])->when($filters['class_id'],function($q,$id){$q->where('class_id',$id);})->when($filters['room_id'],function($q,$id){$q->where('room_id',$id);})->when($filters['lesson_id'],function($q,$id){$q->where('lesson_id',$id);})->when($matchingStudents!==null,function($q)use($matchingStudents){$q->whereIn('student_id',$matchingStudents);})->orderBy('class_id')->orderBy('room_id')->orderBy('lesson_id')->orderBy('observed_at')->get();
        $students=Student::whereIn('id',$followUps->pluck('student_id')->unique())->get()->keyBy('id'); $groups=$followUps->groupBy(function($row){return $row->class_id.':'.$row->room_id.':'.$row->lesson_id;}); $school=School_data::first();
        return view('admin.student_follow_ups.teacher_evaluations_report',compact('year','teacher','month','followUps','groups','students','school','filters'));
    }

    public function student(Request $request, $student)
    {
        $year = $this->activeYearOrFail();
        $student = Student::operational()->findOrFail((int) $student);
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $range = $this->monthRange($month);
        $followUps = StudentFollowUp::query()
            ->with(['teacher', 'lesson', 'room', 'classRoom'])
            ->where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->whereNull('voided_at')
            ->whereBetween('compliance_month', [$range['start']->toDateString(), $range['end']->toDateString()])
            ->orderByDesc('observed_at')
            ->paginate(50)
            ->appends($request->query());

        $placement=DB::table('student_academic_placements as p')->join('rooms','rooms.id','=','p.room_id')->join('classes','classes.id','=','p.class_id')->where('p.student_id',$student->id)->where('p.year_id',$year->id)->where('p.effective_from','<=',$now)->where(function($q)use($now){$q->whereNull('p.effective_to')->orWhere('p.effective_to','>',$now);})->select('classes.name as class_name','rooms.name as room_name')->first();
        return view('admin.student_follow_ups.student', compact('year', 'student', 'now', 'months', 'month', 'followUps', 'placement'));
    }

    public function observations(Request $request)
    {
        $year = $this->activeYearOrFail();
        $now = Carbon::now('Asia/Damascus');
        $months = $this->availableMonths($year, $now);
        $month = $this->selectedMonth($request, $months, $now);
        $range = $this->monthRange($month);
        $validated = $request->validate([
            'teacher_id' => 'required|integer',
            'student_id' => 'required|integer',
            'lesson_id' => 'required|integer',
            'room_id' => 'required|integer',
        ]);

        // Resolve the row exclusively inside the active year before exposing observations.
        $contextExists = $this->complianceQuery($year, $month, $now, $validated)->exists();
        abort_unless($contextExists, 404);

        $followUps = StudentFollowUp::query()
            ->with(['teacher', 'lesson', 'room', 'classRoom'])
            ->where('year_id', $year->id)
            ->whereNull('voided_at')
            ->where($validated)
            ->whereBetween('compliance_month', [$range['start']->toDateString(), $range['end']->toDateString()])
            ->orderByDesc('observed_at')
            ->paginate(50)
            ->appends($request->query());

        return view('admin.student_follow_ups.observations', compact('year', 'now', 'months', 'month', 'followUps'));
    }

    private function complianceQuery(Year $year, $month, Carbon $now, array $filters = [])
    {
        $range = $this->monthRange($month);
        $firstStart = $range['start']->copy();
        $firstEnd = $range['start']->copy()->day(15)->endOfDay();
        $secondStart = $range['start']->copy()->day(16)->startOfDay();
        $secondEnd = $range['end']->copy();

        $followUpCounts = DB::table('student_follow_ups')
            ->where('year_id', $year->id)
            ->whereNull('voided_at')
            ->whereBetween('compliance_month', [$range['start']->toDateString(), $range['end']->toDateString()])
            ->select([
                'teacher_id', 'student_id', 'lesson_id', 'room_id',
                DB::raw('MAX(CASE WHEN compliance_half = 1 THEN 1 ELSE 0 END) AS half_one_done'),
                DB::raw('MAX(CASE WHEN compliance_half = 2 THEN 1 ELSE 0 END) AS half_two_done'),
                DB::raw('COUNT(*) AS observation_count'),
            ])
            ->groupBy('teacher_id', 'student_id', 'lesson_id', 'room_id');

        $query = TeacherAssignmentPeriod::query()
            ->join('student_academic_placements as placements', function ($join) use ($year, $range) {
                $join->on('placements.year_id', '=', 'teacher_assignment_periods.year_id')
                    ->on('placements.class_id', '=', 'teacher_assignment_periods.class_id')
                    ->on('placements.room_id', '=', 'teacher_assignment_periods.room_id')
                    ->where('placements.year_id', $year->id)
                    ->where('placements.effective_from', '<=', $range['end']->toDateTimeString())
                    ->where(function ($placement) use ($range) {
                        $placement->whereNull('placements.effective_to')
                            ->orWhere('placements.effective_to', '>', $range['start']->toDateTimeString());
                    });
            })
            ->join('students', function ($join) {
                $join->on('students.id', '=', 'placements.student_id')
                    ->where('students.lifecycle_status', Student::LIFECYCLE_ACTIVE);
            })
            ->join('teachers', 'teachers.id', '=', 'teacher_assignment_periods.teacher_id')
            ->join('lessons', 'lessons.id', '=', 'teacher_assignment_periods.lesson_id')
            ->join('classes', 'classes.id', '=', 'teacher_assignment_periods.class_id')
            ->join('rooms', function ($join) use ($year) {
                $join->on('rooms.id', '=', 'teacher_assignment_periods.room_id')
                    ->where('rooms.year_id', $year->id);
            })
            ->leftJoinSub($followUpCounts, 'follow_up_counts', function ($join) {
                $join->on('follow_up_counts.teacher_id', '=', 'teacher_assignment_periods.teacher_id')
                    ->on('follow_up_counts.student_id', '=', 'placements.student_id')
                    ->on('follow_up_counts.lesson_id', '=', 'teacher_assignment_periods.lesson_id')
                    ->on('follow_up_counts.room_id', '=', 'teacher_assignment_periods.room_id');
            })
            ->where('teacher_assignment_periods.year_id', $year->id)
            ->where('teacher_assignment_periods.effective_from', '<=', $range['end']->toDateTimeString())
            ->where(function ($period) use ($range) {
                $period->whereNull('teacher_assignment_periods.effective_to')
                    ->orWhere('teacher_assignment_periods.effective_to', '>', $range['start']->toDateTimeString());
            })
            ->select([
                'teacher_assignment_periods.teacher_id', 'placements.student_id', 'teacher_assignment_periods.lesson_id',
                'teacher_assignment_periods.class_id', 'teacher_assignment_periods.room_id',
                DB::raw('MIN(teacher_assignment_periods.teacher_room_lesson_id) AS assignment_id'),
                DB::raw("CONCAT_WS(' ', teachers.first_name, teachers.last_name) AS teacher_name"),
                DB::raw("CONCAT_WS(' ', students.first_name, students.last_name) AS student_name"),
                'lessons.name as lesson_name', 'classes.name as class_name', 'rooms.name as room_name',
                DB::raw('MAX(CASE WHEN teacher_assignment_periods.effective_from <= \'' . $firstEnd->toDateTimeString() . '\' AND (teacher_assignment_periods.effective_to IS NULL OR teacher_assignment_periods.effective_to > \'' . $firstStart->toDateTimeString() . '\') THEN 1 ELSE 0 END) AS half_one_applicable'),
                DB::raw('MAX(CASE WHEN teacher_assignment_periods.effective_from <= \'' . $secondEnd->toDateTimeString() . '\' AND (teacher_assignment_periods.effective_to IS NULL OR teacher_assignment_periods.effective_to > \'' . $secondStart->toDateTimeString() . '\') THEN 1 ELSE 0 END) AS half_two_applicable'),
                DB::raw('MAX(COALESCE(follow_up_counts.half_one_done, 0)) AS half_one_done'),
                DB::raw('MAX(COALESCE(follow_up_counts.half_two_done, 0)) AS half_two_done'),
                DB::raw('MAX(COALESCE(follow_up_counts.observation_count, 0)) AS observation_count'),
            ])
            ->groupBy('teacher_assignment_periods.teacher_id', 'placements.student_id', 'teacher_assignment_periods.lesson_id', 'teacher_assignment_periods.class_id', 'teacher_assignment_periods.room_id', 'teachers.first_name', 'teachers.last_name', 'students.first_name', 'students.last_name', 'lessons.name', 'classes.name', 'rooms.name')
            ->orderBy('teachers.first_name')->orderBy('teachers.last_name')->orderBy('students.first_name')->orderBy('students.last_name');

        foreach (['teacher_id', 'class_id', 'room_id', 'lesson_id'] as $field) {
            if (!empty($filters[$field])) {
                $query->where('teacher_assignment_periods.' . $field, (int) $filters[$field]);
            }
        }

        if (!empty($filters['status'])) {
            $this->applyStatusFilter($query, $filters['status'], $month, $now);
        }

        return $query;
    }

    private function applyStatusFilter($query, $status, $month, Carbon $now)
    {
        $due = $this->dueHalves($month, $now);
        if ($status === 'completed') {
            return $query->havingRaw('(half_one_applicable = 0 OR half_one_done = 1) AND (half_two_applicable = 0 OR half_two_done = 1)');
        }
        if ($status === 'no_follow_up') {
            return $query->havingRaw('observation_count = 0');
        }
        if ($status === 'missing_first' && $due[1]) {
            return $query->havingRaw('half_one_applicable = 1 AND half_one_done = 0');
        }
        if ($status === 'missing_second' && $due[2]) {
            return $query->havingRaw('half_two_applicable = 1 AND half_two_done = 0');
        }

        return $query->havingRaw('1 = 0');
    }

    private function summary(Year $year, $month, Carbon $now, array $filters)
    {
        $rows = $this->complianceQuery($year, $month, $now, $filters)->get();
        foreach ($rows as $row) {
            $this->decorateCompliance($row, $month, $now);
        }
        return [
            'teachers' => $rows->pluck('teacher_id')->unique()->count(),
            'contexts' => $rows->count(),
            'completed' => $rows->where('monthly_status', 'completed')->count(),
            'incomplete' => $rows->filter(function ($row) { return $row->monthly_status !== 'completed'; })->count(),
            'none' => $rows->filter(function ($row) { return (int) $row->observation_count === 0; })->count(),
            'observations' => $rows->sum('observation_count'),
        ];
    }

    private function decorateCompliance($row, $month, Carbon $now)
    {
        $phases = $this->halfPhases($month, $now);
        $row->half_one_status = $this->halfStatus((bool) $row->half_one_applicable, (bool) $row->half_one_done, $phases[1]);
        $row->half_two_status = $this->halfStatus((bool) $row->half_two_applicable, (bool) $row->half_two_done, $phases[2]);
        if ($row->half_one_status === 'missing') {
            $row->half_one_status = 'missing_first';
        }
        if ($row->half_two_status === 'missing') {
            $row->half_two_status = 'missing_second';
        }
        $statuses = [$row->half_one_status, $row->half_two_status];
        $row->monthly_status = in_array('missing_first', $statuses, true) || in_array('missing_second', $statuses, true)
            ? 'incomplete'
            : (in_array('in_progress', $statuses, true) ? 'in_progress'
                : (in_array('future', $statuses, true) ? 'future'
                    : ((!(bool) $row->half_one_applicable || (bool) $row->half_one_done) && (!(bool) $row->half_two_applicable || (bool) $row->half_two_done) ? 'completed' : 'no_follow_up')));
    }

    private function halfStatus($applicable, $done, $phase)
    {
        if (!$applicable) {
            return 'not_applicable';
        }
        if ($done) {
            return 'completed';
        }
        return $phase === 'closed' ? 'missing' : ($phase === 'current' ? 'in_progress' : 'future');
    }

    private function teacherSummaryQuery(Year $year, $month, Carbon $now, array $filters = [])
    {
        $contexts = $this->complianceQuery($year, $month, $now, array_filter($filters, function ($key) { return $key !== 'status'; }, ARRAY_FILTER_USE_KEY));
        $phases = $this->halfPhases($month, $now);
        $missingOne = $phases[1] === 'closed' ? 'half_one_applicable = 1 AND half_one_done = 0' : '1 = 0';
        $missingTwo = $phases[2] === 'closed' ? 'half_two_applicable = 1 AND half_two_done = 0' : '1 = 0';
        $query = DB::query()->fromSub($contexts, 'contexts')->select([
            'teacher_id', 'teacher_name',
            DB::raw('COUNT(DISTINCT class_id) AS class_count'), DB::raw('COUNT(DISTINCT room_id) AS room_count'), DB::raw('COUNT(DISTINCT lesson_id) AS lesson_count'),
            DB::raw('COUNT(*) AS applicable_contexts'), DB::raw('SUM(CASE WHEN (half_one_applicable = 0 OR half_one_done = 1) AND (half_two_applicable = 0 OR half_two_done = 1) THEN 1 ELSE 0 END) AS completed_contexts'),
            DB::raw('SUM(CASE WHEN (' . $missingOne . ') OR (' . $missingTwo . ') THEN 1 ELSE 0 END) AS due_missing_contexts'),
            DB::raw('SUM(observation_count) AS observation_count'),
        ])->groupBy('teacher_id', 'teacher_name')->orderBy('teacher_name');
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'completed') $query->havingRaw('due_missing_contexts = 0');
            if ($filters['status'] === 'no_follow_up') $query->havingRaw('observation_count = 0');
            if (in_array($filters['status'], ['missing_first', 'missing_second'], true)) $query->havingRaw('due_missing_contexts > 0');
        }
        if (!empty($filters['search'])) $query->where('teacher_name', 'like', '%' . $filters['search'] . '%');
        return $query;
    }

    private function landingSummary($teachers, Year $year, $month)
    {
        $followUpTotal = StudentFollowUp::where('year_id', $year->id)->whereNull('voided_at')->where('compliance_month', $this->monthRange($month)['start']->toDateString())->count();
        return ['teachers' => $teachers->count(), 'submitted_teachers' => $teachers->filter(function ($teacher) { return (int) $teacher->observation_count > 0; })->count(), 'teachers_with_missing' => $teachers->filter(function ($teacher) { return (int) $teacher->due_missing_contexts > 0; })->count(), 'observations' => $followUpTotal];
    }

    private function dueHalves($month, Carbon $now)
    {
        $phases = $this->halfPhases($month, $now);
        return [1 => $phases[1] === 'closed', 2 => $phases[2] === 'closed'];
    }

    private function halfPhases($month, Carbon $now)
    {
        $range = $this->monthRange($month);
        $firstEnd = $range['start']->copy()->day(15)->endOfDay();
        $secondStart = $range['start']->copy()->day(16)->startOfDay();
        if ($range['start']->gt($now->copy()->startOfMonth())) return [1 => 'future', 2 => 'future'];
        if ($range['start']->lt($now->copy()->startOfMonth())) return [1 => 'closed', 2 => 'closed'];
        return [1 => $now->lte($firstEnd) ? 'current' : 'closed', 2 => $now->lt($secondStart) ? 'future' : 'current'];
    }

    private function filters(Request $request, Year $year)
    {
        $fields = ['teacher_id', 'class_id', 'room_id', 'lesson_id'];
        $filters = [];
        foreach ($fields as $field) {
            $value = $request->query($field);
            $filters[$field] = is_scalar($value) && ctype_digit((string) $value) ? (int) $value : null;
        }
        $allowed = ['completed', 'missing_first', 'missing_second', 'no_follow_up'];
        $filters['status'] = in_array($request->query('status'), $allowed, true) ? $request->query('status') : null;
        $filters['search'] = trim((string) $request->query('search', ''));
        return $filters;
    }

    private function filterOptions(Year $year)
    {
        $periods = TeacherAssignmentPeriod::where('year_id', $year->id);
        return [
            'teachers' => Teacher::whereIn('id', (clone $periods)->select('teacher_id')->distinct())->orderBy('first_name')->get(),
            'classes' => Classe::whereIn('id', (clone $periods)->select('class_id')->distinct())->orderBy('name')->get(),
            'rooms' => Room::where('year_id', $year->id)->whereIn('id', (clone $periods)->select('room_id')->distinct())->orderBy('name')->get(),
            'lessons' => Lesson::whereIn('id', (clone $periods)->select('lesson_id')->distinct())->orderBy('name')->get(),
        ];
    }

    private function teacherFilterOptions(Year $year, $teacherId)
    {
        $periods = TeacherAssignmentPeriod::where('year_id', $year->id)->where('teacher_id', $teacherId);
        return [
            'classes' => Classe::whereIn('id', (clone $periods)->select('class_id')->distinct())->orderBy('name')->get(),
            'rooms' => Room::where('year_id', $year->id)->whereIn('id', (clone $periods)->select('room_id')->distinct())->orderBy('name')->get(),
            'lessons' => Lesson::whereIn('id', (clone $periods)->select('lesson_id')->distinct())->orderBy('name')->get(),
        ];
    }

    private function adminAssignmentOrFail(Request $request, $teacherId, $studentId, Year $year, Carbon $now)
    {
        $assignmentId = (int) $request->query('assignment_id', $request->input('assignment_id'));
        $assignment = Teacher_room_lesson::whereKey($assignmentId)->where('teacher_id', $teacherId)->where('year_id', $year->id)->firstOrFail();
        $period = TeacherAssignmentPeriod::where('teacher_room_lesson_id', $assignment->id)->where('teacher_id', $teacherId)->where('year_id', $year->id)->where('effective_from','<=',$now)->where(function($q)use($now){$q->whereNull('effective_to')->orWhere('effective_to','>',$now);})->exists();
        abort_unless($period, 403);
        $enrolled = DB::table('room_student')->where('student_id',$studentId)->where('room_id',$assignment->room_id)->where('year_id',$year->id)->exists();
        abort_unless($enrolled, 403);
        return $assignment;
    }

    private function availableMonths(Year $year, Carbon $now)
    {
        $current = $now->copy()->startOfMonth();
        $recordMonths = StudentFollowUp::where('year_id', $year->id)->whereNull('voided_at')->pluck('compliance_month');
        $periodMonths = TeacherAssignmentPeriod::where('year_id', $year->id)->pluck('effective_from');
        return $recordMonths->merge($periodMonths)->filter()->map(function ($value) use ($current) {
            $month = Carbon::parse($value, 'Asia/Damascus')->startOfMonth();
            return $month->lte($current) ? $month->format('Y-m') : null;
        })->filter()->push($current->format('Y-m'))->unique()->sortDesc()->values();
    }

    private function selectedMonth(Request $request, $months, Carbon $now)
    {
        $requested = (string) $request->query('month', $now->format('Y-m'));
        return preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $requested) && $months->contains($requested)
            ? $requested
            : $now->format('Y-m');
    }

    private function monthRange($month)
    {
        $start = Carbon::createFromFormat('Y-m', $month, 'Asia/Damascus')->startOfMonth();
        return ['start' => $start, 'end' => $start->copy()->endOfMonth()];
    }

    private function activeYearOrFail()
    {
        return Year::where('current_year', 1)->firstOrFail();
    }
}
