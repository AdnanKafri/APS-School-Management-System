<?php

namespace App\Services;

use App\LessonContentAttachment;

class LessonContentRecovery
{
    public function run($execute = false)
    {
        app(LessonContentFeature::class)->requireEnabled();
        $storage = app(LessonContentStorage::class); $disk = $storage->disk();
        $result = ['unowned_files'=>0, 'purged_files'=>0, 'skipped_journals'=>0, 'removed_attachments'=>0];
        foreach ($disk->files('journals') as $journal) {
            if (!preg_match('~^journals/[a-f0-9-]{36}\.json$~D', $journal) || $disk->lastModified($journal) > time()-3600) continue;
            $handle = fopen($disk->path($journal), 'r+b');
            if (!$handle) continue;
            if (!flock($handle, LOCK_EX | LOCK_NB)) { fclose($handle); $result['skipped_journals']++; continue; }
            $clean = true;
            try {
                $data = json_decode(stream_get_contents($handle), true);
                if (!is_array($data['paths'] ?? null) || count($data['paths']) > 5) { $clean = false; continue; }
                foreach ($data['paths'] as $path) {
                    if (!$storage->validPath($path)) { $clean = false; continue; }
                    if (LessonContentAttachment::withTrashed()->where('path', $path)->exists()) continue;
                    $result['unowned_files']++;
                    if ($execute) {
                        if ($storage->purge($path)) $result['purged_files']++; else $clean = false;
                    }
                }
            } finally { flock($handle, LOCK_UN); fclose($handle); }
            if ($execute && $clean) $disk->delete($journal);
        }
        if ($execute) $result['removed_attachments'] = app(LessonContentService::class)->purgeRemoved();
        return $result;
    }
}
