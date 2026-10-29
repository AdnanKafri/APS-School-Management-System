<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classe;
use App\Lesson;
use App\Room;
use App\Student;
use App\Students_mark;
use App\Year;
use App\Services\GradebookStatusService;

/**
 * Admin Gradebook Controller
 * 
 * Phase 2 CORRECTED - Fixed JSON parsing and restored proper flow
 */
class GradebookController extends Controller
{
    /**
     * Main Entry Point - Show menu (NO FORCED REDIRECT)
     */
    public function index()
    {
        return view('admin.gradebook.index');
    }

    /**
     * Toggle Gradebook Status (Open/Locked)
     * Route: POST /admin/gradebook/status
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'term_id' => 'required|integer|exists:term_years,id',
            'status' => 'required|in:OPEN,LOCKED'
        ]);

        abort_unless(\App\Term_year::whereKey($request->term_id)
            ->whereIn('year_id', Year::where('current_year', 1)->select('id'))->exists(), 422, __('gradebook.context_invalid'));
        $saved = GradebookStatusService::setStatus(
            $request->class_id,
            $request->term_id,
            $request->status
        );

        abort_unless($saved, 500, __('gradebook.write_failed'));
        return response()->json([
            'success' => true,
            'status' => $request->status,
            'message' => __('gradebook.status_saved')
        ]);
    }

    /**
     * View Options - Choose by Subject or Student
     */
    public function viewOptions()
    {
        return view('admin.gradebook.view_options');
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW BY SUBJECT FLOW
    |--------------------------------------------------------------------------
    */

    /**
     * Show all classes (for subject view)
     */
    public function viewClassesSubject()
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $classes = Classe::paginate(paginate_num);
        $count = Classe::count();

        return view('admin.gradebook.view_classes', compact('classes', 'count', 'year'));
    }

    /**
     * Show all rooms for a class (for subject view)
     */
    public function viewRooms($classId)
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $rooms = Room::where('class_id', $classId)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();

        return view('admin.gradebook.view_rooms', compact('rooms', 'count'));
    }

    /**
     * Show all subjects for a room
     */
    public function viewSubjects($roomId)
    {
        $room = Room::findOrFail($roomId);
        $subjects = Lesson::where('class_id', $room->class_id)->get();

        return view('admin.gradebook.view_subjects', compact('room', 'subjects'));
    }

    /**
     * Show marks grid for a subject
     * FIXED: No lesson_id column - parse JSON instead
     */
    /**
     * Show marks grid for a subject
     * REFACTORED: Direct calculation from source tables (Exam_result/Exam_result2)
     * No JSON, No Aggregation Jobs.
     */
    public function viewGridSimple(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $subject = Lesson::findOrFail($request->input('subject_id'));
        $year = Year::whereKey($room->year_id)->firstOrFail();
        $students = (int) $year->current_year === 1
            ? $room->operationalStudents()->orderBy('first_name')->get()
            : $room->student()->where('room_student.year_id', $year->id)->distinct()->orderBy('first_name')->get();
        $subjectId = $subject->id;
        $gradebook = app(\App\Services\GradebookReadService::class)->read($room, $subject, $students->pluck('id'));
        $components = $gradebook['components'];
        foreach ($components as $component) {
            $component->calculated_max = \App\Services\GradebookReadService::componentMaximum($component, $subject);
        }
        $calculatedMarks = [];
        foreach ($students as $student) {
            foreach ([1, 2] as $type) {
                $term = $gradebook['terms']->where('type', $type)->sortByDesc(function ($t) {
                    return [(int) $t->current_term, (int) $t->id];
                })->first();
                $calculatedMarks[$student->id]['term'.$type] = $term ? $gradebook['marks'][$student->id][$term->id] : null;
            }
        }
        return view('admin.gradebook.view_by_subject_corrected', compact('room', 'subject', 'students',
            'calculatedMarks', 'subjectId', 'components', 'gradebook'));
    }
    /*
    |--------------------------------------------------------------------------
    | VIEW BY STUDENT FLOW
    |--------------------------------------------------------------------------
    */

    /**
     * Show all classes (for student view)
     */
    public function viewClassesStudent()
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $classes = Classe::paginate(paginate_num);
        $count = Classe::count();

        return view('admin.gradebook.view_classes_student', compact('classes', 'count', 'year'));
    }

    /**
     * Show all rooms for a class (for student view)
     */
    public function viewRoomsStudent($classId)
    {
        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return redirect()->route('admin.gradebook.index')->with('error', __('gradebook.year_missing'));
        }
        $rooms = Room::where('class_id', $classId)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();

        return view('admin.gradebook.view_rooms_student', compact('rooms', 'count'));
    }

    /**
     * Show all students in a room
     */
    public function viewStudents($roomId)
    {
        $year = Year::where('current_year', 1)->firstOrFail();
        $room = Room::whereKey($roomId)->where('year_id', $year->id)->firstOrFail();
        $students = $room->operationalStudents()->orderBy('first_name')->get();
        return view('admin.gradebook.view_students', compact('room', 'students'));
    }
    /**
     * Show student's complete gradebook
     */
    /**
     * Show student's complete gradebook
     * REFACTORED: Direct calculation, lists all subjects
     */
    public function viewStudentCard(Request $request)
    {
        if (!$request->input('student_id')) {
            return redirect()->route('admin.gradebook.view_classes_student');
        }
        $student = Student::findOrFail($request->input('student_id'));
        $year = Year::where('current_year', 1)->firstOrFail();
        $room = app(\App\Services\CurrentStudentMembership::class)->roomForStudent($student->id, $year->id);
        $subjects = $room ? Lesson::where('class_id', $room->class_id)->get() : collect();
        $studentMarks = [];
        $subjectGradebooks = [];
        foreach ($subjects as $subject) {
            $read = app(\App\Services\GradebookReadService::class)->read($room, $subject, [$student->id]);
            $subjectGradebooks[] = ['subject' => $subject, 'gradebook' => $read];
            $row = ['name' => $subject->name];
            foreach ([1, 2] as $type) {
                $term = $read['terms']->where('type', $type)->sortByDesc(function ($t) {
                    return [(int) $t->current_term, (int) $t->id];
                })->first();
                $data = $term ? $read['marks'][$student->id][$term->id] : [];
                $row['term'.$type] = ['total' => $data['total'] ?? null, 'details' => [
                    'oral' => $data['legacy_oral'] ?? null,
                    'quize' => $data['legacy_homework'] ?? null,
                    'exam' => $data['legacy_exam'] ?? null,
                ]];
                $row['term'.$type]['additional'] = $read['components']->reject(function ($component) {
                    return in_array($component->id, ['legacy_oral', 'legacy_homework', 'legacy_exam'], true);
                })->map(function ($component) use ($data) {
                    return ['name' => $component->name, 'value' => $data[$component->id] ?? null];
                })->values()->all();
            }
            $row['total'] = $row['term1']['total'] === null && $row['term2']['total'] === null
                ? null : ($row['term1']['total'] ?? 0) + ($row['term2']['total'] ?? 0);
            $studentMarks[] = $row;
        }
        return view('admin.gradebook.view_by_student', compact('student', 'room', 'year', 'studentMarks', 'subjectGradebooks'));
    }
}
