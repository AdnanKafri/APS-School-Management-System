<?php

namespace App\Http\Controllers;

use App\Services\MobileApplicationDownloadService;
use Illuminate\Support\Facades\Storage;

class MobileApplicationDistributionController extends Controller
{
    public function parentApp(MobileApplicationDownloadService $downloads)
    {
        return $this->page(['parent'], false, $downloads);
    }

    public function staffApps(MobileApplicationDownloadService $downloads)
    {
        return $this->page(['teacher', 'transport_supervisor'], true, $downloads);
    }

    private function page(array $keys, $staff, MobileApplicationDownloadService $downloads)
    {
        $releases = [];
        foreach ($keys as $key) {
            $releases[$key] = $downloads->current($key);
        }

        return response()->view('website.mobile_applications', compact('releases', 'staff'))
            ->header('Cache-Control', 'no-cache, private');
    }

    public function download($slug, MobileApplicationDownloadService $downloads)
    {
        $keys = ['parent' => 'parent', 'teacher' => 'teacher', 'transport-supervisor' => 'transport_supervisor'];
        $release = isset($keys[$slug]) ? $downloads->current($keys[$slug]) : null;
        if (!$release) {
            return response(__('app_downloads.unavailable'), 404)
                ->header('Content-Type', 'text/plain; charset=UTF-8')
                ->header('X-Robots-Tag', 'noindex')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('Cache-Control', 'no-store');
        }

        $version = preg_replace('/[^A-Za-z0-9._-]/', '-', $release->version);
        return Storage::disk(config('mobile_applications.disk'))->download(
            $release->file_path,
            'aladham-'.$slug.'-'.$version.'.apk',
            [
                'Content-Type' => 'application/vnd.android.package-archive',
                'X-Content-Type-Options' => 'nosniff',
                'X-Robots-Tag' => 'noindex',
                'Cache-Control' => 'no-store',
            ]
        );
    }
}
