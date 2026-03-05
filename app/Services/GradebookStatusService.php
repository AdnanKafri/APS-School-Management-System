<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class GradebookStatusService
{
    /**
     * Get the status file path for a class and term.
     * Stored as: gradebook_status/{class_id}_{term_id}.json
     */
    protected static function getPath($classId, $termId)
    {
        return "gradebook_status/{$classId}_{$termId}.json";
    }

    /**
     * Set the status of the Gradebook for a specific Class + Term.
     * Statuses: 'OPEN' or 'LOCKED'
     */
    public static function setStatus($classId, $termId, $status)
    {
        $status = strtoupper($status);
        if (!in_array($status, ['OPEN', 'LOCKED'])) {
            return false;
        }

        $path = self::getPath($classId, $termId);
        $data = ['status' => $status, 'updated_at' => now()->toDateTimeString()];

        return Storage::put($path, json_encode($data));
    }

    /**
     * Get the current status of the Gradebook.
     * Default is 'LOCKED' for safety.
     */
    public static function getStatus($classId, $termId)
    {
        $path = self::getPath($classId, $termId);

        if (Storage::exists($path)) {
            $content = Storage::get($path);
            $json = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($json['status'])) {
                return $json['status']; // 'OPEN' or 'LOCKED'
            }
        }

        return 'LOCKED'; // Default safe state
    }
}
