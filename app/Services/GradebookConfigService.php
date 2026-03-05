<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class GradebookConfigService
{
    /**
     * Get config for a specific lesson/year.
     * Falls back to legacy defaults if file not found.
     *
     * @param int $lessonId
     * @param int $yearId
     * @return array
     */
    public static function getConfig($lessonId, $yearId)
    {
        $path = "gradebook/{$lessonId}_{$yearId}.json";

        if (Storage::exists($path)) {
            try {
                $content = Storage::get($path);
                $json = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($json['components'])) {
                    // Convert array to object-like structure for consistency with legacy code
                    $components = [];
                    foreach($json['components'] as $comp) {
                        $components[] = (object) $comp;
                    }
                    return collect($components);
                }
            } catch (\Exception $e) {
                // Log error? For now fallback.
            }
        }

        return self::getDefaults();
    }

    /**
     * Save config for a specific lesson/year.
     *
     * @param int $lessonId
     * @param int $yearId
     * @param array $componentsArray [{'name', 'max_mark', 'data_source', 'sort_order'}, ...]
     * @return bool
     */
    public static function saveConfig($lessonId, $yearId, $componentsArray)
    {
        $path = "gradebook/{$lessonId}_{$yearId}.json";
        
        $data = [
            'lesson_id' => $lessonId,
            'year_id' => $yearId,
            'updated_at' => now()->toDateTimeString(),
            'components' => $componentsArray
        ];

        return Storage::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Get default legacy configuration.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getDefaults()
    {
        // Return collection of objects to mimic DB result
        return collect([
            (object) [
                'id' => 'legacy_oral', 
                'name' => 'المشاركة (Oral)', 
                'weight' => 0, // Default weight percentage
                'data_source' => 'LEGACY_ORAL', 
                'sort_order' => 1
            ],
            (object) [
                'id' => 'legacy_homework', 
                'name' => 'الوظائف (Homework)', 
                'weight' => 0, 
                'data_source' => 'LEGACY_HOMEWORK', 
                'sort_order' => 2
            ],
            (object) [
                'id' => 'legacy_exam', 
                'name' => 'الامتحان (Exam)', 
                'weight' => 0, 
                'data_source' => 'LEGACY_EXAM', 
                'sort_order' => 3
            ]
        ]);
    }
}
