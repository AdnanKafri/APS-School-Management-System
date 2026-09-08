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
use Tests\TestCase;
use ZipArchive;

class MobileApplicationDistributionTest extends TestCase
{
    private $uploads = [];

    protected function setUp(): void
    {
        parent::setUp();
        // CLI route registration has no locale URI; real localized URLs are checked over HTTP.
        $this->withoutMiddleware([
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        ]);
        // Never run fixture DDL against the school's development/production database.
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Storage::fake('mobile_applications');
        config(['mobile_applications.disk' => 'mobile_applications']);
        require_once database_path('migrations/2026_09_07_000001_create_mobile_application_release_tables.php');
        (new \CreateMobileApplicationReleaseTables())->up();
        Schema::create('school_data', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('footer_website', function (Blueprint $table) {
            $table->increments('id');
        });
        DB::table('school_data')->insert(['id' => 1]);
        DB::table('footer_website')->insert(['id' => 1]);
    }

    protected function tearDown(): void
    {
        foreach ($this->uploads as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }
        if ($this->app) {
            Storage::disk('mobile_applications')->deleteDirectory('parent');
            Storage::disk('mobile_applications')->deleteDirectory('teacher');
        }
        parent::tearDown();
    }

    private function publish($key, $version)
    {
        $path = tempnam(sys_get_temp_dir(), 'school-apk-');
        $this->uploads[] = $path;
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('AndroidManifest.xml', $key.' '.$version);
        $zip->close();
        $user = new User();
        $user->id = 1;
        return app(MobileApplicationReleaseService::class)->publish(
            $key, new UploadedFile($path, 'application.apk', 'application/zip', null, true),
            $version, null, $user
        );
    }

    public function test_stable_download_changes_with_publication_and_fails_closed()
    {
        $this->get('/downloads/apps/parent')->assertStatus(404);
        $this->get('/downloads/apps/unknown')->assertStatus(404);
        $first = $this->publish('parent', '1.0.0');
        $response = $this->get('/downloads/apps/parent');
        $response->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.android.package-archive')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Robots-Tag', 'noindex')
            ->assertHeader('Content-Disposition', 'attachment; filename=aladham-parent-1.0.0.apk');
        $this->assertSame($first->sha256, hash('sha256', $response->streamedContent()));
        $second = $this->publish('parent', '1.1.0');
        $response = $this->get('/downloads/apps/parent')->assertOk();
        $this->assertSame($second->sha256, hash('sha256', $response->streamedContent()));
        Storage::disk('mobile_applications')->assertExists($first->file_path);
        $this->assertSame(2, MobileApplication::where('key', 'parent')->first()->releases()->count());
        Storage::disk('mobile_applications')->delete($second->file_path);
        $this->get('/downloads/apps/parent')->assertStatus(404)->assertHeader('X-Robots-Tag', 'noindex');
        $this->get(route('website.parent_app'))->assertOk()->assertSee(__('app_downloads.unavailable'));
        $teacher = $this->publish('teacher', '2.0.0');
        MobileApplication::where('key', 'parent')->update(['current_release_id' => $teacher->id]);
        $this->get('/downloads/apps/parent')->assertStatus(404);
        $this->get('/downloads/apps/teacher')->assertOk();
    }

    public function test_distribution_pages_and_seo_use_only_their_own_releases()
    {
        $release = $this->publish('parent', '1.2.3');
        $parent = $this->get(route('website.parent_app'))->assertOk();
        $parent->assertSee('1.2.3')->assertSee('index, follow')->assertSee('hreflang="ar"', false)
            ->assertSee('hreflang="en"', false)->assertSee('rel="canonical"', false)
            ->assertSee('/downloads/apps/parent', false)->assertDontSee($release->file_path, false)
            ->assertDontSee('/downloads/apps/teacher', false)->assertDontSee('/staff-apps', false);
        $teacher = $this->publish('teacher', '9.8.7');
        $staff = $this->get(route('website.staff_apps'))->assertOk();
        $staff->assertSee('noindex, nofollow')->assertSee('9.8.7')->assertDontSee('1.2.3')
            ->assertSee('/downloads/apps/teacher', false)->assertDontSee('/downloads/apps/transport-supervisor', false)
            ->assertDontSee($teacher->file_path, false)->assertSee(__('app_downloads.unavailable'));
        $this->get('/sitemap.xml')->assertOk()->assertSee('/ar/parent-app', false)
            ->assertSee('/en/parent-app', false)->assertDontSee('/staff-apps', false)
            ->assertDontSee('/downloads/apps/', false);
    }
}
