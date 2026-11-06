<div class="col-md-4 newrow">
    <article class="card12 lc-private-content">
        <h6>{{ $content->name_addition }}</h6>
        @if (app(\App\Services\LessonContentFeature::class)->enabled())
            @if (filled($content->note))<div class="lc-content-note">{{ $content->note }}</div>@endif
            <ul class="lc-attachment-list">
                @foreach ($content->privateAttachments as $attachment)
                    <li>
                        <bdi dir="auto">{{ $attachment->original_name }}</bdi>
                        <a href="{{ route('lesson_content.download',[$attachment->id,'download']) }}">تنزيل</a>
                        @if ($canManageLessonContent)
                        <form action="{{ route('teacher.lesson_content.remove',[$content->id,$attachment->id]) }}" method="post" data-lesson-manage data-confirm="هل تريد إزالة هذا الملف فقط؟">
                            @csrf
                            <input type="hidden" name="revision" value="{{ $content->upload_revision }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm">إزالة الملف</button>
                        </form>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if ($content->addition_link)<a href="{{ $content->addition_link }}" target="_blank" rel="noopener">الرابط الخارجي</a>@endif
            @if ($canManageLessonContent)
            <details class="lc-content-edit">
                <summary>تعديل العنوان والملاحظات</summary>
                <form action="{{ route('teacher.lesson_content.update',$content->id) }}" method="post" data-lesson-manage>
                    @csrf
                    <input type="hidden" name="revision" value="{{ $content->upload_revision }}">
                    <label for="content-title-{{ $content->id }}">عنوان المحتوى</label>
                    <input class="form-control" id="content-title-{{ $content->id }}" name="name_addition" value="{{ $content->name_addition }}" maxlength="500" required>
                    <label for="content-note-{{ $content->id }}">ملاحظات للطلاب (اختياري)</label>
                    <textarea class="form-control" id="content-note-{{ $content->id }}" name="note" rows="5" maxlength="2000">{{ $content->note }}</textarea>
                    <label for="content-link-{{ $content->id }}">رابط خارجي (اختياري)</label>
                    <input class="form-control" id="content-link-{{ $content->id }}" name="addition_link" value="{{ $content->addition_link }}" dir="ltr" maxlength="2048">
                    <button type="submit" class="btn btn-primary mt-3">حفظ التعديلات</button>
                </form>
            </details>
            <form action="{{ route('teacher.lesson_content.delete',$content->id) }}" method="post" data-lesson-manage data-confirm="هل تريد حذف هذا المحتوى وجميع ملفاته؟">
                @csrf
                <input type="hidden" name="revision" value="{{ $content->upload_revision }}">
                <button type="submit" class="btn btn-outline-danger mt-3">حذف المحتوى</button>
            </form>
            @endif
        @else
            <p>المحتوى غير متاح حالياً.</p>
        @endif
    </article>
</div>
