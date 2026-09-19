<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentFollowUpViewTest extends TestCase
{
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
