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
                            $isOpen = $now > $item->start_date && $now < $item->end_date;
                            $isEnded = $now > $item->end_date;
                            $subjectName = optional($item->lesson)->name ?: 'مادة غير محددة';
                        @endphp
                        <article class="sp-card sp-assessment-card sp-assessment-card--compact">
                            <div class="sp-assessment-card__title">
                                <h3>{{ $subjectName }}</h3>
                                <p>{{ $item->name }}</p>
                            </div>
                            <div class="sp-assessment-card__actions">
                                @if ($item->result_state === 'earned')
                                    <a class="sp-assessment-result" href="{{ route('dashboard.student.exam.view_main_exam', $item->result_exam_id) }}">
                                        <span>{{ __('student_assessments.result') }}</span>
                                        <strong dir="ltr">{{ $item->result_value }}@if ($item->mark > 0) / {{ $item->mark }}@endif</strong>
                                    </a>
                                @else
                                    <span class="sp-badge sp-badge--info">{{ __('student_assessments.'.$item->result_state) }}</span>
                                @endif
                                @if ($item->is_file == '0' && $item->can_participate)
                                    @if ($isOpen)
                                        <a class="sp-btn sp-btn--primary" href="{{ route('dashboard.student.start_main_exam', $item->id) }}" target="_blank" rel="noopener">{{ $startLabel }}</a>
                                    @else
                                        <span class="sp-muted">{{ $isEnded ? 'انتهى' : 'مخطط له' }}</span>
                                    @endif
                                @endif
                            </div>
                            @if ($item->is_file == '0' && ($item->required || $item->file))
                                <details class="sp-assessment-card__details">
                                    <summary>{{ __('student_assessments.details') }}</summary>
                                    @if ($item->required)<p>{{ $item->required }}</p>@endif
                                    <div class="sp-actions-row">
                                        @if ($item->file && $isOpen)
                                            <a class="sp-btn sp-btn--soft" href="{{ asset('storage/' . $item->file) }}" target="_blank" rel="noopener">تنزيل الأسئلة</a>
                                        @endif
                                    </div>
                                </details>
                            @endif
                        </article>
                    @empty
                        <div class="sp-empty"><span class="sp-empty__icon"><i class="mdi mdi-clipboard-text-off-outline"></i></span><h3>لا توجد {{ $assessmentTitle }} متاحة</h3><p>ستظهر التقييمات هنا عند نشرها لشعبتك.</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>
