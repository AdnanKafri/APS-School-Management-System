<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait GradebookTemplateFixtures
{
    private function templateFixtureSchema()
    {
        $connection = DB::connection();
        if (!(($connection->getDriverName() === 'sqlite' && $connection->getDatabaseName() === ':memory:')
            || ($connection->getDriverName() === 'mysql'
                && preg_match('/^aladham_gbt_test_[a-f0-9]{16}$/D', $connection->getDatabaseName())))) {
            throw new \RuntimeException('Refusing template fixtures outside an isolated database.');
        }
        foreach (['years', 'classes', 'lessons'] as $table) {
            Schema::create($table, function (Blueprint $t) use ($table) {
                $t->engine = 'InnoDB';
                $t->integer('id')->primary();
                $t->string('name');
                if ($table === 'years') $t->integer('current_year')->default(0);
                if ($table === 'lessons') $t->integer('class_id')->nullable();
            });
        }
        Schema::create('users', function (Blueprint $t) {
            $t->engine = 'InnoDB';
            $t->bigIncrements('id');
            $t->string('name'); $t->string('email'); $t->string('password'); $t->string('type');
            $t->integer('role_id')->nullable(); $t->integer('student_id')->nullable();
            $t->boolean('complaint_officer_active')->default(0); $t->string('remember_token')->nullable();
            $t->timestamps();
        });
        DB::table('classes')->insert([['id'=>2,'name'=>'Grade 2'],['id'=>3,'name'=>'Grade 3']]);
        DB::table('years')->insert([['id'=>5,'name'=>'2025/2026','current_year'=>0],['id'=>6,'name'=>'2026/2027','current_year'=>1]]);
        DB::table('lessons')->insert([['id'=>409,'name'=>'Math','class_id'=>2],['id'=>410,'name'=>'Science','class_id'=>3]]);
        foreach (['2','1','0','8'] as $i=>$type) DB::table('users')->insert([
            'id'=>$i+1,'name'=>'Fixture actor','email'=>'fixture'.$i.'@example.test','password'=>'unused','type'=>$type,
        ]);
        require_once base_path('database/migrations/2026_10_29_000001_create_gradebook_template_foundation.php');
        (new \CreateGradebookTemplateFoundation())->up();
    }

    private function templatePayload()
    {
        return ['name_ar'=>'قالب الرياضيات', 'name_en'=>'Mathematics', 'components'=>[
            ['id'=>'','name_ar'=>'مذاكرة','name_en'=>'Quiz','maximum'=>35],
            ['id'=>'','name_ar'=>'امتحان','name_en'=>'Exam','maximum'=>120],
        ]];
    }
}
