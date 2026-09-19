<?php

namespace App\Observers;

use App\Services\TeacherAssignmentPeriodService;
use App\Teacher_room_lesson;

class TeacherRoomLessonObserver
{
    public function created(Teacher_room_lesson $assignment)
    {
        app(TeacherAssignmentPeriodService::class)->openForAssignment($assignment);
    }

    public function deleted(Teacher_room_lesson $assignment)
    {
        app(TeacherAssignmentPeriodService::class)->closeForAssignment($assignment);
    }
}
