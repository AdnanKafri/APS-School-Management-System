<?php

namespace App\Services;

use App\Exam_file;
use App\Exams2;
use App\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** Legacy mobile wire format, with atomic rows and compensating file cleanup. */
class MobileAssessmentSubmission
{
    public function upload($request, $multiple = false)
    {
        $fail = function ($message) { return response()->json(['status' => false, 'msg' => $message]); };
        if (!isset($request->extension)) return $fail(' extension is required');
        if (!$request->item_id) return $fail('item_id is required');
        if (!Exams2::whereKey($request->item_id)->exists()) return $fail(' item is not existed   ');
        if (!isset($request->file) || $request->file === '' || $request->file === 'null') return $fail('file is required');
        $files = $multiple ? json_decode($request->file, true) : [$request->file];
        $extensions = $multiple ? json_decode($request->extension, true) : [$request->extension];
        if (!is_array($files) || !is_array($extensions) || !$files || count($files) !== count($extensions)
            || array_keys($files) !== range(0, count($files) - 1) || array_keys($extensions) !== array_keys($files)) {
            return $fail(__('gradebook.write_failed'));
        }
        $decoded = [];
        foreach ($files as $index => $file) {
            $extension = $extensions[$index];
            if (!is_string($extension) || !preg_match('/^\.?[a-zA-Z0-9]+$/D', $extension)
                || !is_string($file) || ($bytes = base64_decode($file, true)) === false || $bytes === '') {
                return $fail(__('gradebook.write_failed'));
            }
            $decoded[] = [$bytes, $extension];
        }
        $written = [];
        $disk = Storage::disk('public');
        try {
            DB::transaction(function () use ($request, $decoded, $disk, &$written) {
                Student::operational()->whereKey($request->student_id)->lockForUpdate()->firstOrFail();
                $content = Exams2::whereKey($request->item_id)->lockForUpdate()->firstOrFail();
                $year = \App\Year::where('current_year', 1)->lockForUpdate()->first();
                $room = $year ? \App\Room::whereKey($content->room_id)->where('year_id', $year->id)->first() : null;
                // The assessment owns its actual term, not another year's current flag.
                if (!$room || (int)$content->class_id !== (int)$room->class_id
                    || !\App\Term_year::whereKey($content->term_id)->where('year_id', $year->id)->exists()
                    || !\App\Lesson::whereKey($content->lesson_id)->where('class_id', $room->class_id)->exists()
                    || !Student::currentMembership($year->id, $room->id)->whereKey($request->student_id)->exists()) {
                    AssessmentResultSafety::reject('context_invalid');
                }
                foreach ($decoded as [$bytes, $extension]) {
                    $path = 'filesstudents/'.Str::uuid().'.'.ltrim($extension, '.');
                    $written[] = $path; // Also compensate a write that fails partway through.
                    if (!$disk->put($path, $bytes)) throw new \RuntimeException('Mobile submission storage write failed.');
                    $record = new Exam_file;
                    $record->forceFill(['file'=>$path, 'extension'=>$extension, 'exam_id'=>$content->id,
                        'student_id'=>$request->student_id, 'room_id'=>$room->id, 'lesson_id'=>$content->lesson_id,
                        'class_id'=>$content->class_id, 'term_id'=>$content->term_id])->save();
                }
            });
        } catch (\Throwable $e) {
            foreach ($written as $path) {
                try {
                    if (!$disk->delete($path)) throw new \RuntimeException('Mobile submission cleanup failed.');
                } catch (\Throwable $cleanup) { report($cleanup); }
            }
            report($e);
            return $fail(__('gradebook.write_failed'));
        }
        return response()->json(['status'=>true, 'msg'=>'تم الترفيع بنجاح']);
    }
}
