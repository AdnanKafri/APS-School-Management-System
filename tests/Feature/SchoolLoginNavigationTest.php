<?php

namespace Tests\Feature;

use App\Services\SchoolLoginNavigation;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SchoolLoginNavigationTest extends TestCase
{
    use \Tests\Concerns\TimetableFixtures;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        DB::connection()->getPdo()->sqliteCreateCollation('utf8_unicode_ci', 'strcmp');
        foreach (json_decode(file_get_contents(__DIR__.'/../Fixtures/gradebook-schema.json'), true) as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    if ($column['name'] === 'id') $table->increments('id');
                    elseif (preg_match('/^(tiny|small|medium|big)?int/', $column['type'])) $table->integer($column['name'])->nullable();
                    else $table->text($column['name'])->nullable();
                }
            });
        }
        Schema::create('student_fcm_tokens', function (Blueprint $t) { $t->increments('id'); $t->integer('s_fk'); });
        Schema::create('lectures', function (Blueprint $t) {
            $t->increments('id');
            foreach (['teacher_id','class_id','room_id','lesson_id','year_id','term_id'] as $col) $t->integer($col)->nullable();
            $t->text('name')->nullable(); $t->text('lecture_time')->nullable(); $t->timestamps();
        });
        DB::table('students')->insert(['id'=>41,'lifecycle_status'=>'active']);
        DB::table('years')->insert(['id'=>6,'current_year'=>1]);
        DB::table('term_years')->insert(['id'=>20,'year_id'=>6,'current_term'=>1,'type'=>1]);
        DB::table('classes')->insert(['id'=>2,'name'=>'Grade 2']);
        DB::table('rooms')->insert(['id'=>132,'class_id'=>2,'year_id'=>6]);
        DB::table('lessons')->insert(['id'=>409,'class_id'=>2]);
        DB::table('teachers')->insert(['id'=>166]);
        DB::table('room_student')->insert(['student_id'=>41,'room_id'=>132,'year_id'=>6]);
        DB::table('student_academic_placements')->insert(['student_id'=>41,'room_id'=>132,'class_id'=>2,'year_id'=>6,'status'=>'active','effective_from'=>'2020-01-01']);
        $this->createTimetableSchema();
        $this->timetablePeriod(166,132,409,6,20);
    }

    private function account($type)
    {
        return User::create(['name'=>'Fixture','email'=>'role'.$type.'@example.test','password'=>bcrypt('fixture-only-password'),
            'type'=>$type,'student_id'=>$type===0 ? 41 : null,'teacher_id'=>$type===1 ? 166 : null]);
    }

    public function test_guest_routes_redirect_to_canonical_login_and_json_stays_401()
    {
        foreach (['/login','/SMARMANger','/SMARMANger/teacher','/SMARMANger/dashboard/student','/SMT/admin/students'] as $uri) {
            $this->get($uri)->assertRedirect('/ar/adh-login');
        }
        $this->getJson('/SMARMANger/dashboard/student')->assertStatus(401);
        $this->withSession(['locale'=>'en'])->get('/login')->assertRedirect('/en/adh-login');
    }

    public function test_legacy_and_public_login_use_valid_role_homes()
    {
        foreach ([0=>'/SMARMANger/dashboard/student',1=>'/SMARMANger/teacher',2=>'/SMT/admin/index'] as $type=>$home) {
            $user = $this->account($type);
            foreach (['/login','/login1'] as $endpoint) {
                auth()->logout();
                $this->post($endpoint,['email'=>$user->email,'password'=>'fixture-only-password'])->assertRedirect($home);
                $this->assertAuthenticatedAs($user);
            }
        }
    }

    public function test_login_get_does_not_log_out_students_or_delete_tokens_but_logout_does()
    {
        $user=$this->account(0);
        DB::table('student_fcm_tokens')->insert(['s_fk'=>41]);
        $this->actingAs($user)->get('/login')->assertRedirect('/SMARMANger/dashboard/student');
        $this->assertAuthenticatedAs($user);
        $this->assertSame(1, DB::table('student_fcm_tokens')->count());
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->assertSame(0, DB::table('student_fcm_tokens')->count());
    }

    public function test_safe_intended_pages_resume_but_wrong_roles_ids_and_external_urls_do_not()
    {
        $teacher=$this->account(1);
        $valid='/SMARMANger/dashboard/teacher/lessons/lectures/409/166/132';
        $this->withSession(['url.intended'=>url($valid)])->post('/login1',['email'=>$teacher->email,'password'=>'fixture-only-password'])->assertRedirect($valid);
        foreach (['https://evil.example/test','//evil.example/test','/SMT/admin/students',str_replace('/166/','/167/',$valid),'/logout','/missing-page'] as $invalid) {
            auth()->logout();
            $this->withSession(['url.intended'=>$invalid])->post('/login',['email'=>$teacher->email,'password'=>'fixture-only-password'])->assertRedirect('/SMARMANger/teacher');
        }
        $student=$this->account(0);
        $request=Request::create('/login1'); $request->setLaravelSession(app('session')->driver());
        $navigation=app(SchoolLoginNavigation::class);
        foreach ([41=>true,42=>false] as $id=>$allowed) {
            $target='/SMARMANger/dashboard/student/room/main_quizes/132/'.$id;
            $request->session()->put('url.intended',$target);
            $this->assertSame($allowed?$target:'/fallback',$navigation->afterLogin($request,$student,'/fallback'));
        }
    }

    public function test_csrf_403_and_404_remain_distinct()
    {
        $request=Request::create('/login1','POST'); $request->setLaravelSession(app('session')->driver());
        $handler=app(\App\Exceptions\Handler::class);
        $response=$handler->render($request,new \Illuminate\Session\TokenMismatchException());
        $this->assertSame(url('/ar/adh-login'),$response->headers->get('Location'));
        $request=Request::create('/login1','POST',[],[],[],['HTTP_ACCEPT'=>'application/json']);
        $request->setLaravelSession(app('session')->driver());
        $this->assertSame(419,$handler->render($request,new \Illuminate\Session\TokenMismatchException())->getStatusCode());
        $this->assertSame(403,$handler->render($request,new \Symfony\Component\HttpKernel\Exception\HttpException(403))->getStatusCode());
        $this->assertSame(404,$handler->render($request,new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException())->getStatusCode());
    }

    public function test_wrong_roles_and_student_identity_still_cannot_enter_protected_pages()
    {
        $this->actingAs($this->account(2))->get('/SMARMANger/teacher')->assertRedirect('/SMARMANger');
        $this->get('/complaint-portal')->assertStatus(403);
        $this->actingAs($this->account(8))->get('/SMT/admin/students')->assertStatus(403);
        $this->actingAs($this->account(0))->get('/SMARMANger/dashboard/student/room/main_quizes/132/42')->assertRedirect('/SMARMANger');
        $this->assertGuest();
    }

    public function test_teacher_lesson_creation_keeps_existing_contract_and_assignment_protection()
    {
        $this->actingAs($this->account(1));
        $payload=['teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'name'=>'درس عربي طويل للاختبار','lecture_time'=>'2099-01-01'];
        $this->post(route('dashboard.lessons.lecture.store'),$payload)->assertStatus(302);
        $this->assertDatabaseHas('lectures',array_merge($payload,['year_id'=>6,'term_id'=>20]));
        $payload['room_id']=999;
        $this->post(route('dashboard.lessons.lecture.store'),$payload)->assertStatus(403);
        $this->assertSame(1,DB::table('lectures')->count());
    }

    public function test_teacher_upload_and_external_link_save_only_in_isolated_storage()
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $this->actingAs($this->account(1));
        DB::table('lectures')->insert(['id'=>4999,'teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'year_id'=>6,'term_id'=>20,'lecture_time'=>'2099-01-01']);
        $payload=['teacher_id'=>166,'class_id'=>2,'room_id'=>132,'lesson_id'=>409,'lecture_id'=>4999,'type'=>4,'name_addition'=>'ملف عربي للاختبار'];
        $file=\Illuminate\Http\UploadedFile::fake()->createWithContent('lesson.txt','Isolated lesson content');
        $this->post(route('dashboard.store_items'),array_merge($payload,['addition'=>$file]))->assertStatus(302);
        $stored=DB::table('lesson_teacher_room_term_exam')->first();
        $this->assertSame('ملف عربي للاختبار',$stored->name_addition);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($stored->addition);
        $this->assertSame('Isolated lesson content',\Illuminate\Support\Facades\Storage::disk('public')->get($stored->addition));
        $this->post(route('dashboard.store_items'),array_merge($payload,['addition_link'=>'https://example.test/lesson']))->assertStatus(302);
        $this->assertDatabaseHas('lesson_teacher_room_term_exam',['addition_link'=>'https://example.test/lesson','lecture_id'=>4999,'term_id'=>20]);
        $this->assertSame(2,DB::table('lesson_teacher_room_term_exam')->count());
        $payload['lecture_id']=9876;
        $this->post(route('dashboard.store_items'),$payload)->assertStatus(403);
        $this->assertSame(2,DB::table('lesson_teacher_room_term_exam')->count());
    }
}
