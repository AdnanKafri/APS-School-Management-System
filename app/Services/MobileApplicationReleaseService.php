<?php

namespace App\Services;

use App\MobileApplication;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;
use ZipArchive;

class MobileApplicationReleaseService
{
    public function publish($applicationKey, UploadedFile $file, $version, $notes, User $uploader)
    {
        if (!array_key_exists($applicationKey, config('mobile_applications.applications', []))) {
            throw ValidationException::withMessages([
                'application_key' => [__('mobile_apps.validation.application_invalid')],
            ]);
        }

        $this->assertValidApk($file);

        $diskName = config('mobile_applications.disk', 'mobile_applications');
        $path = $applicationKey.'/'.Str::uuid()->toString().'.apk';

        try {
            // Hash the temporary upload, so publishing does not depend on a local storage adapter.
            $checksum = hash_file('sha256', $file->getRealPath());
            if (!$checksum || !Storage::disk($diskName)->putFileAs($applicationKey, $file, basename($path), ['visibility' => 'private'])) {
                throw new RuntimeException(__('mobile_apps.validation.store_failed'));
            }
            $storedSize = Storage::disk($diskName)->size($path);
            if ($storedSize !== $file->getSize()) {
                throw new RuntimeException(__('mobile_apps.validation.store_failed'));
            }
            $metadata = [
                'file_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'file_size' => $storedSize,
                'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
                'sha256' => $checksum,
            ];

            return DB::transaction(function () use ($applicationKey, $version, $notes, $uploader, $metadata) {
                $application = MobileApplication::where('key', $applicationKey)->lockForUpdate()->firstOrFail();

                if ($application->releases()->where('version', $version)->exists()) {
                    throw ValidationException::withMessages([
                        'version' => [__('mobile_apps.validation.version_duplicate')],
                    ]);
                }

                $release = $application->releases()->create(array_merge($metadata, [
                    'version' => $version,
                    'release_notes' => $notes,
                    'published_at' => now(),
                    'uploaded_by' => $uploader->id,
                ]));

                $application->current_release_id = $release->id;
                $application->save();

                return $release;
            }, 3);
        } catch (Throwable $exception) {
            try {
                if (!Storage::disk($diskName)->delete($path)) {
                    Log::warning('Failed to remove an unpublished mobile application file.', ['path' => $path]);
                }
            } catch (Throwable $cleanupException) {
                report($cleanupException);
            }
            throw $exception;
        }
    }

    private function assertValidApk(UploadedFile $file)
    {
        if (!$file->isValid()) {
            throw ValidationException::withMessages(['apk' => [__('mobile_apps.validation.apk_invalid')]]);
        }

        if (strtolower($file->getClientOriginalExtension()) !== 'apk') {
            throw ValidationException::withMessages(['apk' => [__('mobile_apps.validation.apk_extension')]]);
        }

        $zip = new ZipArchive();
        $opened = $zip->open($file->getRealPath());
        $hasManifest = $opened === true && $zip->locateName('AndroidManifest.xml') !== false;
        if ($opened === true) {
            $zip->close();
        }

        if (!$hasManifest) {
            throw ValidationException::withMessages(['apk' => [__('mobile_apps.validation.apk_structure')]]);
        }
    }
}
