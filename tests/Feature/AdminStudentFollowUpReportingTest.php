<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminStudentFollowUpController;
use Carbon\Carbon;
use Tests\TestCase;

class AdminStudentFollowUpReportingTest extends TestCase
{
    public function test_admin_follow_up_routes_are_admin_and_permission_protected()
    {
        $route = app('router')->getRoutes()->getByName('admin.student_follow_ups.index');
        $this->assertNotNull($route);
        $this->assertContains('roleadmin', $route->gatherMiddleware());
        $this->assertContains('can:manage_student_follow_ups', $route->gatherMiddleware());
        $this->assertNotNull(app('router')->getRoutes()->getByName('admin.student_follow_ups.teachers'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('admin.student_follow_ups.students'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('admin.student_follow_ups.teacher.compliance_report'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('admin.student_follow_ups.teacher.evaluations_report'));
        $this->assertNull(app('router')->getRoutes()->getByName('admin.student_follow_ups.create_on_behalf'));
        $landing = file_get_contents(resource_path('views/admin/student_follow_ups/index.blade.php'));
        $this->assertStringContainsString('sfu-branches', $landing);
        $this->assertStringNotContainsString("@include('admin.student_follow_ups._table'", $landing);
        $teacher = file_get_contents(resource_path('views/admin/student_follow_ups/teacher.blade.php'));
        $students = file_get_contents(resource_path('views/admin/student_follow_ups/students.blade.php'));
        $this->assertStringContainsString('sfuAdminAddModal', $teacher);
        $this->assertStringContainsString('classGroups', $teacher);
        $this->assertStringContainsString('sectionGroups', $teacher);
        $this->assertStringContainsString("@if(\$students)", $students);
    }

    public function test_due_state_does_not_mark_the_current_half_or_future_half_as_missing()
    {
        $controller = app(AdminStudentFollowUpController::class);
        $method = new \ReflectionMethod($controller, 'dueHalves');
        $method->setAccessible(true);

        $this->assertSame([1 => false, 2 => false], $method->invoke($controller, '2026-09', Carbon::parse('2026-09-10 12:00', 'Asia/Damascus')));
        $this->assertSame([1 => true, 2 => false], $method->invoke($controller, '2026-09', Carbon::parse('2026-09-20 12:00', 'Asia/Damascus')));
        $this->assertSame([1 => true, 2 => true], $method->invoke($controller, '2026-09', Carbon::parse('2026-10-01 00:00', 'Asia/Damascus')));
    }

    public function test_half_phases_distinguish_current_future_and_closed_periods()
    {
        $controller = app(AdminStudentFollowUpController::class);
        $method = new \ReflectionMethod($controller, 'halfPhases');
        $method->setAccessible(true);

        $this->assertSame([1 => 'current', 2 => 'future'], $method->invoke($controller, '2026-09', Carbon::parse('2026-09-10 12:00', 'Asia/Damascus')));
        $this->assertSame([1 => 'closed', 2 => 'current'], $method->invoke($controller, '2026-09', Carbon::parse('2026-09-19 12:00', 'Asia/Damascus')));
    }
}
