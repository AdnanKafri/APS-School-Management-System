<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classe;
use App\Lesson;
use App\Room;
use App\Student;
use App\Year;
use App\Term_year;
use App\Services\GradebookConfigService;
use App\Exams2;
use App\Exam_result2;

class TeacherGradebookController extends Controller
{
    /**
     * Show the Gradebook Grid for a specific Class & Subject
     * Matches Admin Logic but for Teachers
     */
    public function index($class_id, $room_id, $subject_id)
    {
        $teacherId = Auth::user()->teacher_id;
        
        // Security: Verify Teacher owns this Room/Lesson
        // (Simplified check for now - can be enhanced)
        
        $room = Room::findOrFail($room_id);
        $subject = Lesson::findOrFail($subject_id);
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        // 1. Get Gradebook Configuration (Dynamic Sections)
        // CRITICAL: getConfig() returns Collection directly
        $components = GradebookConfigService::getConfig($subject->id, $year->id);
        
        // SORTING: Group Legacy (Read-Only) first, then Dynamic (Editable)
        // This ensures the Table View is visually grouped as requested
        $components = $components->sortBy(function($comp) {
            $isLegacy = is_string($comp->data_source) && strpos($comp->data_source, 'LEGACY_') === 0;
            // Legacy = 0, Dynamic = 1. Used for primary sort key.
            return $isLegacy ? 0 : 1;
        });


        // 2. Fetch Students
        $students = $room->student()->orderBy('first_name')->get();

        // 3. Fetch Existing Marks for this Term & Room & Subject
        // Strategy:
        // - Dynamic Sections: Look up by name pattern "Dynamic_Section_{ID}"
        // - Legacy Sections: Look up by exams2.type (1=Exam, 2=Homework/Quiz)
        
        $existingMarks = [];
        $studentIds = $students->pluck('id');
        
        // Build a map of exam_id to component_id for efficient lookup
        $examIdToComponentId = [];
        
        foreach ($components as $comp) {
            $dataSource = $comp->data_source;
            $exams = collect();

            if (is_numeric($dataSource) && $dataSource >= 100) {
                // Dynamic Section: Look for exams named "Dynamic_Section_{ID}"
                $containerName = "Dynamic_Section_{$dataSource}";
                $exams = Exams2::where('room_id', $room->id)
                    ->where('lesson_id', $subject->id)
                    ->where('term_id', $term->id) // Use term filter here
                    ->where('name', $containerName)
                    ->get();
            } elseif (is_string($dataSource) && strpos($dataSource, 'LEGACY_') === 0) {
                 // Legacy Section: Look for exams by Type
                 // LEGACY_EXAM = Type 1, LEGACY_HOMEWORK/QUIZ = Type 2
                 $type = ($dataSource === 'LEGACY_EXAM') ? 1 : 2;
                 
                 $exams = Exams2::where('room_id', $room->id)
                     ->where('lesson_id', $subject->id)
                     ->where('term_id', $term->id)
                     ->where('type', $type)
                     ->where(function($q) {
                         // Exclude Dynamic Sections to avoid double counting
                         $q->where('name', 'NOT LIKE', 'Dynamic_Section_%')
                           ->orWhereNull('name');
                     })
                     ->get();
            }

            foreach ($exams as $exam) {
                $examIdToComponentId[$exam->id] = $comp->id;
            }
        }

        
        // Fetch all relevant exam results
        // NOTE: We don't filter by term_id here because:
        // 1. term_id is NOT in Exam_result2 fillable array
        // 2. Term filtering is already handled via exam_id (exams2 has term_id)
        $examIds = array_keys($examIdToComponentId);
        $examRecords = Exam_result2::whereIn('user_id', $studentIds)
                                   ->whereIn('exam_id', $examIds)
                                   ->where('room_id', $room->id)
                                   ->get();
        
        // 4. Check Gradebook Status (OPEN/LOCKED)
        // Default to LOCKED if not explicitly opened by Admin
        $gradebookStatus = \App\Services\GradebookStatusService::getStatus($room->class_id, $term->id);

        // Map Marks: [StudentID][ComponentID] = Score
        // Calculate Total: Sum(Mark * Weight / 100) or Sum(Mark) if weights are raw scores
        
        foreach ($students as $student) {
            $totalScore = 0;
            $totalMaxWeight = 0; // To track if we have any data

            foreach ($components as $comp) {
                $score = null;
                $source = $comp->data_source ?? null;

                // Determine the exam_id(s) associated with this component
                $componentExamIds = collect($examIdToComponentId)->filter(function ($value) use ($comp) {
                    return $value === $comp->id;
                })->keys()->toArray();

                if (!empty($componentExamIds)) {
                    // Filter exam records for the current student and component's exams
                    $filteredRecords = $examRecords->where('user_id', $student->id)
                                                   ->whereIn('exam_id', $componentExamIds);

                    if ($filteredRecords->isNotEmpty()) {
                        // For simplicity, taking the average of results for this component
                        // This logic might need refinement based on how multiple exams for one component should be handled
                        $score = $filteredRecords->avg('result');
                    }
                }
                
                if (!is_null($score)) {
                    $existingMarks[$student->id][$comp->id] = round($score, 1);
                    
                    // Add to Total
                    // Assuming 'weight' is the max score for that section
                    // And the 'score' is the student's mark out of that weight.
                    $totalScore += $score;
                    $totalMaxWeight += $comp->weight;
                }
            }
            
            // Assign calculated total to student object for view display
            $student->gradebook_total = ($totalMaxWeight > 0) ? $totalScore : 0;
        }

        // Fetch Teacher Model for Layout
        $teacher = \App\Teacher::find($teacherId);
        
        // Fetch Unread Messages Count
        // Correct Logic from TeacherController_New::get_message
        // Columns: teacher_id, type=1 (Student->Teacher?), view=0 (Unread)
        $message = \App\Message::where('teacher_id', $teacherId)
                               ->where('type', 1)
                               ->where('view', 0)
                               ->count();
        // Fallback: If Message model/logic fails, default to 0 to prevent crash.
        // Actually, let's keep it simple to avoid errors. 
        if (!$teacher) {
            abort(403, 'Teacher profile not found.');
        }

        return view('teachers.gradebook.index', compact(
            'room', 
            'subject', 
            'students', 
            'components', 
            'existingMarks',
            'term',
            'teacher', // Required by layout
            'message',  // Required by layout
            'year',
            'gradebookStatus' // Pass status to view
        ));
    }

