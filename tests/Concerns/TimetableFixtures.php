<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TimetableFixtures
{
    protected function createTimetableSchema()
    {
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        if (!Schema::hasColumn('teachers', 'active')) {
            Schema::table('teachers', function (Blueprint $t) { $t->integer('active')->default(0); });
        }
        if (!Schema::hasColumn('lessons', 'class_id')) {
            Schema::table('lessons', function (Blueprint $t) { $t->integer('class_id')->nullable(); });
        }
        if (!Schema::hasTable('days')) {
            Schema::create('days', function (Blueprint $t) { $t->increments('id'); $t->string('name')->nullable(); $t->string('name_en')->nullable(); });
        }
        if (!Schema::hasTable('lecture_times')) {
            Schema::create('lecture_times', function (Blueprint $t) {
                $t->increments('id'); $t->integer('room_id'); $t->integer('class_id')->nullable();
                $t->string('name')->nullable(); $t->integer('type'); $t->time('start_time'); $t->time('end_time'); $t->timestamps();
            });
        }
        if (!Schema::hasTable('lesson_room_teacher_lecture_time')) {
            Schema::create('lesson_room_teacher_lecture_time', function (Blueprint $t) {
                $t->increments('id');
                foreach (['teacher_id','room_id','lesson_id','lecture_time_id','day_id','year_id','term_id'] as $col) { $t->integer($col); }
                $t->text('meeting_link')->nullable(); $t->timestamps();
            });
        }
        if (!Schema::hasTable('teacher_assignment_periods')) {
            Schema::create('teacher_assignment_periods', function (Blueprint $t) {
                $t->increments('id');
                foreach (['teacher_room_lesson_id','teacher_id','lesson_id','year_id','class_id','room_id'] as $col) { $t->integer($col)->nullable(); }
                $t->dateTime('effective_from'); $t->dateTime('effective_to')->nullable(); $t->string('source'); $t->timestamps();
            });
        }
    }

    protected function timetablePeriod($teacher, $room, $lesson, $year, $term = null, $day = 1, $slot = null)
    {
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $term = $term ?: DB::table('term_years')->where('year_id', $year)->where('current_term', 1)->value('id');
        if (!$term) { throw new \RuntimeException('An isolated timetable requires an explicit term.'); }
        DB::table('teachers')->where('id', $teacher)->whereNull('active')->update(['active'=>0]);
        DB::table('lessons')->where('id', $lesson)->whereNull('class_id')
            ->update(['class_id'=>DB::table('rooms')->where('id', $room)->value('class_id')]);
        DB::table('days')->updateOrInsert(['id'=>$day], ['name'=>'Day '.$day,'name_en'=>'Day '.$day]);
        $slot = $slot ?: DB::table('lecture_times')->insertGetId([
            'room_id'=>$room, 'type'=>1, 'name'=>'Period', 'start_time'=>'08:00:00', 'end_time'=>'08:40:00',
        ]);
        return DB::table('lesson_room_teacher_lecture_time')->insertGetId([
            'teacher_id'=>$teacher,'room_id'=>$room,'lesson_id'=>$lesson,'year_id'=>$year,'term_id'=>$term,
            'lecture_time_id'=>$slot,'day_id'=>$day,'created_at'=>now(),'updated_at'=>now(),
        ]);
    }
}
