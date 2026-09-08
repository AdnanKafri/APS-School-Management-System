<?php

namespace App\Services;

use App\MobileApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MobileApplicationDownloadService
{
    public function current($key)
    {
        if (!array_key_exists($key, config('mobile_applications.applications', []))) {
            return null;
        }

        $application = MobileApplication::with('currentRelease')->where('key', $key)->first();
        $release = $application ? $application->currentRelease : null;
        if (!$release) {
            return null;
        }

        // A pointer must refer to its own application's generated object path.
        if ((int) $release->application_id !== (int) $application->id ||
            !preg_match('#^'.preg_quote($key, '#').'/[a-f0-9-]{36}\.apk$#iD', $release->file_path) ||
            !Storage::disk(config('mobile_applications.disk'))->exists($release->file_path)) {
            Log::warning('Current mobile application release is unavailable.', [
                'application_key' => $key, 'release_id' => $release->id,
            ]);
            return null;
        }

        return $release;
    }
}
