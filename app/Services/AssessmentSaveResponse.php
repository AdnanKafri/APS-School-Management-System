<?php

namespace App\Services;

/** Server-confirmed presentation from original records, never a second mark store. */
final class AssessmentSaveResponse
{
    public function rows($records)
    {
        // Legacy screens have no component-total UI. Do not make a committed
        // original save depend on unrelated distribution configuration reads.
        return collect($records)->map(function ($record) {
            return ['student_id'=>$record->user_id, 'exam_id'=>$record->exam_id,
                'result_id'=>$record->id, 'value'=>$record->result, 'medal'=>$record->medal];
        })->values()->all();
    }

    public function single($record)
    {
        return response()->json(['success'=>true, 'message'=>__('gradebook.saved')] + $this->rows([$record])[0]);
    }
}
