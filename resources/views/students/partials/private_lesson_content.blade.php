<div class="col-md-4 step1">
    <article class="box">
        <div class="shape"><div class="number"><i class="material-icons" aria-hidden="true">description</i></div></div>
        <div class="slc-content-body">
            <p>{{ $content->name_addition }}</p>
            @if (app(\App\Services\LessonContentFeature::class)->enabled())
                @if (filled($content->note))<div class="slc-teacher-note">{{ $content->note }}</div>@endif
                <ul class="slc-attachments">
                    @foreach ($content->privateAttachments as $attachment)
                        <li>
                            <details class="slc-attachment-file">
                                <summary><bdi class="slc-attachment-name" dir="auto" title="{{ $attachment->original_name }}">{{ $attachment->original_name }}</bdi></summary>
                                <bdi class="slc-attachment-full" dir="auto">{{ $attachment->original_name }}</bdi>
                            </details>
                            <div class="slc-attachment-actions">
                                <a class="slc-content-action" href="{{ route('lesson_content.download',[$attachment->id,'view']) }}" target="_blank" rel="noopener">عرض</a>
                                <a class="slc-content-action" href="{{ route('lesson_content.download',[$attachment->id,'download']) }}">تنزيل</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if ($content->addition_link)<a class="slc-content-action" href="{{ $content->addition_link }}" target="_blank" rel="noopener">الرابط الخارجي</a>@endif
            @else
                <p>المحتوى غير متاح حالياً.</p>
            @endif
        </div>
    </article>
</div>
