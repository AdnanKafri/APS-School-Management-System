<?php

namespace Tests\Feature;

use App\MobileApplication;
use App\Services\MobileApplicationReleaseService;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use ZipArchive;

class MobileApplicationManagementTest extends TestCase
{
    private $uploads = [];
    private $isolated = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        $this->isolated = true;
        Storage::fake('mobile_applications');

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('type')->nullable();
            $table->timestamps();
        });
        Schema::create('school_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
        });
        Schema::create('mobile_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->string('audience');
            $table->unsignedBigInteger('current_release_id')->nullable();
            $table->timestamps();
        });
        Schema::create('mobile_application_releases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->string('version');
            $table->string('file_path');
            $table->string('original_filename');
            $table->unsignedBigInteger('file_size');
            $table->string('mime_type');
            $table->char('sha256', 64);
            $table->string('release_notes', 500)->nullable();
            $table->timestamp('published_at');
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();
            $table->unique(['application_id', 'version']);
        });

        MobileApplication::ensureFixedApplications();
    }

    protected function tearDown(): void
    {
        foreach ($this->uploads as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }
        if ($this->isolated) {
            Storage::disk('mobile_applications')->deleteDirectory('parent');
            Storage::disk('mobile_applications')->deleteDirectory('teacher');
        }
        parent::tearDown();
    }

    public function test_malformed_upload_fields_return_validation_instead_of_server_errors()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $this->actingAs($user)->from('/SMT/admin/mobile-applications')
            ->post('/SMT/admin/mobile-applications/publish', [
                'application_key' => 'parent', 'version' => ['bad'], 'apk' => 'not-an-upload',
            ])->assertRedirect('/SMT/admin/mobile-applications')->assertSessionHasErrors(['version', 'apk']);
    }

    public function test_partial_storage_failure_cleans_only_the_new_file()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $service = app(MobileApplicationReleaseService::class);
        $old = $service->publish('parent', $this->apk('old.apk'), '1.0.0', null, $user);
        $disk = Storage::disk('mobile_applications');
        $failingDisk = \Mockery::mock($disk);
        $failingDisk->shouldReceive('putFileAs')->once()->andReturnUsing(function ($directory, $file, $name) use ($disk) {
            $disk->put($directory.'/'.$name, 'partial write');
            return false;
        });
        Storage::shouldReceive('disk')->with('mobile_applications')->andReturn($failingDisk);
        try {
            $service->publish('parent', $this->apk('new.apk'), '1.1.0', null, $user);
            $this->fail('Failed storage was accepted.');
        } catch (\RuntimeException $exception) {
            $this->assertSame($old->id, MobileApplication::where('key', 'parent')->first()->current_release_id);
            $this->assertSame(1, \App\MobileApplicationRelease::count());
            $this->assertSame([$old->file_path], $disk->allFiles('parent'));
        }
    }

    public function test_database_failure_rolls_back_new_release_and_pointer()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $service = app(MobileApplicationReleaseService::class);
        $old = $service->publish('parent', $this->apk('old.apk'), '1.0.0', null, $user);
        MobileApplication::saving(function ($application) {
            if ($application->isDirty('current_release_id')) {
                throw new \RuntimeException('Simulated pointer write failure');
            }
        });
        try {
            $service->publish('parent', $this->apk('new.apk'), '1.1.0', null, $user);
            $this->fail('Failed pointer update was accepted.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('Simulated pointer write failure', $exception->getMessage());
            $this->assertSame($old->id, MobileApplication::where('key', 'parent')->first()->current_release_id);
            $this->assertSame(1, \App\MobileApplicationRelease::count());
            $this->assertSame([$old->file_path], Storage::disk('mobile_applications')->allFiles('parent'));
        } finally {
            MobileApplication::flushEventListeners();
        }
    }

    public function test_admin_does_not_mark_missing_file_available()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        DB::table('school_data')->insert(['name' => 'School', 'name_en' => 'School']);
        $release = app(MobileApplicationReleaseService::class)->publish('parent', $this->apk('app.apk'), '1.0.0', null, $user);
        Storage::disk('mobile_applications')->delete($release->file_path);
        $this->actingAs($user)->get('/SMT/admin/mobile-applications')->assertOk()
            ->assertDontSee('<span class="mobile-app-card__status is-ready">', false);
    }

    public function test_fixed_applications_are_idempotent()
    {
        MobileApplication::ensureFixedApplications();
        $this->assertSame(3, MobileApplication::count());
        $this->assertEqualsCanonicalizing(
            ['parent', 'teacher', 'transport_supervisor'],
            MobileApplication::pluck('key')->all()
        );
    }

    public function test_non_admin_cannot_manage_applications()
    {
        $user = User::create(['name' => 'Student', 'email' => 'student@example.test', 'password' => 'x', 'type' => '0']);
        $this->actingAs($user)->get('/SMT/admin/mobile-applications')->assertRedirect('/SMARMANger');
    }

    public function test_admin_can_view_management_page()
    {
        DB::table('school_data')->insert(['name' => 'School', 'name_en' => 'School']);
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $this->actingAs($user)->get('/SMT/admin/mobile-applications')
            ->assertOk()->assertSee('تطبيقات المدرسة');
    }

    public function test_publish_validation_rejects_missing_version_invalid_extension_and_oversized_file()
    {
        DB::table('school_data')->insert(['name' => 'School', 'name_en' => 'School']);
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);

        $this->actingAs($user)->from('/SMT/admin/mobile-applications')
            ->post('/SMT/admin/mobile-applications/publish', [
                'application_key' => 'parent',
                'apk' => UploadedFile::fake()->create('application.txt', 10, 'text/plain'),
            ])->assertRedirect('/SMT/admin/mobile-applications')
            ->assertSessionHasErrors(['version', 'apk']);

        $this->actingAs($user)->from('/SMT/admin/mobile-applications')
            ->post('/SMT/admin/mobile-applications/publish', [
                'application_key' => 'parent',
                'version' => '1.0.0',
                'apk' => UploadedFile::fake()->create('large.apk', 102401, 'application/octet-stream'),
            ])->assertRedirect('/SMT/admin/mobile-applications')
            ->assertSessionHasErrors(['apk']);
    }

    public function test_arbitrary_application_identity_is_rejected()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);

        $this->actingAs($user)->from('/SMT/admin/mobile-applications')
            ->post('/SMT/admin/mobile-applications/publish', [
                'application_key' => 'other',
                'version' => '1.0.0',
                'apk' => UploadedFile::fake()->create('other.apk', 10, 'application/octet-stream'),
            ])->assertRedirect('/SMT/admin/mobile-applications')
            ->assertSessionHasErrors(['application_key']);

        $this->assertSame(3, MobileApplication::count());
    }

    public function test_publishing_keeps_history_and_updates_current_pointer()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $service = app(MobileApplicationReleaseService::class);

        $first = $service->publish('parent', $this->apk('first.apk'), '1.0.0', null, $user);
        $second = $service->publish('parent', $this->apk('second.apk'), '1.1.0', 'Update', $user);

        $application = MobileApplication::where('key', 'parent')->first();
        $this->assertSame($second->id, $application->current_release_id);
        $this->assertSame(2, $application->releases()->count());
        $this->assertSame(64, strlen($first->sha256));
        $this->assertStringStartsWith('parent/', $first->file_path);
        $this->assertStringEndsWith('.apk', $first->file_path);
        Storage::disk('mobile_applications')->assertExists($first->file_path);
    }

    public function test_duplicate_version_does_not_replace_current_release_or_leave_file()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@example.test', 'password' => 'x', 'type' => '2']);
        $service = app(MobileApplicationReleaseService::class);
        $release = $service->publish('teacher', $this->apk('first.apk'), '2.0.0', null, $user);

        try {
            $service->publish('teacher', $this->apk('duplicate.apk'), '2.0.0', null, $user);
            $this->fail('Duplicate version was accepted.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('version', $exception->errors());
        }

        $application = MobileApplication::where('key', 'teacher')->first();
        $this->assertSame($release->id, $application->current_release_id);
        $this->assertSame(1, $application->releases()->count());
        $this->assertCount(1, Storage::disk('mobile_applications')->allFiles('teacher'));
    }

    private function apk($name)
    {
        $path = tempnam(sys_get_temp_dir(), 'apk-test-');
        $this->uploads[] = $path;
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('AndroidManifest.xml', 'manifest');
        $zip->addFromString('classes.dex', 'dex');
        $zip->close();

        return new UploadedFile($path, $name, 'application/vnd.android.package-archive', null, true);
    }
}
