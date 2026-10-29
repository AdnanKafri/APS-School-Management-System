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
            if ((int) $room->year_id !== (int) $yearId || !Year::whereKey($yearId)->where('current_year', 1)->exists()
                || !\App\Lesson::whereKey($lessonId)->where('class_id', $room->class_id)->exists()) {
                AssessmentResultSafety::reject('context_invalid');
            }
            
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
            $students = $room->operationalStudents()->orderBy('students.id')->lockForUpdate()->get();
            $count = 0;

            foreach ($students as $student) {
                $existing = Students_mark::where('student_id', $student->id)->where('year_id', $yearId)
                    ->where('room_id', $roomId)->lockForUpdate()->get();
                if ($existing->count() > 1) AssessmentResultSafety::reject('ambiguous_result');
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
                foreach (['mark', 'mark2'] as $field) {
                    if ($markRow->$field && !is_array(json_decode($markRow->$field, true))) {
                        AssessmentResultSafety::reject('ambiguous_result');
                    }
                }
                $updated = false;

                // 6. Term 1 Aggregation
                if ($term1Id) {
                    $vals = $this->calculateTermMarks($student->id, $lessonId, $roomId, $term1Id, $yearId);
                    if ($vals) {
                        $this->assertReportEditable($markRow, 0);
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
                        $this->assertReportEditable($markRow, 1);
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
        $read = app(GradebookReadService::class)->read(\App\Room::findOrFail($roomId),
            \App\Lesson::findOrFail($lessonId), [$studentId], [$termId]);
        if (count($read['issues'])) {
            AssessmentResultSafety::reject('ambiguous_result');
        }
        $data = [];
        foreach (['oral' => 'LEGACY_ORAL', 'quize' => 'LEGACY_HOMEWORK', 'exam' => 'LEGACY_EXAM'] as $key => $source) {
            $values = $read['assessments']->where('source', $source)->map(function ($assessment) use ($studentId) {
                return $assessment['results'][$studentId]['value'] ?? null;
            })->filter(function ($value) { return $value !== null; });
            if ($values->isNotEmpty()) {
                $data[$key] = round($key === 'exam' ? $values->max() : $values->avg(), 1);
            }
        }
        return $data ?: null;
    }

    private function assertReportEditable(Students_mark $marks, $editableState)
    {
        if ($marks->adjustable != $editableState || \App\Report_card::where('student_id', $marks->student_id)
            ->where('year_id', $marks->year_id)->where('room_id', $marks->room_id)
            ->where('adjustable', '<>', $editableState)->exists()) {
            AssessmentResultSafety::reject('report_locked');
        }
    }
}
