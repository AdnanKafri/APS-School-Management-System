<?php

namespace App\Services;

use App\Classe;
use App\Certificate;
use App\Exam_file;
use App\Exam_result;
use App\Exam_result2;
use App\Lesson;
use App\Report_card;
use App\Room;
use App\Room_student;
use App\Student;
use App\StudentAcademicPlacement;
use App\Students_mark;
use App\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTransferService
{
    private $bulkMode = false;
    private $bulkLastSucceeded = false;

    public function handleBulk(Request $request): RedirectResponse
    {
        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'required|integer',
            'class_change_id' => 'required|integer',
            'room_change_id' => 'required|integer',
        ]);

        $this->bulkMode = true;
        $successes = 0;
        $failures = [];
        $studentIds = array_values(array_unique(array_map('intval', $request->student_ids)));

        foreach ($studentIds as $studentId) {
            $this->bulkLastSucceeded = false;
            try {
                $singleRequest = Request::create('', 'POST', [
                    'student_id' => $studentId,
                    'class_change_id' => $request->class_change_id,
                    'room_change_id' => $request->room_change_id,
                ]);
                $this->handle($singleRequest);
                if ($this->bulkLastSucceeded) {
                    $successes++;
                } else {
                    throw new \RuntimeException('student_transfer.notifications.transfer_failed');
                }
            } catch (\Throwable $e) {
                report($e);
                $student = Student::find($studentId);
                $key = $e->getMessage();
                $translated = __($key);
                $failures[] = [
                    'student_id' => $studentId,
                    'student_name' => $student ? trim($student->first_name . ' ' . $student->last_name) : (string) $studentId,
                    'reason' => $translated === $key ? __('student_transfer.notifications.transfer_failed') : $translated,
                ];
            }
        }

        $this->bulkMode = false;
        $message = __('student_transfer.notifications.bulk_result', ['success' => $successes, 'failed' => count($failures)]);
        return redirect()->back()->with(count($failures) ? 'warning' : 'success', $message)->with('student_transfer_failures', $failures);
    }

    public function handle(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => 'required|integer',
            'class_change_id' => 'required|integer',
            'room_change_id' => 'required|integer',
        ]);

        $year = Year::where('current_year', '1')->first();
        if (!$year) {
            return $this->warning('student_transfer.validation.transfer_active_year_missing');
        }

        $student = Student::find($request->student_id);
        if (!$student) {
            return $this->warning('student_transfer.validation.transfer_student_missing');
        }
        if (!$student->isActiveLifecycle()) {
            return $this->warning('student_lifecycle.errors.student_not_operational');
        }

        $targetClass = Classe::find($request->class_change_id);
        if (!$targetClass) {
            return $this->warning('student_transfer.validation.transfer_class_invalid');
        }

        $targetRoom = Room::find($request->room_change_id);
        if (!$targetRoom || (int) $targetRoom->class_id !== (int) $targetClass->id) {
            return $this->warning('student_transfer.validation.transfer_room_invalid');
        }

        if ((int) $targetRoom->year_id !== (int) $year->id) {
            return $this->warning('student_transfer.validation.transfer_room_year_mismatch');
        }

        $currentEnrollments = Room_student::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->orderBy('id')
            ->get();

        if ($currentEnrollments->count() !== 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_enrollment');
        }

        $currentEnrollment = $currentEnrollments->first();
        $currentRoom = Room::find($currentEnrollment->room_id);
        if (!$currentRoom || (int) $currentRoom->year_id !== (int) $year->id) {
            return $this->warning('student_transfer.validation.transfer_requires_current_enrollment');
        }

        if ((int) $currentEnrollment->room_id === (int) $targetRoom->id) {
            return $this->warning('student_transfer.notifications.transfer_no_change');
        }

        $currentMarks = Students_mark::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->where('room_id', $currentRoom->id)
            ->orderBy('id')
            ->get();

        if ($currentMarks->count() > 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_marks');
        }

        $currentReportCards = Report_card::where('student_id', $student->id)
            ->where('year_id', $year->id)
            ->where('room_id', $currentRoom->id)
            ->orderBy('id')
            ->get();

        if ($currentReportCards->count() > 1) {
            return $this->warning('student_transfer.validation.transfer_conflicting_report_card');
        }

        $currentMark = $currentMarks->first();
        $currentReportCard = $currentReportCards->first();
        $currentClassId = (int) $currentRoom->class_id;
        $targetClassId = (int) $targetClass->id;
        if ($this->hasUnscopedAcademicActivity($student->id, $year->id)
            || ($this->hasMeaningfulMarkData($currentMark) && !$this->recordBelongsToRoom($currentMark, $currentRoom->id))
            || ($this->hasMeaningfulReportCardData($currentReportCard) && !$this->recordBelongsToRoom($currentReportCard, $currentRoom->id))) {
            return $this->warning('student_transfer.validation.transfer_existing_assessments');
        }

        try {
            DB::transaction(function () use (
                $request,
                $student,
                $year,
                $targetRoom,
                $targetClassId,
                $currentClassId,
                $currentEnrollment,
                $currentMark,
                $currentReportCard,
                $currentRoom
            ) {
                $currentPlacement = StudentAcademicPlacement::where('student_id', $student->id)
                    ->where('year_id', $year->id)
                    ->where('status', 'active')
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->first();

                if (!$currentPlacement) {
                    $currentPlacement = StudentAcademicPlacement::create([
                        'student_id' => $student->id,
                        'year_id' => $year->id,
                        'class_id' => $currentClassId,
                        'room_id' => $currentRoom->id,
                        'effective_from' => $currentEnrollment->created_at ?: now(),
                        'status' => 'active',
                        'reason' => 'legacy_sync',
                        'action_source' => 'legacy_room_student',
                    ]);
                }

                if ((int) $currentPlacement->room_id !== (int) $currentEnrollment->room_id) {
                    throw new \RuntimeException('The active placement does not match the legacy enrollment.');
                }

                $currentPlacement->effective_to = now();
                $currentPlacement->status = 'closed';
                $currentPlacement->save();

                $targetPlacement = StudentAcademicPlacement::create([
                    'student_id' => $student->id,
                    'year_id' => $year->id,
                    'class_id' => $targetClassId,
                    'room_id' => $targetRoom->id,
                    'effective_from' => now(),
                    'status' => 'active',
                    'reason' => $currentClassId === $targetClassId ? 'manual_room_transfer' : 'manual_class_transfer',
                    'action_source' => 'admin_transfer',
                    'actioned_by' => optional(auth()->user())->id,
                ]);

                DB::table('student_transfer_histories')->insert([
                    'student_id' => $student->id,
                    'user_id' => optional($student->user)->id,
                    'year_id' => $year->id,
                    'from_class_id' => $currentClassId,
                    'from_room_id' => $currentRoom->id,
                    'to_class_id' => $targetClassId,
                    'to_room_id' => $targetRoom->id,
                    'previous_room_student_id' => $currentEnrollment->id,
                    'previous_students_mark_id' => optional($currentMark)->id,
                    'previous_report_card_id' => optional($currentReportCard)->id,
                    'previous_room_student_snapshot' => json_encode($currentEnrollment->toArray(), JSON_UNESCAPED_UNICODE),
                    'previous_students_mark_snapshot' => $currentMark ? json_encode($currentMark->toArray(), JSON_UNESCAPED_UNICODE) : null,
                    'previous_report_card_snapshot' => $currentReportCard ? json_encode($currentReportCard->toArray(), JSON_UNESCAPED_UNICODE) : null,
                    'transferred_by_user_id' => optional(auth()->user())->id,
                    'from_placement_id' => $currentPlacement->id,
                    'to_placement_id' => $targetPlacement->id,
                    'transfer_type' => $currentClassId === $targetClassId
                        ? 'same_class_room_current_year'
                        : 'cross_grade_current_year',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $currentEnrollment->room_id = $targetRoom->id;
                $currentEnrollment->save();

                Students_mark::create($this->buildStudentMarkPayload($student, $targetClassId, $targetRoom->id, $year->id, $request));
                $this->createStudentReportCard($student->id, $targetRoom->id, $year->id, $targetClassId);
            });
        } catch (\Throwable $e) {
            report($e);

            return $this->warning('student_transfer.notifications.transfer_failed');
        }

        $this->bulkLastSucceeded = true;
        if ($this->bulkMode) {
            return redirect()->back();
        }

        if ($currentClassId === $targetClassId) {
            return redirect()->back()->with('success', __('student_transfer.notifications.room_updated'));
        }

        return redirect()->back()->with('success', __('student_transfer.notifications.transferred'));
    }

    private function hasMeaningfulMarkData(?Students_mark $mark): bool
    {
        if (!$mark) {
            return false;
        }

        foreach (['mark', 'mark2', 'result1', 'result2', 'result', 'term_result', 'year_result'] as $field) {
            $hasValue = in_array($field, ['term_result', 'year_result'], true)
                ? $this->containsNonZeroAcademicValue($mark->{$field})
                : $this->containsAcademicValue($mark->{$field});

            if ($hasValue) {
                return true;
            }
        }

        return false;
    }

    private function hasMeaningfulReportCardData(?Report_card $reportCard): bool
    {
        if (!$reportCard) {
            return false;
        }

        foreach (['teacher', 'teacher_notes', 'final_result', 'manager_notes', 'parent_notes', 'actual_attendance', 'student_attendance', 'justified_absence', 'unjustified_absence', 'teacher_name'] as $field) {
            $value = $reportCard->{$field};
            if ($field === 'final_result' && (string) $value === '1') {
                continue;
            }

            if ($this->containsAcademicValue($value)) {
                return true;
            }
        }

        return false;
    }

    private function containsAcademicValue($value): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->containsAcademicValue($decoded);
            }
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->containsAcademicValue($item)) {
                    return true;
                }
            }

            return false;
        }

        return $value !== null && $value !== '';
    }

    private function containsNonZeroAcademicValue($value): bool
    {
        if ($value === null || $value === '' || $value === 0 || $value === '0') {
            return false;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->containsNonZeroAcademicValue($decoded);
            }
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->containsNonZeroAcademicValue($item)) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }

    private function buildStudentMarkPayload(Student $student, int $classId, int $roomId, int $yearId, Request $request): array
    {
        $lessons = Lesson::where('class_id', $classId)->get();

        $mark = [];
        $mark2 = [];
        $result1 = [];
        $result2 = [];
        $result = [];

        foreach ($lessons as $lesson) {
            $mark[$lesson->id] = [
                'oral' => $request->oral,
                'homework' => $request->homework,
                'activities' => $request->activities,
                'quize' => $request->quize,
                'exam' => $request->exam,
            ];

            $mark2[$lesson->id] = [
                'oral' => $request->oral,
                'homework' => $request->homework,
                'activities' => $request->activities,
                'quize' => $request->quize,
                'exam' => $request->exam,
            ];

            $result1[$lesson->id] = [
                'term1_quizes' => null,
                'term1_exam' => null,
                'term1_result' => null,
            ];

            $result2[$lesson->id] = [
                'term2_quizes' => null,
                'term2_exam' => null,
                'term2_result' => null,
            ];

            $result[$lesson->id] = [
                'year_result' => null,
            ];
        }

        $languageFilter = (string) $student->lang === '0' ? '1' : ((string) $student->lang === '1' ? '0' : null);
        if ($languageFilter !== null) {
            foreach (Lesson::where('class_id', $classId)->where('lang', $languageFilter)->get() as $lesson) {
                unset($mark[$lesson->id], $mark2[$lesson->id], $result1[$lesson->id], $result2[$lesson->id], $result[$lesson->id]);
            }
        }

        $religionFilter = (string) $student->religion === '0' ? '1' : ((string) $student->religion === '1' ? '0' : null);
        if ($religionFilter !== null) {
            foreach (Lesson::where('class_id', $classId)->where('religion', $religionFilter)->get() as $lesson) {
                unset($mark[$lesson->id], $mark2[$lesson->id], $result1[$lesson->id], $result2[$lesson->id], $result[$lesson->id]);
            }
        }

        return [
            'student_id' => $student->id,
            'room_id' => $roomId,
            'year_id' => $yearId,
            'mark' => json_encode((object) $mark, JSON_UNESCAPED_UNICODE),
            'mark2' => json_encode((object) $mark2, JSON_UNESCAPED_UNICODE),
            'result1' => json_encode((object) $result1, JSON_UNESCAPED_UNICODE),
            'result2' => json_encode((object) $result2, JSON_UNESCAPED_UNICODE),
            'result' => json_encode((object) $result, JSON_UNESCAPED_UNICODE),
            'term_result' => json_encode(['term1' => 0, 'term2' => 0], JSON_UNESCAPED_UNICODE),
            'year_result' => 0,
            'status' => '1',
            'adjustable' => 0,
            'lang' => (string) $student->lang,
            'religion' => (string) $student->religion,
            'estimation' => null,
            'estimation1' => null,
            'estimation2' => null,
            'worke_degree' => null,
            'notes' => null,
            'key' => 0,
        ];
    }

    private function resetStudentReportCard(Report_card $reportCard, int $roomId, int $yearId, int $studentId, int $classId): void
    {
        $teacherNotes = ['term1' => null, 'term2' => null];
        $studentAttendance = ['term1' => null, 'term2' => null];
        $actualAttendance = ['term1' => null, 'term2' => null];
        $justifiedAbsence = ['term1' => null, 'term2' => null];
        $unjustifiedAbsence = ['term1' => null, 'term2' => null];

        $reportCard->room_id = $roomId;
        $reportCard->year_id = $yearId;
        $reportCard->student_id = $studentId;
        $reportCard->class = $classId;
        $reportCard->teacher = null;
        $reportCard->teacher_name = null;
        $reportCard->teacher_notes = json_encode($teacherNotes, JSON_UNESCAPED_UNICODE);
        $reportCard->manager_notes = null;
        $reportCard->parent_notes = null;
        $reportCard->final_result = 1;
        $reportCard->student_attendance = json_encode($studentAttendance, JSON_UNESCAPED_UNICODE);
        $reportCard->actual_attendance = json_encode($actualAttendance, JSON_UNESCAPED_UNICODE);
        $reportCard->justified_absence = json_encode($justifiedAbsence, JSON_UNESCAPED_UNICODE);
        $reportCard->unjustified_absence = json_encode($unjustifiedAbsence, JSON_UNESCAPED_UNICODE);
        $reportCard->save();
    }

    private function warning(string $translationKey): RedirectResponse
    {
        if ($this->bulkMode) {
            throw new \RuntimeException($translationKey);
        }

        return redirect()->back()->with('warning', __($translationKey));
    }

    private function hasUnscopedAcademicActivity(int $studentId, int $yearId): bool
    {
        return Exam_result::where('user_id', $studentId)->whereNull('room_id')->exists()
            || Exam_result2::where('user_id', $studentId)->whereNull('room_id')->exists()
            || DB::table('student_lesson_teacher_room_term_exam')
                ->where('student_id', $studentId)
                ->whereNull('room_id')
                ->exists()
            || Exam_file::where('student_id', $studentId)->whereNull('room_id')->exists()
            || Certificate::where('student_id', $studentId)->whereNull('room_id')->exists()
            || Students_mark::where('student_id', $studentId)
                ->where('year_id', $yearId)
                ->whereNull('room_id')
                ->exists()
            || Report_card::where('student_id', $studentId)
                ->where('year_id', $yearId)
                ->whereNull('room_id')
                ->exists();
    }

    private function recordBelongsToRoom($record, int $roomId): bool
    {
        return $record && (int) $record->room_id === $roomId;
    }

    private function createStudentReportCard(int $studentId, int $roomId, int $yearId, int $classId): void
    {
        $reportCard = new Report_card();
        $reportCard->student_id = $studentId;
        $reportCard->room_id = $roomId;
        $reportCard->year_id = $yearId;
        $reportCard->class = $classId;
        $reportCard->teacher = null;
        $reportCard->teacher_name = null;
        $reportCard->teacher_notes = json_encode(['term1' => null, 'term2' => null], JSON_UNESCAPED_UNICODE);
        $reportCard->manager_notes = null;
        $reportCard->parent_notes = null;
        $reportCard->final_result = 1;
        $reportCard->student_attendance = json_encode(['term1' => null, 'term2' => null], JSON_UNESCAPED_UNICODE);
        $reportCard->actual_attendance = json_encode(['term1' => null, 'term2' => null], JSON_UNESCAPED_UNICODE);
        $reportCard->justified_absence = json_encode(['term1' => null, 'term2' => null], JSON_UNESCAPED_UNICODE);
        $reportCard->unjustified_absence = json_encode(['term1' => null, 'term2' => null], JSON_UNESCAPED_UNICODE);
        $reportCard->save();
    }
}
