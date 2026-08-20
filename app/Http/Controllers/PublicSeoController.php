<?php

namespace App\Http\Controllers;

use App\School_data;
use Illuminate\Support\Facades\Storage;

class PublicSeoController extends Controller
{
    private function schoolBrandIcon()
    {
        $path = ltrim(trim((string) optional(School_data::first())->logo), '/');
        if (strpos($path, 'storage/') === 0) {
            $path = ltrim(substr($path, strlen('storage/')), '/');
        }

        if ($path !== '' && Storage::disk('public')->exists($path)) {
            return [
                'url' => asset('storage/' . $path),
                'type' => $this->imageMimeType($path),
            ];
        }

        return [
            'url' => asset('student/avatar.png'),
            'type' => 'image/png',
        ];
    }

    private function imageMimeType($path)
    {
        $types = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
        ];

        return $types[strtolower(pathinfo($path, PATHINFO_EXTENSION))] ?? 'image/png';
    }

    public function robots()
    {
        $baseUrl = rtrim((string) config('app.url'), '/');

        return response()->view('website.robots', [
            'sitemapUrl' => $baseUrl . '/sitemap.xml',
        ])->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function sitemap()
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $paths = ['', '/faq', '/contact_us', '/complaints', '/Recruitment_competition'];
        $urls = [];

        foreach (['ar', 'en'] as $locale) {
            foreach ($paths as $path) {
                $urls[] = $baseUrl . '/' . $locale . $path;
            }
        }

        return response()->view('website.sitemap', [
            'urls' => $urls,
        ])->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function manifest()
    {
        $icon = $this->schoolBrandIcon();
        $baseUrl = rtrim((string) config('app.url'), '/');

        return response()->json([
            'name' => 'Aladham Private School',
            'short_name' => 'Aladham School',
            'start_url' => $baseUrl . '/ar',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#1f4f8f',
            'icons' => [[
                'src' => $icon['url'],
                'sizes' => 'any',
                'type' => $icon['type'],
                'purpose' => 'any maskable',
            ]],
        ])->header('Content-Type', 'application/manifest+json; charset=UTF-8');
    }
}
