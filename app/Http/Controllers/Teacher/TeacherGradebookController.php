<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Exam_result2;
use App\Exams2;
use App\Lesson;
use App\Room;
use App\Student;
use App\Teacher_room_lesson;
use App\Term_year;
use App\Year;
use App\Services\AssessmentResultSafety;
use App\Services\GradebookConfigService;
use App\Services\GradebookReadService;
use App\Services\GradebookStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherGradebookController extends Controller
{
    private function currentContext($roomId, $subjectId, $studentId = null)
    {
        $yearQuery = Year::where('current_year', 1);
        if (DB::transactionLevel() > 0) { $yearQuery->lockForUpdate(); }
        $year = $yearQuery->first();
        abort_unless($year, 422, __('gradebook.context_invalid'));
        $room = Room::whereKey($roomId)->where('year_id', $year->id)->firstOrFail();
        $term = Term_year::where('year_id', $year->id)->where('current_term', 1)->first();
        abort_unless($term, 422, __('gradebook.term_missing'));
        abort_unless(Lesson::whereKey($subjectId)->where('class_id', $room->class_id)->exists()
            && app(\App\Services\CurrentTeacherAssignments::class)->has(Auth::user()->teacher_id, $room->id, $subjectId), 403);
        if ($studentId !== null) {
            abort_unless(Student::currentMembership($year->id, $room->id)->whereKey($studentId)->exists(), 403);
        }
        return [$year, $term, $room];
    }

    public function index($class_id, $room_id, $subject_id)
    {
        [$year, $term, $room] = $this->currentContext($room_id, $subject_id);
        abort_unless((int) $class_id === (int) $room->class_id, 403);
        $subject = Lesson::findOrFail($subject_id);
        $students = $room->operationalStudents()->orderBy('first_name')->get();
        $gradebook = app(GradebookReadService::class)->read($room, $subject, $students->pluck('id'), [$term->id]);
        $assessmentColumns = app(\App\Services\TeacherGradebookAssessmentColumns::class)
            ->forContext($gradebook, $room, $subject, $term);
        $occurrenceKeys = $assessmentColumns->keyBy('key');
        $sourceGradebook = array_replace($gradebook, ['assessments' => $gradebook['assessments']->reject(function ($assessment) use ($occurrenceKeys) {
            return $occurrenceKeys->has($assessment['key']);
        })]);
        $components = $gradebook['components'];
        $existingMarks = [];
        foreach ($components as $component) {
            $component->calculated_max = GradebookReadService::componentMaximum($component, $subject);
        }
        foreach ($students as $student) {
            $existingMarks[$student->id] = $gradebook['marks'][$student->id][$term->id] ?? [];
            $student->gradebook_total = $existingMarks[$student->id]['total'] ?? null;
        }
        $gradebookStatus = GradebookStatusService::getStatus($room->class_id, $term->id);
        $teacher = \App\Teacher::findOrFail(Auth::user()->teacher_id);
        $message = \App\Message::where('teacher_id', $teacher->id)->where('type', 1)->where('view', 0)->count();
        return view('teachers.gradebook.index', compact('room', 'subject', 'students', 'components',
            'existingMarks', 'term', 'teacher', 'message', 'year', 'gradebookStatus', 'gradebook',
            'assessmentColumns', 'sourceGradebook'));
    }

    public function saveMark(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer', 'component_id' => 'required|string',
            'room_id' => 'required|integer', 'subject_id' => 'required|integer',
            'value' => 'present|nullable|numeric|min:0',
        ]);
        return DB::transaction(function () use ($request) {
            // The shared section lock serializes container creation; the student
            // lock serializes membership against the existing transfer service.
            Student::whereKey($request->student_id)->lockForUpdate()->firstOrFail();
            Room::whereKey($request->room_id)->lockForUpdate()->firstOrFail();
            [$year, $term, $room] = $this->currentContext($request->room_id, $request->subject_id, $request->student_id);
            abort_unless(GradebookStatusService::getStatus($room->class_id, $term->id) === 'OPEN', 403, __('gradebook.locked'));
            // Serialize manual container creation against Admin structural configuration changes.
            $subject = Lesson::whereKey($request->subject_id)->lockForUpdate()->firstOrFail();
            $component = GradebookConfigService::getConfig($subject->id, $year->id)->first(function ($c) use ($request) {
                return (string) $c->id === (string) $request->component_id;
            });
            abort_unless($component, 404);
            abort_unless(\App\Services\GradebookComponentEntry::manual($component), 422, __('gradebook.read_only'));
            $maximum = GradebookReadService::componentMaximum($component, $subject);
            abort_unless(\App\Services\GradebookComponentEntry::supportedMaximum($maximum), 422, __('gradebook_ux.manual_bound'));
            $value = $request->value;
            if ($value !== null && $value !== '') {
                AssessmentResultSafety::validateMark($value, $maximum, 'value');
            }
            $name = 'Dynamic_Section_' . (int) $component->data_source;
            $containers = Exams2::where('class_id', $room->class_id)->where('room_id', $room->id)
                ->where('lesson_id', $subject->id)->where('term_id', $term->id)->where('type', 1)
                ->where('name', $name)->lockForUpdate()->get();
            if ($containers->count() > 1) {
                AssessmentResultSafety::reject('ambiguous_result');
            }
            $exam = $containers->first();
            $result = null;
            if ($exam) {
                $rows = Exam_result2::where('exam_id', $exam->id)->where('user_id', $request->student_id)->lockForUpdate()->get();
                if ($rows->count() > 1) {
                    AssessmentResultSafety::reject('ambiguous_result');
                }
                $result = $rows->first();
                if ($result) {
                    AssessmentResultSafety::assertResultContext($result, $exam);
                }
            }
            if ($value === null || $value === '') {
                if ($result && AssessmentResultSafety::hasEarnedData($result)) {
                    AssessmentResultSafety::reject('clear_protected', 'value');
                }
            } else {
                if (!$exam) {
                    $exam = new Exams2();
                    $exam->forceFill([
                        'user_id' => Auth::id(), 'class_id' => $room->class_id, 'room_id' => $room->id,
                        'lesson_id' => $subject->id, 'term_id' => $term->id, 'name' => $name, 'type' => 1,
                        'is_file' => 0, 'question_picker' => 0, 'required' => 0,
                        'groupe' => ((int) Exams2::max('groupe')) + 1,
                        'start_date' => now(), 'end_date' => now()->addYear(), 'mark' => $maximum,
                        'period' => 0, 'notes' => 'Auto-generated container for dynamic gradebook section',
                    ])->save();
                }
                $result = $result ?: new Exam_result2();
                $result->forceFill([
                    'user_id' => $request->student_id, 'exam_id' => $exam->id,
                    'room_id' => $room->id, 'class_id' => $room->class_id, 'lesson_id' => $subject->id,
                    'term_id' => $term->id, 'type' => (string) $exam->type, 'result' => $value, 'status' => '1',
                ])->save();
            }
            $read = app(GradebookReadService::class)->read($room, $subject, [$request->student_id], [$term->id]);
            return response()->json(['success' => true, 'value' => $result ? $result->result : null,
                'total' => $read['marks'][$request->student_id][$term->id]['total'], 'message' => __('gradebook.saved')]);
        }, 3);
    }

    public function saveAssessment(Request $request)
    {
        $request->validate(['student_id'=>'required|integer','exam_id'=>'required|integer',
            'room_id'=>'required|integer','subject_id'=>'required|integer','value'=>'required|numeric|min:0']);
        return DB::transaction(function () use ($request) {
            Student::whereKey($request->student_id)->lockForUpdate()->firstOrFail();
            [$year, $term, $room] = $this->currentContext($request->room_id, $request->subject_id, $request->student_id);
            $exam = Exams2::whereKey($request->exam_id)->lockForUpdate()->firstOrFail();
            abort_unless((int)$exam->room_id === (int)$room->id && (int)$exam->lesson_id === (int)$request->subject_id
                && (int)$exam->term_id === (int)$term->id && (int)$exam->class_id === (int)$room->class_id,403);
            app(\App\Services\AssessmentEntryWindow::class)->assertWritable($exam);
            $before = Exam_result2::where('exam_id',$exam->id)->where('user_id',$request->student_id)->first();
            $changed = !$before || GradebookReadService::number($before->result) !== GradebookReadService::number($request->value);
            $record = app(\App\Services\TeacherAssessmentService::class)->save($exam->id,$request->student_id,
                $room->id,$request->subject_id,$request->value);
            if ($changed) {
                $notification = new \App\Notification();
                $notification->forceFill(['user_id'=>Auth::id(),'student_id'=>$request->student_id,
                    'room_id'=>$room->id,'lesson_id'=>$exam->lesson_id,'term_id'=>$term->id,
                    'title'=>__('gradebook.saved'),'body'=>$exam->name,'type'=>(int)$exam->type === 2 ? 4 : 5])->save();
            }
            $read = app(GradebookReadService::class)->read($room,Lesson::findOrFail($request->subject_id),[$request->student_id],[$term->id]);
            return response()->json(['success'=>true,'value'=>$record->result,'result_id'=>$record->id,
                'exam_id'=>$exam->id,'components'=>$read['marks'][$request->student_id][$term->id],
                'total'=>$read['marks'][$request->student_id][$term->id]['total'],'message'=>__('gradebook.saved')]);
        },3);
    }
}
