<?php

namespace App\Services;

use App\Lecture;
use App\Room;
use App\Student;
use App\Year;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/** Web login destinations only; target controllers retain their authorization. */
class SchoolLoginNavigation
{
    public function locale(Request $request)
    {
        $locale = $request->segment(1);
        if (!in_array($locale, ['ar', 'en'], true)) {
            $locale = $request->hasSession() ? $request->session()->get('locale') : null;
        }
        return in_array($locale, ['ar', 'en'], true) ? $locale : 'ar';
    }

    public function loginUrl(Request $request)
    {
        return url($this->locale($request).'/adh-login');
    }

    public function guest(Request $request)
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated.'], 401)
            : redirect()->guest($this->loginUrl($request));
    }

    public function home($user)
    {
        $paths = [
            '0'=>'/SMARMANger/dashboard/student', '1'=>'/SMARMANger/teacher',
            '2'=>'/SMT/admin/index', '3'=>'/SMARMANger/dashboard/supervisor',
            '4'=>'/SMARMANger/dashboard/coordinator', '5'=>'/SMARMANger/dashboard/acadsupervisor',
            '6'=>'/ADHAMMANger/dashboard/administrator', '7'=>'/ADHAMMANger/dashboard/employeeAdmin',
            ComplaintAccess::OFFICER_TYPE=>'/complaint-portal',
        ];
        return $paths[(string) $user->type] ?? null;
    }

    public function afterLogin(Request $request, $user, $fallback)
    {
        $intended = $request->session()->pull('url.intended');
        if (!is_string($intended) || preg_match('/[\\\\\x00-\x20]/', rawurldecode($intended))) return $fallback;
        $parts = parse_url($intended);
        if (!$parts || isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])) return $fallback;
        if (isset($parts['host'])) {
            $origin = ($parts['scheme'] ?? '').'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
            if (strcasecmp($origin, $request->getSchemeAndHttpHost()) !== 0) return $fallback;
        } elseif (isset($parts['scheme']) || substr($intended, 0, 1) !== '/' || substr($intended, 0, 2) === '//') {
            return $fallback;
        }
        try {
            $route = app('router')->getRoutes()->match(Request::create($intended, 'GET'));
        } catch (NotFoundHttpException | MethodNotAllowedHttpException $e) {
            return $fallback;
        }
        $type = (string) $user->type;
        // Resume known read pages only. Legacy GET mutations must never run as a login side effect.
        $allowed = [
            '0'=>['dashboard', 'student_exam', 'dashboard.student.lessons', 'dashboard.student.lesson.lectures',
                'dashboard.student.lesson.lecture.content', 'dashboard.student.room.main.exams', 'dashboard.student.room.main.quizes'],
            '1'=>['dashboard.teacher', 'dashboard.teacher_lessons2', 'dashboard.lessons.lectures',
                'dashboard.teacher_rooms2', 'dashboard.student.lessons.book_details', 'teacher.gradebook.index'],
            '2'=>['dashboard.index', 'students'],
        ];
        if (!in_array($route->getName(), $allowed[$type] ?? [], true)) return $fallback;
        if ($type === '2') return $route->getName() === 'students' && !$user->can('students') ? $fallback : $intended;
        if ($route->parameter('teacher_id') !== null && (int) $route->parameter('teacher_id') !== (int) $user->teacher_id) return $fallback;
        if ($route->parameter('student_id') !== null && (int) $route->parameter('student_id') !== (int) $user->student_id) return $fallback;
        if ($type === '0' && !Student::operational()->whereKey($user->student_id)->exists()) return $fallback;
        $roomId = $route->parameter('room_id');
        $lessonId = $route->parameter('lesson_id') ?? $route->parameter('subject_id');
        if ($route->parameter('lecture_id') !== null) {
            $lecture = Lecture::find($route->parameter('lecture_id'));
            if (!$lecture || ($roomId !== null && (int) $lecture->room_id !== (int) $roomId)
                || ($lessonId !== null && (int) $lecture->lesson_id !== (int) $lessonId)) return $fallback;
            $roomId = $lecture->room_id;
            $lessonId = $lecture->lesson_id;
        }
        if ($roomId !== null) {
            $year = Year::where('current_year', 1)->first();
            $room = $year ? Room::whereKey($roomId)->where('year_id', $year->id)->first() : null;
            if (!$room || ($route->parameter('class_id') !== null && (int) $route->parameter('class_id') !== (int) $room->class_id)) return $fallback;
            if ($type === '1' && !app(CurrentTeacherAssignments::class)->has($user->teacher_id, $roomId, $lessonId)) return $fallback;
            if ($type === '0' && !Student::currentMembership($year->id, $roomId)->whereKey($user->student_id)->exists()) return $fallback;
        }
        return $intended;
    }
}
