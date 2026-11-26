<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LessonContentInput
{
    public static function reject($message, $field = 'attachments')
    {
        throw ValidationException::withMessages([$field => $message]);
    }

    public function read(Request $request)
    {
        $policy = app(LessonContentLimits::class);
        $limits = $policy->values();
        $data = Validator::make($request->all(), [
            'name_addition'=>'required|string|max:500', 'note'=>'nullable|string|max:2000',
            'addition_link'=>'nullable|url|max:2048', 'upload_token'=>'nullable|uuid',
            'attachment_count'=>'nullable|required_with:attachments|integer|min:0|max:'.$limits['max_files'],
        ], [
            'name_addition.required'=>'يرجى إدخال عنوان المحتوى.', 'name_addition.max'=>'العنوان أطول من 500 حرف.',
            'note.max'=>'يجب ألا تتجاوز الملاحظات 2000 حرف.', 'note.string'=>'يرجى إدخال الملاحظات كنص.',
            'addition_link.url'=>'يرجى إدخال رابط صحيح يبدأ بـ http أو https.',
            'upload_token.uuid'=>'انتهت صلاحية نموذج الرفع. يرجى إعادة فتح الصفحة.',
            'attachment_count.max'=>$policy->message('limit_count'),
            'attachment_count.required_with'=>'يرجى إعادة فتح نموذج الرفع لاكتمال التحقق من عدد الملفات.',
        ])->validate();
        if (!empty($data['addition_link']) && !in_array(strtolower(parse_url($data['addition_link'], PHP_URL_SCHEME)), ['http','https'], true)) {
            self::reject('يرجى إدخال رابط يبدأ بـ http أو https.', 'addition_link');
        }
        if ((int)$request->server('CONTENT_LENGTH', 0) > $policy->requestBytes()) self::reject($policy->message('limit_request'));
        $all = $request->all();
        if (array_diff(array_keys($request->allFiles()),['attachments','addition'])) self::reject('يرجى استخدام حقل ملفات واحد.');
        if (array_key_exists('attachments', $all) && array_key_exists('addition', $all)) self::reject('يرجى استخدام حقل ملفات واحد.');
        $files = $all['attachments'] ?? (isset($all['addition']) ? [$all['addition']] : []);
        if (!is_array($files) || count($files) > $limits['max_files'] || array_keys($files) !== range(0, count($files)-1) && $files !== []) {
            self::reject($policy->message('limit_count'));
        }
        if (array_key_exists('attachments', $all) && empty($data['upload_token'])) self::reject('يرجى إعادة فتح نموذج الرفع.', 'upload_token');
        if (isset($data['attachment_count']) && (int)$data['attachment_count'] !== count($files)) self::reject('لم تصل جميع الملفات. يرجى إعادة اختيارها والتحقق من حدود الرفع.');
        if (!$files && empty($data['addition_link'])) self::reject('يرجى اختيار ملف واحد على الأقل أو إدخال رابط خارجي.');
        $total = 0;
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && in_array($file->getError(), [UPLOAD_ERR_INI_SIZE,UPLOAD_ERR_FORM_SIZE], true)) self::reject(__('lesson_content.server_limit'));
            if (!$file instanceof UploadedFile || !$file->isValid()) self::reject('تعذر استقبال أحد الملفات. يرجى إعادة اختياره.');
            $size = $file->getSize();
            if ($size <= 0 || $size > $limits['max_file_bytes']) self::reject($policy->message('limit_file'));
            $total += $size;
            if ($total > $limits['max_total_bytes']) self::reject($policy->message('limit_total'));
        }
        $metadata = [];
        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            if (!preg_match('/^.{1,255}$/us', $name) || preg_match('~[\x00-\x1f\x7f/\\\\]~u', $name)) self::reject('اسم أحد الملفات غير صالح أو أطول من 255 حرفاً.');
            $type = app(LessonContentFileTypes::class)->inspect($file);
            $metadata[] = ['original_name'=>$name, 'mime_type'=>$type['mime_type'], 'extension'=>$type['extension'],
                'size_bytes'=>$file->getSize(), 'sha256'=>hash_file('sha256', $file->getRealPath())];
        }
        return ['title'=>$data['name_addition'], 'note'=>$data['note'] ?? null, 'link'=>$data['addition_link'] ?? null,
            'token'=>$data['upload_token'] ?? (string)Str::uuid(), 'files'=>array_values($files), 'metadata'=>$metadata];
    }

}
