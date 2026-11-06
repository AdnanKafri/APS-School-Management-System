<?php

namespace App\Services;

use App\Exams2;
use App\Lesson;
use App\Room;
use App\Term_year;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminAssessmentInput
{
    public function allowedAllSections($type, Room $room)
    {
        return Room::where('class_id', $room->class_id)->where('year_id', $room->year_id)
            ->whereIn('id', \App\Classes_room_role_exam::where('role_id', auth()->user()->role_id)
                ->where('roles', (int) $type === 2 ? 'quizes' : 'exams')->select('room_id'))->get();
    }

    public function validate(Request $request, $type, Exams2 $exam = null)
    {
        $clock = app(AssessmentEntryWindow::class);
        foreach (['start_date','end_date'] as $key) {
            $date = $clock->date($request->input($key));
            if (!$date) throw ValidationException::withMessages([$key=>__('assessment_entry.invalid_dates')]);
            $request->merge([$key=>$date->format('Y-m-d H:i:s')]);
        }
        if (is_scalar($request->required_lectures)) $request->merge(['required_lectures'=>(string)$request->required_lectures]);
        $request->validate([
            'content_name'=>'required|string', 'lesson_id'=>'required|integer',
            'my_room_id'=>'sometimes|required|integer|min:1',
            'is_file'=>'required|in:0,1', 'question_picker'=>'required|in:1,2',
            'start_date'=>'required|date_format:Y-m-d H:i:s',
            'end_date'=>'required|date_format:Y-m-d H:i:s|after:start_date',
            'mark'=>'required|integer|min:1|max:2147483647',
            'period'=>'required|integer|min:0|max:2147483647',
            'required_lectures'=>'required|string', 'notes'=>'nullable|string|max:99',
        ], ['end_date.after'=>__('assessment_entry.invalid_dates')]);
        if (!$exam) {
            $request->validate(['room_id'=>'required|array|min:1', 'room_id.*'=>'required|integer|distinct|min:0']);
            if (in_array(0, $request->room_id) && count($request->room_id) !== 1) {
                throw ValidationException::withMessages(['room_id'=>__('assessment_entry.sections_exclusive')]);
            }
        }
        $year = Year::where('current_year',1)->first();
        $term = $year ? Term_year::where('year_id',$year->id)->where('current_term',1)->first() : null;
        $room = Room::whereKey($exam ? $exam->room_id : $request->input('my_room_id', $request->input('room_id.0')))
            ->where('year_id',$year ? $year->id : null)->first();
        if (!$room || !$term) {
            AssessmentResultSafety::reject('context_invalid', 'room_id');
        }
        if (!Lesson::whereKey($request->lesson_id)->where('class_id',$room->class_id)->exists()) {
            throw ValidationException::withMessages(['lesson_id'=>__('assessment_entry.subject_context')]);
        }
        if ((!$exam && (int) $request->class_id !== (int) $room->class_id)
            || ($exam && ((int) $exam->term_id !== (int) $term->id || (int) $exam->type !== (int) $type
                || (int) $exam->class_id !== (int) $room->class_id || (int) $request->room_id !== (int) $room->id))) {
            AssessmentResultSafety::reject('context_invalid', 'room_id');
        }
        if (!$exam && in_array(0, $request->room_id) && $this->allowedAllSections($type, $room)->isEmpty()) {
            throw ValidationException::withMessages(['room_id'=>__('assessment_entry.no_allowed_sections')]);
        }
        // Timing may be deliberately rescheduled by Admin; stored results never move or rescale.
        if ($exam && AssessmentResultSafety::hasRecords($exam)) {
            foreach (['lesson_id','mark','is_file','question_picker','period'] as $field) {
                if ((string) $exam->$field !== (string) $request->input($field)) AssessmentResultSafety::reject('retained_results');
            }
            $windowChanged = false;
            foreach (['start_date', 'end_date'] as $field) {
                $stored = $clock->date($exam->$field);
                if (!$stored || $stored->format('Y-m-d H:i:s') !== $request->input($field)) $windowChanged = true;
            }
            if ($windowChanged && !$request->boolean('confirm_window_change')) {
                throw ValidationException::withMessages(['confirm_window_change'=>__('assessment_entry.confirm_window')]);
            }
        }
    }
}
