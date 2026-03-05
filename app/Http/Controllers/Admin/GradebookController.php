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
            'class_id' => 'required|integer',
            'term_id' => 'required|integer',
            'status' => 'required|in:OPEN,LOCKED'
        ]);

        GradebookStatusService::setStatus(
            $request->class_id,
            $request->term_id,
            $request->status
        );

        return response()->json([
            'success' => true,
            'status' => $request->status,
            'message' => 'Gradebook status updated successfully'
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
        $roomId = $request->input('room_id');
        $subjectId = $request->input('subject_id');

        $room = Room::findOrFail($roomId);
        $subject = Lesson::findOrFail($subjectId);
        $year = Year::where('current_year','1')->first();

        // Fetch students
        $students = $room->student()->orderBy('first_name')->get();
        $studentIds = $students->pluck('id');

        // 1. Identify Terms (Robust Logic)
        $terms = \App\Term_year::where('year_id', $year->id)->get();
        
        $term1Obj = $terms->where('type', '1')->where('current_term', 1)->first() 
                 ?? $terms->where('type', '1')->sortByDesc('id')->first();
        $term2Obj = $terms->where('type', '2')->where('current_term', 1)->first()
                 ?? $terms->where('type', '2')->sortByDesc('id')->first();

        $term1Id = $term1Obj ? $term1Obj->id : -1;
        $term2Id = $term2Obj ? $term2Obj->id : -1;

        // 2. Fetch Source Data (Batch Query)
        // A. Oral/Homework (Exam_result)
        $oralRecords = \App\Exam_result::whereIn('user_id', $studentIds)
                                       ->where('lesson_id', $subjectId)
                                       ->where('status', '1')
                                       ->get();

        // B. Mid/Exam (Exam_result2 via exams2)
        $examRecords = \App\Exam_result2::join('exams2', 'exam_result2.exam_id', '=', 'exams2.id')
                                        ->whereIn('exam_result2.user_id', $studentIds)
                                        ->where('exams2.lesson_id', $subjectId)
                                        ->where('exams2.room_id', $roomId)
                                        ->select('exam_result2.*', 'exams2.type as exam_type')
                                        ->get();

        // Fetch Dynamic Components (JSON Service)
        $components = \App\Services\GradebookConfigService::getConfig($subjectId, $year->id);

        // Pre-calculate Component Max Marks (based on Subject Total Percentage)
        foreach ($components as $comp) {
            $comp->calculated_max = ($subject->max_mark * ($comp->weight ?? 0)) / 100;
        }

        // 3. Calculate In-Memory
        $calculatedMarks = [];

        foreach($students as $student) {
            $sid = $student->id;
            $calculatedMarks[$sid] = ['term1' => [], 'term2' => []];

            // Helper to process a term
            $processTerm = function($tId) use ($sid, $oralRecords, $examRecords, $components) {
                if ($tId == -1) return null;
                $data = [];

                foreach ($components as $comp) {
                    $score = null;
                    if (is_numeric($comp->data_source)) {
                          // Dynamic Assessment Type (New Logic)
                          // Queries Exam_result2 via $examRecords where exam_type Matches the ID
                          $score = $examRecords->where('user_id', $sid)
                                               ->where('term_id', $tId)
                                               ->where('exam_type', $comp->data_source)
                                               ->avg('result'); 
                    } elseif ($comp->data_source === 'LEGACY_ORAL') {
                         $score = $oralRecords->where('user_id', $sid)->where('term_id', $tId)->avg('result');
                    } elseif ($comp->data_source === 'LEGACY_HOMEWORK') {
                         // Legacy Generic Bucket (Maps to Standard Type 2 / Quiz)
                         $score = $examRecords->where('user_id', $sid)
                                              ->where('term_id', $tId)
                                              ->where('exam_type', '2')
                                              ->avg('result');
                    } elseif ($comp->data_source === 'LEGACY_EXAM') {
                         // Legacy Exam (Maps to Standard Type 1)
                         $score = $examRecords->where('user_id', $sid)
                                              ->where('term_id', $tId)
                                              ->where('exam_type', '1')
                                              ->max('result');
                    }

                    if (!is_null($score)) {
                         $data[$comp->id] = round($score, 1);
                    }
                }
                
                // Calculate Total
                $total = collect($data)->sum();
                $data['total'] = $total;

                return empty($data) ? null : $data;
            };

            $calculatedMarks[$sid]['term1'] = $processTerm($term1Id);
            $calculatedMarks[$sid]['term2'] = $processTerm($term2Id);
        }

        return view('admin.gradebook.view_by_subject_corrected', compact('room', 'subject', 'students', 'calculatedMarks', 'subjectId', 'components'));
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
        $rooms = Room::where('class_id', $classId)->where('year_id', $year->id)->paginate(paginate_num);
        $count = Room::count();

        return view('admin.gradebook.view_rooms_student', compact('rooms', 'count'));
    }

    /**
     * Show all students in a room
     */
    public function viewStudents($roomId)
    {
        $room = Room::findOrFail($roomId);
        
        // Fetch students using working pattern
        $year = Year::where('current_year','1')->first();
        $students_room = Room::with(['student.student_mark'=>fn($q1)=>$q1->where('students_marks.year_id',$year->id)])->find($roomId);
        $students = $students_room->student()->orderBy('first_name')->get();

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
        $studentId = $request->input('student_id');
        
        if (!$studentId) {
             return redirect()->route('admin.gradebook.view_classes_student');
        }

        $student = Student::findOrFail($studentId);
        $year = Year::where('current_year','1')->first();
        
        // 1. Get Subjects
        $room = $student->room()->first();
        $subjects = $room ? Lesson::where('class_id', $room->class_id)->get() : collect();

        // 2. Identify Terms
        $terms = \App\Term_year::where('year_id', $year->id)->get();
        $term1Obj = $terms->where('type', '1')->where('current_term', 1)->first() 
                 ?? $terms->where('type', '1')->sortByDesc('id')->first();
        $term2Obj = $terms->where('type', '2')->where('current_term', 1)->first()
                 ?? $terms->where('type', '2')->sortByDesc('id')->first();

        $term1Id = $term1Obj ? $term1Obj->id : -1;
        $term2Id = $term2Obj ? $term2Obj->id : -1;

        // 3. Fetch All Marks for Student
        $oralRecords = \App\Exam_result::where('user_id', $studentId)
                                       ->where('status', '1')
                                       ->get();

        $examRecords = \App\Exam_result2::join('exams2', 'exam_result2.exam_id', '=', 'exams2.id')
                                        ->where('exam_result2.user_id', $studentId)
                                        ->select('exam_result2.*', 'exams2.lesson_id', 'exams2.type as exam_type', 'exams2.room_id')
                                        ->get();

        // 4. Calculate per Subject
        $studentMarks = [];

        foreach($subjects as $subject) {
            $lid = $subject->id;
            
            $processTerm = function($tId) use ($lid, $oralRecords, $examRecords, $room) {
                 if ($tId == -1) return null;
                 
                 // Oral
                 $oralAvg = $oralRecords->where('lesson_id', $lid)->where('term_id', $tId)->avg('result');
                 
                 // Quiz (Type 2) (Check room logic if needed, but student_id+lesson_id implies scope)
                 // Strict room check: ensure exam belongs to student's room? Usually yes.
                 // We will filter by room_id if available to be strict.
                 $quizQuery = $examRecords->where('lesson_id', $lid)
                                          ->where('term_id', $tId)
                                          ->where('exam_type', '2');
                 if ($room) $quizQuery = $quizQuery->where('room_id', $room->id);
                 $quizAvg = $quizQuery->avg('result');

                 // Exam (Type 1)
                 $examQuery = $examRecords->where('lesson_id', $lid)
                                          ->where('term_id', $tId)
                                          ->where('exam_type', '1');
                 if ($room) $examQuery = $examQuery->where('room_id', $room->id);
                 $examMax = $examQuery->max('result');
                 
                 $total = 0;
                 $count = 0;
                 if(!is_null($oralAvg)) { $total += round($oralAvg,1); $count++; }
                 if(!is_null($quizAvg)) { $total += round($quizAvg,1); $count++; }
                 if(!is_null($examMax)) { $total += $examMax; $count++; }
                 
                 // Return detailed array + total
                 return [
                     'total' => $count > 0 ? $total : null,
                     'details' => [
                         'oral' => !is_null($oralAvg) ? round($oralAvg,1) : null,
                         'quize' => !is_null($quizAvg) ? round($quizAvg,1) : null,
                         'exam' => !is_null($examMax) ? $examMax : null
                     ]
                 ];
            };

            $val1 = $processTerm($term1Id);
            $val2 = $processTerm($term2Id);

            $studentMarks[] = [
                'name' => $subject->name,
                'term1' => $val1, // Contains ['total'=>, 'details'=>]
                'term2' => $val2,
                'total' => (($val1['total'] ?? 0) + ($val2['total'] ?? 0))
            ];
        }

        return view('admin.gradebook.view_by_student', compact('student', 'studentMarks'));
    }
}
