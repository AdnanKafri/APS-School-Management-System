@extends('teachers2.layouts.app')

@section('teacher_page_title', __('student_follow_up.title'))
@section('teacher_page_subtitle', __('student_follow_up.subtitle'))

@push('page_styles')
    @include('teachers2.student_follow_ups.partials.styles')
@endpush

@section('content')
<div class="main-panel student-follow-up-module">
    <div class="content-wrapper">
        <div class="fu-shell">
            <section class="fu-surface fu-page-head" aria-labelledby="follow-up-page-title">
                <div class="fu-page-head__copy">
                    <span class="fu-eyebrow">
                        <i class="mdi mdi-account-check" aria-hidden="true"></i>
                        {{ __('student_follow_up.monthly_follow_up') }}
                    </span>
                    <h1 class="fu-page-title" id="follow-up-page-title">{{ __('student_follow_up.title') }}</h1>
                    <p class="fu-page-subtitle">{{ __('student_follow_up.subtitle') }}</p>
                </div>

                @if($year)
                    <div class="fu-page-head__aside">
                        <span class="fu-year-chip">
                            <i class="mdi mdi-calendar-check" aria-hidden="true"></i>
                            {{ __('student_follow_up.academic_year') }}: {{ $year->name }}
                        </span>
                    </div>
                @endif
            </section>

            @if($assignments->isEmpty())
                <section class="fu-surface fu-empty" role="status">
                    <span class="fu-empty__icon"><i class="mdi mdi-book-open-page-variant" aria-hidden="true"></i></span>
                    <h3>{{ __('student_follow_up.empty_title') }}</h3>
                    <p>{{ __('student_follow_up.empty_text') }}</p>
                </section>
            @else
                <section class="fu-assignment-grid" aria-label="{{ __('student_follow_up.assignments') }}">
                    @foreach($assignments as $assignment)
                        @php
                            $progress = $assignmentProgress[$assignment->id] ?? ['total' => 0, 'complete' => 0, 'needs_current' => 0];
                            $percentage = $progress['total'] > 0
                                ? min(100, (int) round(($progress['complete'] / $progress['total']) * 100))
                                : 0;
                        @endphp
                        <article class="fu-surface fu-assignment-card">
                            <div>
                                <span class="fu-assignment-card__icon"><i class="mdi mdi-book-open-variant" aria-hidden="true"></i></span>
                                <h2 class="fu-assignment-card__title">{{ $assignment->lesson_name }}</h2>
                                <div class="fu-assignment-card__context">
                                    {{ $assignment->class_name }}
                                    <span aria-hidden="true">·</span>
                                    {{ __('student_follow_up.section') }} {{ $assignment->room_name }}
                                </div>
                            </div>

                            <div>
                                <div class="fu-progress-row">
                                    <span>{{ __('student_follow_up.month_progress', ['month' => __('student_follow_up.months.' . $now->month)]) }}</span>
                                    <strong>{{ $progress['complete'] }} {{ __('student_follow_up.of') }} {{ $progress['total'] }}</strong>
                                </div>
                                <div class="fu-progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $progress['total'] }}" aria-valuenow="{{ $progress['complete'] }}">
                                    <span style="width: {{ $percentage }}%"></span>
                                </div>
                            </div>

                            <div class="fu-assignment-card__footer">
                                <span class="fu-need-label">
                                    {{ __('student_follow_up.needs_count', ['count' => $progress['needs_current']]) }}
                                </span>
                                <a class="fu-btn fu-btn--primary" href="{{ route('teacher.student_follow_ups.roster', $assignment->id) }}">
                                    {{ __('student_follow_up.open') }}
                                    <i class="mdi mdi-arrow-left" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </section>
            @endif
        </div>
    </div>
</div>
@endsection
