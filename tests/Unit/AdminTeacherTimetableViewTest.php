<?php

namespace Tests\Unit;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use PHPUnit\Framework\TestCase;

class AdminTeacherTimetableViewTest extends TestCase
{
    public static function renderTimetable($schedule, $days)
    {
        $source = file_get_contents(__DIR__.'/../../resources/views/admin/new_teacher_schedule.blade.php');
        $start = strpos($source, '    @php', strpos($source, '@section(\'content\')'));
        $end = strpos($source, '@endsection', $start);
        $compiler = new BladeCompiler(new Filesystem, sys_get_temp_dir());
        $compiled = $compiler->compileString(substr($source, $start, $end - $start));
        $__env = new \Illuminate\View\Factory(
            new \Illuminate\View\Engines\EngineResolver,
            new \Illuminate\View\FileViewFinder(new Filesystem, []),
            new \Illuminate\Events\Dispatcher
        );
        $today = -1;
        ob_start();
        try {
            eval('?>'.$compiled);
            return ob_get_contents();
        } finally {
            ob_end_clean();
        }
    }

    private function period($id, $room, $slot, $day, $start, $end)
    {
        return (object) [
            'id'=>$id, 'room_id'=>$room, 'lecture_time_id'=>$slot, 'day_id'=>$day,
            'teacher_id'=>166, 'lesson_id'=>409, 'attendance'=>false,
            'lecture_time'=>(object) ['start_time'=>$start, 'end_time'=>$end],
            'lesson'=>(object) ['name'=>'معلوماتية'],
            'room'=>(object) ['name'=>'شعبة '.$room, 'classes'=>(object) ['name'=>'الصف الثاني']],
        ];
    }

    public function test_all_sections_and_simultaneous_periods_keep_their_original_identities()
    {
        $periods = collect([
            $this->period(1, 130, 10, 2, '08:00:00', '08:45:00'),
            $this->period(2, 131, 11, 2, '08:00:00', '08:45:00'),
            $this->period(3, 132, 12, 3, '08:00:00', '08:45:00'),
            $this->period(4, 133, 13, 2, '08:00:00', '08:40:00'),
            $this->period(4122, 130, 14, 5, '13:20:00', '14:00:00'),
        ]);
        $days = collect([2, 3, 5])->map(function ($id) { return (object) ['id'=>$id, 'name'=>'يوم '.$id]; });
        $html = self::renderTimetable($periods, $days);
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        $xpath = new \DOMXPath($dom);
        $this->assertCount(5, $xpath->query('//*[@data-schedule-id]'));
        foreach ($periods as $period) {
            $nodes = $xpath->query('//*[@data-schedule-id="'.$period->id.'"]');
            $this->assertCount(1, $nodes);
            foreach (['slot'=>'lecture_time_id', 'room'=>'room_id', 'lesson'=>'lesson_id', 'teacher'=>'teacher_id', 'day'=>'day_id'] as $attribute=>$field) {
                $this->assertSame((string) $period->$field, $nodes->item(0)->getAttribute('data-'.$attribute.'-id'));
            }
            $this->assertStringContainsString('معلوماتية', $nodes->item(0)->textContent);
        }
        $this->assertCount(4, $xpath->query('//thead/tr/th'));
        $sameTimeCell = $xpath->query('//*[@data-schedule-id="1"]/parent::td')->item(0);
        $this->assertCount(2, $xpath->query('.//*[@data-schedule-id]', $sameTimeCell));
        $this->assertStringContainsString('13:20:00 - 14:00:00', $html);
    }

    public function test_empty_schedule_keeps_the_existing_empty_state()
    {
        $html = self::renderTimetable(collect(), collect());
        $this->assertStringContainsString('لا يوجد جدول حصص مسجل', $html);
        $this->assertStringNotContainsString('data-schedule-id=', $html);
    }
}
