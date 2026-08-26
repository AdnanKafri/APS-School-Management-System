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
            $absolutePath = Storage::disk('public')->path($path);

            return [
                'url' => asset('storage/' . $path),
                'type' => $this->imageMimeType($path),
                'path' => $absolutePath,
                'sizes' => $this->imageDimensions($absolutePath),
            ];
        }

        $fallbackPath = public_path('student/avatar.png');

        return [
            'url' => asset('student/avatar.png'),
            'type' => 'image/png',
            'path' => $fallbackPath,
            'sizes' => $this->imageDimensions($fallbackPath),
        ];
    }

    private function imageDimensions($path)
    {
        $dimensions = is_file($path) ? @getimagesize($path) : false;

        return $dimensions ? $dimensions[0] . 'x' . $dimensions[1] : '512x512';
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
        $entries = [];

        foreach (['ar', 'en'] as $locale) {
            foreach ($paths as $path) {
                $entries[] = [
                    'loc' => $baseUrl . '/' . $locale . $path,
                    'alternates' => [
                        'ar' => $baseUrl . '/ar' . $path,
                        'en' => $baseUrl . '/en' . $path,
                        'x-default' => $baseUrl . '/ar' . $path,
                    ],
                ];
            }
        }

        return response()->view('website.sitemap', [
            'entries' => $entries,
        ])->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function favicon()
    {
        $icon = $this->schoolBrandIcon();

        return response()->file($icon['path'], [
            'Content-Type' => $icon['type'],
            'Cache-Control' => 'public, max-age=604800',
        ]);
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
                'sizes' => $icon['sizes'],
                'type' => $icon['type'],
                'purpose' => 'any',
            ]],
        ])->header('Content-Type', 'application/manifest+json; charset=UTF-8');
    }
}
