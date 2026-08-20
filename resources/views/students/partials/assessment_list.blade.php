@php
    $dayNames = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
@endphp

@if (session()->has('success') || session()->has('otherday') || session()->has('othertime') || $errors->any())
    <script>
        window.addEventListener('load', function () {
            @if (session()->has('success'))
                notif({ msg: @json(session('success')), type: 'success' });
            @endif
            @if (session()->has('otherday'))
                notif({ msg: @json(session('otherday')), type: 'warning' });
            @endif
            @if (session()->has('othertime'))
                notif({ msg: @json(session('othertime')), type: 'warning' });
            @endif
            @foreach ($errors->all() as $error)
                notif({ msg: @json($error), type: 'error' });
            @endforeach
        });
    </script>
@endif

<main class="main-panel">
    <div class="content-wrapper">
        <div class="sp-page">
            <section class="sp-page-header">
                <div class="sp-page-header__content">
                    <a class="sp-page-header__eyebrow" href="{{ route('student_exam') }}"><i class="mdi mdi-arrow-right"></i> الامتحانات والتقييمات</a>
                    <h1>{{ $assessmentTitle }}</h1>
                    <p>{{ $assessmentDescription }}</p>
                </div>
                <div class="sp-page-header__aside">
                    <div class="sp-header-stat"><span>المتاح في القائمة</span><strong>{{ $exams->count() }}</strong></div>
                    <div class="sp-header-stat"><span>الشعبة</span><strong>{{ $room_name }}</strong></div>
                </div>
            </section>

            <section class="sp-section">
                <div class="sp-section-header">
                    <div><h2>قائمة {{ $assessmentTitle }}</h2><p>{{ $class_name }} · {{ $room_name }}</p></div>
                </div>

                <div class="sp-assessment-list">
                    @forelse ($exams as $item)
                        @php
                            $hasResult = isset($item->result);
                            $isOpen = $now > $item->start_date && $now < $item->end_date;
                            $isEnded = $now > $item->end_date;
                            $subjectName = optional($item->lesson)->name ?: 'مادة غير محددة';
                        @endphp
                        <article class="sp-card sp-assessment-card">
                            <div class="sp-assessment-card__main">
                                <span class="sp-assessment-card__number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="sp-assessment-card__title">
                                    <span class="sp-badge {{ $item->is_file == 1 ? 'sp-badge--warning' : 'sp-badge--info' }}">{{ $item->is_file == 1 ? 'ملف' : 'مؤتمت' }}</span>
                                    <h3>{{ $item->name }}</h3>
                                    <p>{{ $subjectName }}</p>
                                </div>
                            </div>

                            <div class="sp-assessment-card__meta">
                                <span><i class="mdi mdi-calendar"></i><small>التاريخ</small><strong>{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</strong></span>
                                <span><i class="mdi mdi-clock-outline"></i><small>الوقت</small><strong>{{ \Carbon\Carbon::parse($item->start_date)->format('g:i a') }}</strong></span>
                                <span><i class="mdi mdi-calendar-today"></i><small>اليوم</small><strong>{{ $dayNames[(int) $item->day] ?? 'غير محدد' }}</strong></span>
                                <span><i class="mdi mdi-timer-outline"></i><small>المدة</small><strong>{{ $item->period }}</strong></span>
                            </div>

                            <div class="sp-assessment-card__actions">
                                <button type="button" class="sp-btn sp-btn--soft exam-required" data-toggle="modal" data-target="#requirementsModal" data-required="{{ $item->required }}" data-name="{{ $item->name }}" data-lesson-name="{{ $subjectName }}"><i class="mdi mdi-information-outline"></i> المطلوب</button>

                                @if ($hasResult)
                                    @if ($item->result != -1)
                                        <a class="sp-btn sp-btn--primary" href="{{ route('dashboard.student.exam.view_main_exam', $item->id) }}"><i class="mdi mdi-chart-box-outline"></i> النتيجة {{ $item->result }}/{{ $item->mark }}</a>
                                    @else
                                        <span class="sp-badge sp-badge--warning">قيد التصحيح</span>
                                    @endif
                                @elseif ($item->is_file == '0')
                                    @if ($isOpen)
                                        <a class="sp-btn sp-btn--primary" href="{{ route('dashboard.student.start_main_exam', $item->id) }}" target="_blank" rel="noopener"><i class="mdi mdi-play-circle-outline"></i> {{ $startLabel }}</a>
                                    @elseif ($isEnded)
                                        <span class="sp-badge sp-badge--danger">انتهى</span>
                                    @else
                                        <span class="sp-badge sp-badge--info">مخطط له</span>
                                    @endif
                                @elseif ($isOpen)
                                    @if ($item->file)
                                        <a class="sp-btn sp-btn--soft" href="{{ asset('storage/' . $item->file) }}" target="_blank" rel="noopener"><i class="mdi mdi-download-outline"></i> تنزيل الأسئلة</a>
                                    @endif
                                    <button type="button" class="sp-btn sp-btn--primary upload-files" data-toggle="modal" data-target="#uploadFilesModal" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-lesson-name="{{ $subjectName }}"><i class="mdi mdi-upload-outline"></i> رفع الحل</button>
                                @elseif ($isEnded)
                                    <span class="sp-badge sp-badge--danger">انتهى</span>
                                @else
                                    <span class="sp-badge sp-badge--info">مخطط له</span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-clipboard-text-off-outline"></i></span><h3>لا توجد {{ $assessmentTitle }} متاحة</h3><p>ستظهر التقييمات هنا عند نشرها لشعبتك.</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>

<div class="modal fade" id="requirementsModal" tabindex="-1" role="dialog" aria-labelledby="requirementsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="requirementsModalLabel">المطلوب دراسته</h5><button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button></div>
            <div class="modal-body">
                <div class="sp-field"><label>اسم {{ $assessmentSingular }}</label><input type="text" readonly class="form-control js-assessment-name"></div>
                <div class="sp-field mt-3"><label>المادة</label><input type="text" readonly class="form-control js-assessment-subject"></div>
                <div class="sp-field mt-3"><label>المطلوب</label><textarea readonly rows="6" class="form-control js-assessment-required"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="sp-btn sp-btn--soft" data-dismiss="modal">إغلاق</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadFilesModal" tabindex="-1" role="dialog" aria-labelledby="uploadFilesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('dashboard.student.upload_exam_files') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="exam_id" class="js-upload-exam-id">
                <div class="modal-header"><h5 class="modal-title" id="uploadFilesModalLabel">رفع الحل</h5><button type="button" class="close" data-dismiss="modal" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button></div>
                <div class="modal-body">
                    <div class="sp-field"><label>اسم المحتوى</label><input type="text" name="content_name" readonly class="form-control js-upload-name"></div>
                    <div class="sp-field mt-3"><label>المادة</label><input type="text" readonly class="form-control js-upload-subject"></div>
                    <div class="sp-field mt-3"><label for="assessmentFiles">ملفات الحل</label><input id="assessmentFiles" name="file[]" class="form-control-file" type="file" multiple required><small class="sp-muted">يمكن رفع عدة ملفات معاً.</small></div>
                </div>
                <div class="modal-footer"><button type="button" class="sp-btn sp-btn--soft" data-dismiss="modal">إلغاء</button><button type="submit" class="sp-btn sp-btn--primary">تأكيد الرفع</button></div>
            </form>
        </div>
    </div>
</div>
