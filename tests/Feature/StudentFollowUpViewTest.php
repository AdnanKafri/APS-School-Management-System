<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentFollowUpViewTest extends TestCase
{
    public function test_all_rating_labels_and_admin_print_reports_support_very_good()
    {
        foreach (['ar' => 'جيد جداً', 'en' => 'Very Good'] as $locale => $label) {
            foreach (['student_follow_up', 'student_follow_up_student'] as $namespace) {
                $this->assertSame($label, trans($namespace . '.levels.very_good', [], $locale));
                $labels = trans($namespace . '.levels', [], $locale);
                $this->assertSame(\App\StudentFollowUp::LEVELS, array_keys($labels));
            }
            app()->setLocale($locale);
            $row = (object) [
                'student_id' => 1, 'lesson' => (object) ['name' => 'Arabic'],
                'teacher' => (object) ['first_name' => 'Teacher', 'last_name' => 'Example'],
                'classRoom' => (object) ['name' => 'Grade 2'], 'room' => (object) ['name' => 'A'],
                'observed_at' => \Carbon\Carbon::parse('2026-10-12 10:00', 'Asia/Damascus'),
                'compliance_half' => 1, 'level' => 'very_good', 'note' => null,
            ];
            $student = (object) ['first_name' => 'Student', 'last_name' => 'Example'];
            $data = [
                'school' => (object) ['name' => 'School'], 'student' => $student,
                'year' => (object) ['name' => '2026/2027'], 'placement' => null, 'month' => '2026-10',
                'followUps' => collect([$row]), 'teacher' => $row->teacher,
                'students' => collect([1 => $student]), 'groups' => collect([collect([$row])]),
            ];
            foreach (['report', 'teacher_evaluations_report'] as $view) {
                $html = view('admin.student_follow_ups.' . $view, $data)->render();
                $this->assertStringContainsString($label, $html);
                $this->assertStringNotContainsString('levels.very_good', $html);
            }
        }
        foreach (['roster', 'history'] as $view) {
            $source = file_get_contents(resource_path('views/teachers2/student_follow_ups/' . $view . '.blade.php'));
            $this->assertStringContainsString('\\App\\StudentFollowUp::LEVELS', $source);
        }
    }

    public function test_student_follow_up_route_is_student_only_read_only_and_has_no_student_id_parameter()
    {
        $route = collect(app('router')->getRoutes()->getRoutes())
            ->first(function ($route) {
                return $route->getName() === 'dashboard.student.follow_ups';
            });

        $this->assertNotNull($route);
        $this->assertSame('SMARMANger/dashboard/student/follow-ups', $route->uri());
        $this->assertSame(['GET', 'HEAD'], $route->methods());
        $this->assertContains('rolestudent', $route->middleware());
        $this->assertStringNotContainsString('{student_id}', $route->uri());
        $this->assertStringContainsString('StudentFollowUpController@index', $route->getActionName());
        $source = file_get_contents(base_path('app/Http/Controllers/StudentFollowUpController.php'));

        $this->assertStringContainsString("findOrFail((int) Auth::user()->student_id)", $source);
        $this->assertStringContainsString('->where(\'student_id\', $student->id)', $source);
        $this->assertStringContainsString('->where(\'year_id\', $year->id)', $source);
        $this->assertStringContainsString("->whereNull('voided_at')", $source);
        $this->assertStringContainsString("with(['teacher', 'lesson', 'year', 'term', 'room', 'classRoom'])", $source);
    }
}
