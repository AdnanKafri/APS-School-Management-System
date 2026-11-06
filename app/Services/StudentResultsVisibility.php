<?php

namespace App\Services;

/** Student publication only. Never changes stored results or Teacher/Admin rights. */
class StudentResultsVisibility
{
    public function enabled()
    {
        $value = config('student_results.student_pages_enabled', false);
        return is_string($value) ? filter_var($value, FILTER_VALIDATE_BOOLEAN) : (bool) $value;
    }

    public function published($result)
    {
        return $this->enabled() && $result && (string) $result->status === '1'
            && (string) $result->show_result === '1';
    }

    public function blockedJson(array $extra = [])
    {
        return response()->json(array_merge([
            'status' => false, 'blocked' => true, 'code' => 'STUDENT_RESULTS_BLOCKED',
            'message' => config('student_results.blocked_message'),
        ], $extra));
    }

    /** Preserve legacy mobile response shape; never serialize earned data while hidden. */
    public function redactPayload($payload)
    {
        if (!is_array($payload)) return $payload;
        $private = ['result', 'result1', 'result2', 'student_result', 'student_mark', 'mark2', 'marks',
            'year_result', 'term_result', 'final_result', 'term1_result', 'term2_result',
            'term1_quizes', 'term2_quizes', 'term1_exam', 'term2_exam',
            'traditional_result', 'medal', 'medals', 'exam_medals', 'test_medals',
            'student_final_mark', 'student_total_mark', 'deserved_mark', 'user_answers',
            'golden_medals_count', 'silver_medals_count', 'bronze_medals_count'];
        foreach ($payload as $key => $value) {
            // `mark` on definitions/questions is a maximum needed by active exams,
            // whereas the official Student-mark structure contains earned JSON.
            $officialMark = $key === 'mark' && (is_array($value)
                || array_key_exists('year_result', $payload) || array_key_exists('term_result', $payload));
            $payload[$key] = $officialMark || in_array((string) $key, $private, true) ? null : $this->redactPayload($value);
        }
        return $payload;
    }

    public function redactUnpublishedPayload($payload)
    {
        if (!is_array($payload)) return $payload;
        if (array_key_exists('show_result', $payload) && ((string) $payload['show_result'] !== '1'
            || (array_key_exists('status', $payload) && (string) $payload['status'] !== '1'))) {
            return $this->redactPayload($payload);
        }
        foreach ($payload as $key => $value) $payload[$key] = $this->redactUnpublishedPayload($value);
        return $payload;
    }
}
