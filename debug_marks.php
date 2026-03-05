<?php
use App\Student;
use App\Exam_result;
use App\Exam_result2;
use App\Students_mark;
use App\Year;
use App\Term_year;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$studentId = 412; 
$year = Year::where('current_year', '1')->first();
if (!$year) die("No current year\n");
$yearId = $year->id;

echo "\n--- DEBUG START: Student $studentId (Year: $yearId) ---\n";

$student = Student::find($studentId);
if(!$student) die("Student not found\n");

$rooms = $student->room;
if($rooms->isEmpty()) die("Student has no rooms\n");

foreach($rooms as $room) {
    echo "\n[ROOM] ID: " . $room->id . " (" . $room->name . ")\n";
    $class = $room->classes; 
    
    if(!$class) { echo "  No Class linked.\n"; continue; }
    echo "  [CLASS] ID: " . $class->id . " (" . $class->name . ")\n";

    $lessons = $class->lessons; // Verify class->lessons relation? Usually hasMany. assuming yes.
    echo "  [LESSONS] Total: " . $lessons->count() . "\n";

    foreach($lessons as $lesson) {
        $lid = $lesson->id;
        
        // 1. CHECK SOURCE DATA (Exam_result - Oral)
        $oralCount = Exam_result::where('user_id', $studentId)->where('lesson_id', $lid)->count();
        if ($oralCount > 0) {
            $oralRow = Exam_result::where('user_id', $studentId)->where('lesson_id', $lid)->first();
            echo "    -> Lesson $lid: FOUND ORAL (Exam_result). Result: {$oralRow->result}, Term: {$oralRow->term_id}\n";
        }

        // 2. CHECK SOURCE DATA (Exam_result2 - Quiz/Exam)
        // STRICT CHECK: Join exams2
        $quizRows = DB::table('exam_result2')
            ->join('exams2', 'exam_result2.exam_id', '=', 'exams2.id')
            ->where('exam_result2.user_id', $studentId)
            ->where('exams2.lesson_id', $lid)
            ->select('exam_result2.result', 'exam_result2.term_id', 'exams2.type', 'exams2.room_id')
            ->get();
            
        if ($quizRows->count() > 0) {
            foreach($quizRows as $q) {
                echo "    -> Lesson $lid: FOUND EXAM2 (Type {$q->type}). Result: {$q->result}, Term: {$q->term_id}, Room: {$q->room_id}\n";
            }
        }
    }
    
    // 3. CHECK DESTINATION DATA (Students_mark)
    $markRow = Students_mark::where('student_id', $studentId)->where('room_id', $room->id)->where('year_id', $yearId)->first();
    if($markRow) {
        echo "\n  [DESTINATION] Students_mark Row Found (ID: {$markRow->id})\n";
        echo "    Mark Corrected JSON (Term 1): " . $markRow->mark . "\n";
        echo "    Mark2 Corrected JSON (Term 2): " . $markRow->mark2 . "\n";
    } else {
        echo "\n  [DESTINATION] NO students_mark row found for Room {$room->id}!\n";
    }
}
echo "--- DEBUG END ---\n";
