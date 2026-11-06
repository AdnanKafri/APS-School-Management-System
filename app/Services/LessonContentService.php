<?php

namespace App\Services;

use App\Lecture;
use App\LessonContentAttachment;
use App\Lesson_teacher_room_term_exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LessonContentService
{
    public function create(Request $request)
    {
        app(LessonContentFeature::class)->requireEnabled();
        $request->validate([
            'lecture_id'=>'required|integer|min:1', 'teacher_id'=>'sometimes|integer|min:1',
            'class_id'=>'sometimes|integer|min:1', 'room_id'=>'sometimes|integer|min:1', 'lesson_id'=>'sometimes|integer|min:1',
        ]);
        $access = app(LessonContentAccess::class);
        $lecture = $access->teacherLecture($request->input('lecture_id'));
        foreach (['teacher_id','class_id','room_id','lesson_id'] as $field) {
            if ($request->has($field)) abort_unless((int)$request->input($field) === (int)$lecture->$field, 403);
        }
        $data = app(LessonContentInput::class)->read($request);
        $hash = hash_hmac('sha256', auth()->user()->teacher_id.':'.$data['token'], config('app.key'));
        $fingerprint = hash('sha256', json_encode([$lecture->id, $data['title'], $data['note'], $data['link'], $data['metadata']], JSON_THROW_ON_ERROR));
        $storage = app(LessonContentStorage::class);
        $begun = false;
        $notifications = [];
        try {
            $content = DB::transaction(function () use ($lecture, $access, $data, $hash, $fingerprint, $storage, &$begun, &$notifications) {
                Lecture::whereKey($lecture->id)->lockForUpdate()->firstOrFail();
                $access->teacherLecture($lecture->id);
                $existing = Lesson_teacher_room_term_exam::where('upload_request_hash', $hash)->lockForUpdate()->first();
                if ($existing) {
                    abort_if($existing->upload_deleted_at || !hash_equals($existing->upload_payload_hash, $fingerprint), 409, __('lesson_content.conflict'));
                    return $existing;
                }
                $begun = true; $storage->begin();
                $content = new Lesson_teacher_room_term_exam();
                $content->allowsPrivateMutation = true;
                foreach (['teacher_id','class_id','room_id','lesson_id','term_id'] as $field) $content->$field = $lecture->$field;
                $content->lecture_id = $lecture->id; $content->type = '4';
                $content->name_addition = $data['title']; $content->note = $data['note']; $content->addition_link = $data['link'];
                $content->upload_request_hash = $hash; $content->upload_payload_hash = $fingerprint; $content->upload_revision = 1;
                $content->save();
                foreach ($data['files'] as $position => $file) {
                    $meta = $data['metadata'][$position];
                    $path = $storage->store($file, $meta['extension']);
                    unset($meta['extension']);
                    $content->privateAttachments()->create($meta + ['disk'=>LessonContentStorage::DISK,'path'=>$path,'position'=>$position]);
                }
                if ((int)$lecture->active === 0 && $lecture->lecture_time && \Carbon\Carbon::parse($lecture->lecture_time, 'Asia/Damascus')->lte(\Carbon\Carbon::now('Asia/Damascus'))) {
                    foreach (\App\Student::currentMembership($lecture->year_id, $lecture->room_id)->pluck('students.id') as $studentId) {
                        $notice = new \App\Notification();
                        foreach (['room_id','lesson_id','term_id'] as $field) $notice->$field = $lecture->$field;
                        $notice->lecture_id = $lecture->id; $notice->student_id = $studentId; $notice->user_id = auth()->id();
                        $notice->type = 1; $notice->title = 'تم إضافة ملفات للدرس'; $notice->body = $data['title']; $notice->save();
                        $notifications[] = $notice->id;
                    }
                }
                return $content;
            });
        } catch (\Throwable $e) {
            if ($begun) {
                // An interrupted COMMIT may have succeeded. Retain its journal until ownership is certain.
                try {
                    $rollbackCertain = DB::transactionLevel() === 0 && !LessonContentAttachment::withTrashed()->whereIn('path', $storage->paths())->exists();
                } catch (\Throwable $ownershipError) { $rollbackCertain = false; }
                $storage->finish(false, $rollbackCertain);
            }
            throw $e;
        }
        if ($begun) $storage->finish(true);
        if ($notifications) {
            try { \App\Jobs\SendLessonContentNotification::dispatch($notifications); } catch (\Throwable $e) { report($e); }
        }
        return $content;
    }

    private function locked($id, Request $request)
    {
        app(LessonContentFeature::class)->requireEnabled();
        $content = Lesson_teacher_room_term_exam::whereKey($id)->lockForUpdate()->firstOrFail();
        abort_unless($content->isPrivateLessonContent() && !$content->upload_deleted_at, 404);
        $access = app(LessonContentAccess::class);
        $access->contentContext($content, $access->teacherLecture($content->lecture_id));
        $request->validate(['revision'=>'required|integer|min:1']);
        abort_unless((int)$request->input('revision') === (int)$content->upload_revision, 409, __('lesson_content.conflict'));
        $content->allowsPrivateMutation = true;
        return $content;
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $content = $this->locked($id, $request);
            $data = Validator::make($request->all(), ['name_addition'=>'required|string|max:500','note'=>'nullable|string|max:2000','addition_link'=>'nullable|url|max:2048'], [
                'note.max'=>'يجب ألا تتجاوز الملاحظات 2000 حرفاً.', 'name_addition.required'=>'يرجى إدخال عنوان المحتوى.',
            ])->validate();
            if (!empty($data['addition_link']) && !in_array(strtolower(parse_url($data['addition_link'], PHP_URL_SCHEME)), ['http','https'], true)) LessonContentInput::reject('الرابط غير صالح.', 'addition_link');
            if (empty($data['addition_link']) && !$content->privateAttachments()->exists()) LessonContentInput::reject('احتفظ بملف واحد أو رابط على الأقل.');
            $content->name_addition = $data['name_addition']; $content->note = $data['note'] ?? null; $content->addition_link = $data['addition_link'] ?? null;
            $content->upload_revision++; $content->save();
            return $content;
        });
    }

    public function remove($id, $attachmentId, Request $request)
    {
        $content = DB::transaction(function () use ($id, $attachmentId, $request) {
            $content = $this->locked($id, $request);
            $attachment = $content->privateAttachments()->whereKey($attachmentId)->lockForUpdate()->firstOrFail();
            if (!$content->addition_link && $content->privateAttachments()->count() <= 1) LessonContentInput::reject('لا يمكن إزالة آخر ملف. احذف المحتوى كاملاً عند الحاجة.');
            $attachment->delete(); $content->upload_revision++; $content->save();
            return $content;
        });
        $this->purgeRemoved($content->id);
        return $content;
    }

    public function delete($id, Request $request)
    {
        $content = DB::transaction(function () use ($id, $request) {
            $content = $this->locked($id, $request);
            $content->privateAttachments()->update(['deleted_at'=>now()]);
            $content->upload_deleted_at = now(); $content->upload_revision++; $content->save();
            return $content;
        });
        $this->purgeRemoved($content->id);
        return $content;
    }

    public function purgeRemoved($contentId = null)
    {
        app(LessonContentFeature::class)->requireEnabled();
        $pending = LessonContentAttachment::onlyTrashed()->whereNull('purged_at');
        if ($contentId !== null) $pending->where('content_id', $contentId);
        $count = 0;
        foreach ($pending->cursor() as $attachment) {
            try {
                if ($attachment->disk === LessonContentStorage::DISK && app(LessonContentStorage::class)->purge($attachment->path)) {
                    $attachment->purged_at = now(); $attachment->save(); $count++;
                }
            } catch (\Throwable $e) { report($e); }
        }
        return $count;
    }
}
