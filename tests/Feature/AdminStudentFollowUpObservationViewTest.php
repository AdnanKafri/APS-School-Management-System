<?php

namespace Tests\Feature;

use App\StudentFollowUp;
use Carbon\Carbon;
use Tests\TestCase;

class AdminStudentFollowUpObservationViewTest extends TestCase
{
    public function test_all_ratings_are_visible_without_notes_in_both_languages()
    {
        foreach (['ar', 'en'] as $locale) {
            app()->setLocale($locale);
            foreach (StudentFollowUp::LEVELS as $level) {
                foreach ([null, ''] as $note) {
                    $html = $this->renderRows([$this->record($level, $note)]);
                    $this->assertStringContainsString(__('student_follow_up.levels.' . $level), $html);
                    $this->assertStringContainsString(__('student_follow_up_admin.no_evaluation_note'), $html);
                    $this->assertStringNotContainsString(__('student_follow_up_admin.no_evaluation'), $html);
                    $this->assertStringNotContainsString(__('student_follow_up_admin.no_note'), $html);
                }
            }
        }
    }

    public function test_notes_and_multiple_evaluations_remain_separate_and_escaped()
    {
        foreach (['ar', 'en'] as $locale) {
            app()->setLocale($locale);
            $records = [
                $this->record('excellent', 'Progress <script>alert(1)</script>', '2026-10-22 12:00'),
                $this->record('very_good', null, '2026-10-21 12:00'),
                $this->record(null, 'Note-only follow-up', '2026-10-20 12:00'),
                $this->record('good', '0', '2026-10-19 12:00'),
            ];
            $before = serialize($records);
            $html = $this->renderRows($records);
            $this->assertSame(4, substr_count($html, '<article class="sfu-observation">'));
            $this->assertStringContainsString('Progress &lt;script&gt;alert(1)&lt;/script&gt;', $html);
            $this->assertStringNotContainsString('<script>', $html);
            $this->assertStringContainsString(__('student_follow_up.levels.excellent'), $html);
            $this->assertStringContainsString(__('student_follow_up_admin.no_rating'), $html);
            $this->assertStringContainsString('Note-only follow-up', $html);
            $this->assertStringContainsString('>0</p>', $html);
            $this->assertLessThan(strpos($html, '2026-10-21'), strpos($html, '2026-10-22'));
            $this->assertSame($before, serialize($records));
        }
    }

    public function test_empty_state_only_appears_when_there_are_no_records()
    {
        foreach (['ar', 'en'] as $locale) {
            app()->setLocale($locale);
            $html = $this->renderRows([]);
            $this->assertStringContainsString(__('student_follow_up_admin.no_evaluation'), $html);
            $this->assertStringNotContainsString('sfu-evaluation-rating', $html);
        }
        $route = app('router')->getRoutes()->getByName('admin.student_follow_ups.observations');
        $this->assertContains('roleadmin', $route->gatherMiddleware());
        $this->assertContains('can:manage_student_follow_ups', $route->gatherMiddleware());
    }

    private function renderRows(array $rows)
    {
        return view('admin.student_follow_ups._observations', ['followUps' => collect($rows)])->render();
    }

    private function record($level, $note, $date = '2026-10-22 12:00')
    {
        return (object) [
            'level' => $level, 'note' => $note, 'edited_at' => null,
            'observed_at' => Carbon::parse($date, 'Asia/Damascus'),
            'teacher' => (object) ['first_name' => 'Teacher', 'last_name' => 'Example'],
            'lesson' => (object) ['name' => 'Arabic'],
            'classRoom' => (object) ['name' => 'Grade 2'], 'room' => (object) ['name' => 'A'],
        ];
    }
}
