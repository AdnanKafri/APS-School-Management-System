<?php

namespace App\Observers;

use App\Services\CurrentTeacherAssignments;
use App\Term_year;

class TimetableTermObserver
{
    public function saved(Term_year $term)
    {
        if (($term->wasRecentlyCreated && $term->current_term)
            || $term->wasChanged('current_term') || $term->wasChanged('year_id')) {
            $authority = app(CurrentTeacherAssignments::class);
            $year = $authority->year();
            if ($year && (int) $year->id === (int) $term->year_id) {
                $authority->synchronize();
            }
        }
    }
}
