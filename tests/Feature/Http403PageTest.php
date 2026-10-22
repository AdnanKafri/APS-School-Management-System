<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class Http403PageTest extends TestCase
{
    public function test_laravel_403_uses_a_standalone_localized_view_and_preserves_status()
    {
        Route::get('/ar/__codex-forbidden-test', function () {
            abort(403);
        });
        Route::get('/en/__codex-forbidden-test', function () {
            abort(403);
        });

        $this->get('/ar/__codex-forbidden-test')
            ->assertForbidden()
            ->assertSee('ليس لديك صلاحية الوصول إلى الصفحة المطلوبة.')
            ->assertSee('href="' . url('/ar') . '"', false);

        $this->get('/en/__codex-forbidden-test')
            ->assertForbidden()
            ->assertSee('You do not have permission to access the requested page.')
            ->assertSee('href="' . url('/en') . '"', false);
    }
}
