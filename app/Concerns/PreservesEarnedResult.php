<?php

namespace App\Concerns;

use App\Services\AssessmentResultSafety;

trait PreservesEarnedResult
{
    protected static function bootPreservesEarnedResult()
    {
        static::deleting(function ($result) {
            if (AssessmentResultSafety::hasEarnedData($result)) {
                AssessmentResultSafety::reject('retained_results');
            }
        });
        static::updating(function ($result) {
            if (AssessmentResultSafety::hasEarnedData($result)
                && ($result->isDirty(['exam_id', 'user_id', 'room_id', 'class_id'])
                    || ($result->isDirty('result') && ($result->result === null || $result->result === '')))) {
                AssessmentResultSafety::reject('retained_results');
            }
            foreach (['term_id', 'lesson_id'] as $field) {
                if (AssessmentResultSafety::hasEarnedData($result) && $result->getRawOriginal($field) !== null && $result->isDirty($field)) {
                    AssessmentResultSafety::reject('retained_results');
                }
            }
        });
    }
}
