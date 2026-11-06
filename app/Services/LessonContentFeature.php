<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;

class LessonContentFeature
{
    public function enabled()
    {
        if (!config('lesson_content.enabled', false)) return false;
        $request = request();
        if (!$request->attributes->has('_lesson_content_schema_ready')) {
            $request->attributes->set('_lesson_content_schema_ready', Schema::hasTable('lesson_content_attachments')
                && Schema::hasColumns('lesson_teacher_room_term_exam', ['note', 'upload_request_hash', 'upload_payload_hash', 'upload_revision', 'upload_deleted_at']));
        }
        return $request->attributes->get('_lesson_content_schema_ready');
    }

    public function requireEnabled()
    {
        abort_unless($this->enabled(), 404);
    }
}
