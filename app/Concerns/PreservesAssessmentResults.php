<?php

namespace App\Concerns;

use App\Services\AssessmentResultSafety;

trait PreservesAssessmentResults
{
    protected static function bootPreservesAssessmentResults()
    {
        static::deleting(function ($assessment) {
            AssessmentResultSafety::assertDeletable($assessment);
        });
        static::updating(function ($assessment) {
            AssessmentResultSafety::assertDefinitionUnchanged($assessment);
        });
    }
}
