<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Legacy media-only tabs keep their public paths; source/documents use private Files. */
class TeacherLessonMedia
{
    public function save($content, $column, Request $request, $field, $kind)
    {
        if (!in_array([$column,$kind],[['video','video'],['audio_file','audio']],true)) throw new \InvalidArgumentException('Invalid media field.');
        $policy=app(LessonContentLimits::class); $limits=$policy->values(); $file=$request->file($field);
        if (count(\Illuminate\Support\Arr::flatten($request->allFiles())) !== 1) LessonContentInput::reject(__('lesson_content.limit_count',['count'=>1]),$field);
        if (!$file instanceof UploadedFile || !$file->isValid()) LessonContentInput::reject(__('lesson_content.server_limit'),$field);
        if ((int)$request->server('CONTENT_LENGTH',0) > $policy->requestBytes()) LessonContentInput::reject($policy->message('limit_request'),$field);
        if ($file->getSize() <= 0 || $file->getSize() > $limits['max_file_bytes']) LessonContentInput::reject($policy->message('limit_file'),$field);
        if ($file->getSize() > $limits['max_total_bytes']) LessonContentInput::reject($policy->message('limit_total'),$field);
        $type=app(LessonContentFileTypes::class)->inspect($file);
        if ($type['kind'] !== $kind) LessonContentInput::reject(__('lesson_content.invalid_type'),$field);
        $disk=Storage::disk('public'); $path='filesteachers/'.Str::random(40).'.'.$type['extension'];
        try {
            if (!$disk->putFileAs('filesteachers',$file,basename($path))) throw new \RuntimeException('Unable to store Teacher media.');
            $content->$column=$path; $content->extension=$type['extension']; $content->save();
        } catch (\Throwable $e) {
            try {
                // A lost response to INSERT/UPDATE does not prove that it rolled back.
                $owned=$content->newQuery()->where($column,$path)->exists();
                if (!$owned && $disk->exists($path)) $disk->delete($path);
            } catch (\Throwable $cleanup) { report($cleanup); }
            throw $e;
        }
        // Never destroy the previous file before a replacement is safely saved.
    }
}