    /**
     * AJAX: Save a Student Mark
     * Handles ONLY Dynamic Sections (ID >= 100)
     * Legacy sections are rejected (read-only in this interface)
     */
    public function saveMark(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'component_id' => 'required',
            'room_id' => 'required',
            'subject_id' => 'required',
            // value can be null or numeric
        ]);

        $teacherId = Auth::user()->teacher_id;
        $roomId = $request->room_id;
        $subjectId = $request->subject_id;
        $year = Year::where('current_year', '1')->first();
        $term = Term_year::where('current_term', '1')->where('year_id', $year->id)->first();

        // 0. GATEKEEPER: Check Gradebook Status
        $currentClassId = Room::find($roomId)->class_id;
        $status = \App\Services\GradebookStatusService::getStatus($currentClassId, $term->id);
        
        if ($status !== 'OPEN') {
            return response()->json([
                'error' => 'The Gradebook is currently LOCKED by the Administrator.'
            ], 403);
        }

        // 1. Resolve Data Source (Exam Type) from Config
        $components = GradebookConfigService::getConfig($subjectId, $year->id);
        $component = null;
        
        foreach ($components as $comp) {
            if ($comp->id === $request->component_id) {
                $component = $comp;
                break;
            }
        }

        if (!$component) {
            return response()->json(['error' => 'Component not found'], 404);
        }

        $dataSource = $component->data_source ?? null;

        // 2. Reject Legacy Sections (They use separate entry flows)
        if (is_string($dataSource) && strpos($dataSource, 'LEGACY_') === 0) {
            return response()->json([
                'error' => 'Legacy sections cannot be edited here. Use the dedicated Exam/Homework pages.'
            ], 400);
        }

        // 3. Only Dynamic Sections (numeric ID >= 100) are allowed
        if (!is_numeric($dataSource) || $dataSource < 100) {
            return response()->json([
                'error' => 'Only dynamic sections can be edited in this interface.'
            ], 400);
        }

        $dynamicId = (int)$dataSource;

        // 4. Find or Create "Container Exam" using NAME-based identification
        // Pattern: "Dynamic_Section_{ID}"
        // We use exams2.type = 1 (standard exam) to avoid breaking legacy code
        $containerName = "Dynamic_Section_{$dynamicId}";
        
        $exam = Exams2::where('room_id', $roomId)
                      ->where('lesson_id', $subjectId)
                      ->where('term_id', $term->id)
                      ->where('name', $containerName)
                      ->where('type', 1)
                      ->first();

        if (!$exam) {
            // Auto-Create Container Exam (Metadata Only)
            // Based on legacy pattern from DashboardController::exam_store (lines 12168-12188)
            
            // Get latest exam for groupe increment
            $latestExam = Exams2::where('id', '>', '0')->latest('id')->first();
            
            $exam = new Exams2();
            
            // REQUIRED FIELDS (Core Identity)
            $exam->user_id = Auth::id(); // Creator's user account
            $exam->class_id = Room::find($roomId)->class_id;
            $exam->room_id = $roomId;
            $exam->lesson_id = $subjectId;
            $exam->term_id = $term->id;
            
            // REQUIRED FIELDS (Exam Definition)
            $exam->name = $containerName; // Name-based identification (CRITICAL)
            $exam->type = 1; // Standard exam type (avoid breaking legacy)
            
            // REQUIRED FIELDS (No Default Values)
            $exam->is_file = 0; // No file attachment
            $exam->question_picker = 0; // No question picker
            $exam->required = 0; // Not required
            $exam->groupe = isset($latestExam) ? $latestExam->groupe + 1 : 1; // Unique group ID
            
            // OPTIONAL FIELDS (Dates for record keeping)
            $exam->start_date = now();
            $exam->end_date = now()->addYear(); // Far future to never expire
            
            // OPTIONAL FIELDS (Can be NULL but good to set)
            $exam->mark = 100; // Default max mark
            $exam->period = 0; // No time limit
            $exam->notes = 'Auto-generated container for dynamic gradebook section';
            
            $exam->save();
        }

        // 5. Update Result in Exam_result2 (Actual Student Mark)
        $result = Exam_result2::where('user_id', $request->student_id)
                              ->where('exam_id', $exam->id)
                              ->first();

        if ($request->value === null || $request->value === '') {
            // Delete mark if cleared
            if ($result) {
                $result->delete();
            }
        } else {
            if (!$result) {
                $result = new Exam_result2();
                $result->user_id = $request->student_id;
                $result->exam_id = $exam->id;
                $result->room_id = $roomId;
                $result->class_id = $exam->class_id;
                $result->lesson_id = $subjectId;
            }
            
            // Store the actual mark
            $result->result = $request->value;
            $result->save();
        }

        return response()->json(['success' => true]);
    }
}
