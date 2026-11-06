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
        $data = Validator::make($request->all(), [
            'name_addition'=>'required|string|max:500', 'note'=>'nullable|string|max:2000',
            'addition_link'=>'nullable|url|max:2048', 'upload_token'=>'nullable|uuid',
            'attachment_count'=>'nullable|required_with:attachments|integer|min:0|max:5',
        ], [
            'name_addition.required'=>'يرجى إدخال عنوان المحتوى.', 'name_addition.max'=>'العنوان أطول من 500 حرف.',
            'note.max'=>'يجب ألا تتجاوز الملاحظات 2000 حرف.', 'note.string'=>'يرجى إدخال الملاحظات كنص.',
            'addition_link.url'=>'يرجى إدخال رابط صحيح يبدأ بـ http أو https.',
            'upload_token.uuid'=>'انتهت صلاحية نموذج الرفع. يرجى إعادة فتح الصفحة.',
            'attachment_count.max'=>'يمكن رفع خمسة ملفات كحد أقصى.',
            'attachment_count.required_with'=>'يرجى إعادة فتح نموذج الرفع لاكتمال التحقق من عدد الملفات.',
        ])->validate();
        if (!empty($data['addition_link']) && !in_array(strtolower(parse_url($data['addition_link'], PHP_URL_SCHEME)), ['http','https'], true)) {
            self::reject('يرجى إدخال رابط يبدأ بـ http أو https.', 'addition_link');
        }
        if ((int)$request->server('CONTENT_LENGTH', 0) > 26 * 1024 * 1024) self::reject('حجم طلب الرفع أكبر من الحد المسموح.');
        $all = $request->all();
        if (array_key_exists('attachments', $all) && array_key_exists('addition', $all)) self::reject('يرجى استخدام حقل ملفات واحد.');
        $files = $all['attachments'] ?? (isset($all['addition']) ? [$all['addition']] : []);
        if (!is_array($files) || count($files) > 5 || array_keys($files) !== range(0, count($files)-1) && $files !== []) {
            self::reject('يرجى اختيار قائمة ملفات صحيحة لا تتجاوز خمسة ملفات.');
        }
        if (array_key_exists('attachments', $all) && empty($data['upload_token'])) self::reject('يرجى إعادة فتح نموذج الرفع.', 'upload_token');
        if (isset($data['attachment_count']) && (int)$data['attachment_count'] !== count($files)) self::reject('لم تصل جميع الملفات. يرجى إعادة اختيارها والتحقق من حدود الرفع.');
        if (!$files && empty($data['addition_link'])) self::reject('يرجى اختيار ملف واحد على الأقل أو إدخال رابط خارجي.');
        $total = 0;
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) self::reject('تعذر استقبال أحد الملفات. يرجى إعادة اختياره.');
            $size = $file->getSize();
            if ($size <= 0 || $size > 10 * 1024 * 1024) self::reject('يجب أن يكون حجم كل ملف أكبر من صفر وألا يتجاوز 10 MiB.');
            $total += $size;
            if ($total > 25 * 1024 * 1024) self::reject('يجب ألا يتجاوز مجموع الملفات 25 MiB.');
        }
        $metadata = [];
        foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            if (!preg_match('/^.{1,255}$/us', $name) || preg_match('~[\x00-\x1f\x7f/\\\\]~u', $name)) self::reject('اسم أحد الملفات غير صالح أو أطول من 255 حرفاً.');
            [$mime, $extension] = $this->type($file);
            $metadata[] = ['original_name'=>$name, 'mime_type'=>$mime, 'extension'=>$extension,
                'size_bytes'=>$file->getSize(), 'sha256'=>hash_file('sha256', $file->getRealPath())];
        }
        return ['title'=>$data['name_addition'], 'note'=>$data['note'] ?? null, 'link'=>$data['addition_link'] ?? null,
            'token'=>$data['upload_token'] ?? (string)Str::uuid(), 'files'=>array_values($files), 'metadata'=>$metadata];
    }

    private function type(UploadedFile $file)
    {
        $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file->getRealPath());
        $types = [
            'pdf'=>['application/pdf'], 'jpg'=>['image/jpeg'], 'jpeg'=>['image/jpeg'],
            'png'=>['image/png'], 'gif'=>['image/gif'], 'webp'=>['image/webp'],
            'txt'=>['text/plain'], 'csv'=>['text/plain','text/csv','application/csv'], 'sha256sum'=>['text/plain'],
            'mp3'=>['audio/mpeg'], 'mp4'=>['video/mp4'], 'mov'=>['video/quicktime'],
            'avi'=>['video/x-msvideo','video/avi'], 'mpeg'=>['video/mpeg'],
            'docx'=>['application/zip','application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'xlsx'=>['application/zip','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            'pptx'=>['application/zip','application/vnd.openxmlformats-officedocument.presentationml.presentation'],
        ];
        if (!isset($types[$extension]) || !in_array($mime, $types[$extension], true)) self::reject('نوع أحد الملفات غير مسموح أو لا يطابق محتواه.');
        if (in_array($extension, ['docx','xlsx','pptx'], true)) {
            $zip = new \ZipArchive();
            if ($zip->open($file->getRealPath()) !== true) self::reject('ملف Office غير صالح.');
            try {
                $directory = ['docx'=>'word/','xlsx'=>'xl/','pptx'=>'ppt/'][$extension];
                if ($zip->numFiles > 2000 || $zip->locateName('[Content_Types].xml') === false) self::reject('ملف Office غير صالح.');
                $bytes = 0; $found = false;
                for ($i=0;$i<$zip->numFiles;$i++) {
                    $stat = $zip->statIndex($i); $entry = $stat['name']; $bytes += $stat['size'];
                    if (strpos($entry, $directory) === 0) $found = true;
                    if ($bytes > 100 * 1024 * 1024 || preg_match('~(^/|(^|/)\.\.(/|$)|\\\\|vbaproject|\.exe$|\.js$)~i', $entry)) self::reject('ملف Office يحتوي على محتوى غير مسموح.');
                }
                if (!$found) self::reject('امتداد ملف Office لا يطابق محتواه.');
            } finally { $zip->close(); }
            $mime = $types[$extension][1];
        }
        return [$mime, $extension === 'sha256sum' ? 'txt' : $extension];
    }
}
