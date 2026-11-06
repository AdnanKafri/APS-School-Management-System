<?php

namespace App\Services;

use App\Exams2;
use App\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

/** Assessment wall-clock timestamps are interpreted in the application's school timezone. */
class AssessmentEntryWindow
{
    public function date($value)
    {
        if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}(?::\d{2})?$/D', $value)) return null;
        $value = str_replace('T', ' ', $value);
        if (strlen($value) === 16) $value .= ':00';
        try {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $value, config('app.timezone'));
            return $date->format('Y-m-d H:i:s') === $value ? $date : null;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function state(Exams2 $exam, $creatorType = null)
    {
        $start = $this->date($exam->start_date);
        $end = $this->date($exam->end_date);
        $now = Carbon::now(config('app.timezone'));
        $window = !$start || !$end || $start->gte($end) ? 'unknown'
            : ($now->lt($start) ? 'upcoming' : ($now->gt($end) ? 'ended' : 'ongoing'));
        $creatorType = $creatorType ?? User::whereKey($exam->user_id)->value('type');
        $eligible = GradebookReadService::number($exam->mark) > 0
            && in_array((int) $exam->type, [1, 2], true) && (int) $exam->is_file === 1
            && (int) $creatorType === 2 && strpos((string) $exam->name, 'Dynamic_Section_') !== 0;
        return ['window'=>$window, 'allowed'=>$eligible && $window === 'ongoing',
            'reason'=>!$eligible ? 'ineligible' : $window];
    }

    public function assertWritable(Exams2 $exam)
    {
        $state = $this->state($exam);
        if (!$state['allowed']) {
            throw ValidationException::withMessages(['entry_window'=>__('assessment_entry.'.$state['reason'])]);
        }
    }
}
