<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\LessonContentAttachment;
use App\Services\LessonContentAccess;
use App\Services\LessonContentFeature;
use App\Services\LessonContentService;
use App\Services\LessonContentStorage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class LessonContentController extends Controller
{
    public function store(Request $request) { return $this->mutate($request, function () use ($request) { return app(LessonContentService::class)->create($request); }, 'saved'); }
    public function update($content, Request $request) { return $this->mutate($request, function () use ($content,$request) { return app(LessonContentService::class)->update($content,$request); }, 'saved'); }
    public function remove($content, $attachment, Request $request) { return $this->mutate($request, function () use ($content,$attachment,$request) { return app(LessonContentService::class)->remove($content,$attachment,$request); }, 'removed'); }
    public function destroy($content, Request $request) { return $this->mutate($request, function () use ($content,$request) { return app(LessonContentService::class)->delete($content,$request); }, 'deleted'); }

    private function mutate(Request $request, callable $operation, $message)
    {
        try { $content = $operation(); }
        catch (ValidationException $e) { throw $e; }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { throw $e; }
        catch (\Throwable $e) {
            if ($e instanceof HttpExceptionInterface && $e->getStatusCode() !== 409) throw $e;
            $conflict = $e instanceof HttpExceptionInterface || ($e instanceof QueryException && in_array((string)$e->getCode(), ['23000','40001'], true));
            if (!$conflict) report($e);
            $text = __('lesson_content.'.($conflict?'conflict':'failed'));
            return $request->expectsJson() ? response()->json(['message'=>$text],$conflict?409:500)
                : redirect()->back()->withErrors(['lesson_content'=>$text])->withInput($request->except(['attachments','addition','_token']));
        }
        $pending = LessonContentAttachment::onlyTrashed()->where('content_id',$content->id)->whereNull('purged_at')->exists();
        $text = __('lesson_content.'.$message).($pending?' '.__('lesson_content.cleanup_pending'):'');
        if ($request->expectsJson()) return response()->json(['message'=>$text,'content_id'=>$content->id,'revision'=>$content->upload_revision]);
        $lecture = Lecture::findOrFail($content->lecture_id);
        return redirect()->route('dashboard.student.lessons.book_details',[$lecture->lesson_id,$lecture->teacher_id,$lecture->room_id,$lecture->id])->with('success',$text);
    }

    public function download($attachment, $mode = 'download')
    {
        app(LessonContentFeature::class)->requireEnabled();
        $file = LessonContentAttachment::findOrFail($attachment);
        app(LessonContentAccess::class)->download($file->content);
        $storage = app(LessonContentStorage::class);
        abort_unless($file->disk === LessonContentStorage::DISK && $storage->validPath($file->path) && $storage->disk()->exists($file->path),404);
        $response = response()->file($storage->disk()->path($file->path),[
            'Content-Type'=>$file->mime_type,'Cache-Control'=>'private, no-store, max-age=0',
            'X-Content-Type-Options'=>'nosniff','Content-Security-Policy'=>"sandbox; default-src 'none'",
        ]);
        $inline = $mode === 'view' && in_array($file->mime_type,['application/pdf','image/jpeg','image/png','image/gif','image/webp'],true);
        $response->setContentDisposition($inline?'inline':'attachment',$file->original_name,'attachment-'.(int)$file->id);
        return $response;
    }
}
