<?php

namespace App\Services;

use App\Student;
use App\Students_mark;
use App\Exam_result;
use App\Exam_result2;
use App\Year;
use App\Term_year;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradebookAggregationService
{
    /**
     * STRICT Context-Aware Aggregation
     * 
     * @param int $roomId
     * @param int $lessonId
     * @param int $yearId
     * @return array
     */
    public function aggregateRoomSubject($roomId, $lessonId, $yearId)
    {
        DB::beginTransaction();
        try {
            // 1. Context Validation
            $room = \App\Room::find($roomId);
            if (!$room) throw new \Exception("Room $roomId not found");
            
            // 2. Identify Terms for this Year (ROBUST FIX)
            $terms = Term_year::where('year_id', $yearId)->get();
            
            // Term 1 (First Semester)
            $term1Obj = $terms->where('type', '1')->where('current_term', 1)->first();
            if (!$term1Obj) $term1Obj = $terms->where('type', '1')->sortByDesc('id')->first(); // Fallback to latest

            // Term 2 (Second Semester)
            $term2Obj = $terms->where('type', '2')->where('current_term', 1)->first();
            if (!$term2Obj) $term2Obj = $terms->where('type', '2')->sortByDesc('id')->first(); // Fallback to latest

            $term1Id = $term1Obj ? $term1Obj->id : null;
            $term2Id = $term2Obj ? $term2Obj->id : null;

            // 3. Iterate Students in Room
            // using exact relation: room -> students
            $students = $room->student; 
            $count = 0;

            foreach ($students as $student) {
                // 4. Fetch/Create Mark Row for (Student, Room, Year)
                $markRow = Students_mark::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'year_id' => $yearId, 
                        'room_id' => $room->id
                    ],
                    [
                        'mark' => '{}',
                        'mark2' => '{}'
                    ]
                );

                // 5. Prepare JSON data
                $markJson = json_decode($markRow->mark, true) ?? [];
                $mark2Json = json_decode($markRow->mark2, true) ?? [];
                $updated = false;

                // 6. Term 1 Aggregation
                if ($term1Id) {
                    $vals = $this->calculateTermMarks($student->id, $lessonId, $roomId, $term1Id, $yearId);
                    if ($vals) {
                        // Merge into lesson_id key
                        if (!isset($markJson[$lessonId])) $markJson[$lessonId] = [];
                        foreach($vals as $k => $v) $markJson[$lessonId][$k] = $v;
                        $updated = true;
                    }
                }

                // 7. Term 2 Aggregation
                if ($term2Id) {
                    $vals = $this->calculateTermMarks($student->id, $lessonId, $roomId, $term2Id, $yearId);
                    if ($vals) {
                        if (!isset($mark2Json[$lessonId])) $mark2Json[$lessonId] = [];
                        foreach($vals as $k => $v) $mark2Json[$lessonId][$k] = $v;
                        $updated = true;
                    }
                }

                // 8. Save if changed
                if ($updated) {
                    $markRow->mark = json_encode($markJson);
                    $markRow->mark2 = json_encode($mark2Json);
                    $markRow->save();
                    $count++;
                }
            }

            DB::commit();
            return ['status' => 'success', 'message' => "Updated marks for subject $lessonId in room $roomId ($count students updated)"];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Aggregation Failed: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Calculate all mark types for a specific Term
     */
    private function calculateTermMarks($studentId, $lessonId, $roomId, $termId, $yearId)
    {
        $data = [];

        // A. ORAL / HOMEWORK (From Exam_result)
        // Logic: lesson_id is direct.
        $oralAvg = Exam_result::where('user_id', $studentId)
                              ->where('lesson_id', $lessonId)
                              ->where('term_id', $termId) // Important: Filter by Term
                              ->where('status', '1')      // Confirmed
                              ->avg('result');
        
        if (!is_null($oralAvg)) {
            $data['oral'] = round($oralAvg, 1);
        }

        // B. MID / QUIZ (From Exam_result2 JOIN exams2)
        // Logic: type=2 (Quiz) --> Mapped to "quize" key in legacy JSON
        $midAvg = Exam_result2::join('exams2', 'exam_result2.exam_id', '=', 'exams2.id')
                              ->where('exam_result2.user_id', $studentId)
                              ->where('exams2.lesson_id', $lessonId) // Link via Exam
                              ->where('exams2.room_id', $roomId)     // Link via Room (Strict)
                              ->where('exam_result2.term_id', $termId)
                              ->where('exams2.type', '2') // Quiz
                              ->avg('exam_result2.result');

        if (!is_null($midAvg)) {
            $data['quize'] = round($midAvg, 1); // FIXED: Key 'mid' -> 'quize'
        }

        // C. FINAL EXAM (From Exam_result2 JOIN exams2)
        // Logic: type=1 (Exam) --> Mapped to "exam" key in legacy JSON
        $examMax = Exam_result2::join('exams2', 'exam_result2.exam_id', '=', 'exams2.id')
                               ->where('exam_result2.user_id', $studentId)
                               ->where('exams2.lesson_id', $lessonId)
                               ->where('exams2.room_id', $roomId)
                               ->where('exam_result2.term_id', $termId)
                               ->where('exams2.type', '1') // Exam
                               ->max('exam_result2.result');

        if (!is_null($examMax)) {
            $data['exam'] = $examMax;
        }

        return count($data) > 0 ? $data : null;
    }
}
