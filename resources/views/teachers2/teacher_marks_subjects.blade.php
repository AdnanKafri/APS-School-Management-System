@extends('teachers2.layouts.app')

@section('teacher_page_title')
{{ __('teacher_portal.marks.title') }}
@endsection

@section('teacher_page_subtitle')
{{ __('teacher_portal.marks.subtitle') }}
@endsection

@section('css')
<style>
    .teacher-assessment-shell {
        display: grid;
        gap: 1.25rem;
    }

    .teacher-assessment-hero {
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 26px;
        padding: 1.25rem 1.35rem;
        background:
            radial-gradient(circle at top right, rgba(16, 185, 129, 0.14), transparent 30%),
            linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
    }

    .teacher-assessment-hero__grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 1rem;
        align-items: center;
    }

    .teacher-assessment-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        background: rgba(16, 185, 129, 0.08);
        color: #059669;
        font-weight: 700;
        font-size: 0.82rem;
        margin-bottom: 0.75rem;
    }

    .teacher-assessment-hero__title {
        margin: 0;
        font-size: clamp(1.38rem, 2vw, 1.95rem);
        line-height: 1.2;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-assessment-hero__text {
        margin: 0.55rem 0 0;
        color: #64748b;
        line-height: 1.75;
        max-width: 66ch;
    }

    .teacher-assessment-stats {
        display: grid;
        gap: 0.75rem;
        min-width: 240px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .teacher-assessment-stat {
        border-radius: 18px;
        padding: 0.95rem 1rem;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        text-align: center;
    }

    .teacher-assessment-stat strong {
        display: block;
        font-size: 1.35rem;
        line-height: 1;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-assessment-stat span {
        display: block;
        margin-top: 0.3rem;
        font-size: 0.84rem;
        color: #64748b;
        font-weight: 600;
    }

    .teacher-assessment-panel {
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .teacher-assessment-panel__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.15rem;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.06) 0%, rgba(255, 255, 255, 0.96) 100%);
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
    }

    .teacher-assessment-panel__head h3 {
        margin: 0;
        font-size: 1.08rem;
        line-height: 1.35;
        font-weight: 800;
        color: #0f172a;
    }

    .teacher-assessment-panel__head p {
        margin: 0.35rem 0 0;
        color: #64748b;
        line-height: 1.6;
    }

    .teacher-assessment-lesson-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 0.95rem;
        padding: 1rem;
    }

    .teacher-assessment-card {
        position: relative;
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96));
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .teacher-assessment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
        border-color: rgba(16, 185, 129, 0.24);
    }

    .teacher-assessment-card__accent {
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #14b8a6, #22c55e);
    }

    .teacher-assessment-card__body {
        padding: 1rem 1rem 0.9rem;
        display: grid;
        gap: 0.65rem;
    }

    .teacher-assessment-card__eyebrow {
        display: inline-flex;
        align-self: flex-start;
        padding: 0.28rem 0.65rem;
        border-radius: 999px;
        background: rgba(16, 185, 129, 0.09);
        color: #059669;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .teacher-assessment-card__title {
        margin: 0;
        font-size: 1rem;
        line-height: 1.3;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-assessment-card__meta {
        display: grid;
        gap: 0.3rem;
        color: #64748b;
        line-height: 1.45;
        font-size: 0.86rem;
        margin-bottom: 0.1rem;
    }

    .teacher-assessment-card__meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .teacher-assessment-card__actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.5rem;
        margin-top: 0.3rem;
        align-items: stretch;
    }

    .teacher-assessment-card__actions .btn {
        width: 100%;
        min-height: 42px;
        border-radius: 999px;
        font-weight: 700;
        padding: 0.55rem 0.65rem;
        box-shadow: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        white-space: nowrap;
    }

    .teacher-workflow-empty {
        display: grid;
        place-items: center;
        gap: 0.45rem;
        min-height: 180px;
        padding: 1.25rem;
        border-radius: 20px;
        border: 1px dashed rgba(148, 163, 184, 0.4);
        background: rgba(248, 250, 252, 0.8);
        color: #64748b;
        text-align: center;
        margin: 1rem;
    }

    .teacher-workflow-empty i {
        font-size: 1.9rem;
        color: #94a3b8;
    }

    .teacher-workflow-empty strong {
        color: #0f172a;
        font-weight: 800;
    }

    @media (max-width: 991.98px) {
        .teacher-assessment-hero__grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .teacher-assessment-hero,
        .teacher-assessment-panel__head,
        .teacher-assessment-lesson-grid {
            padding-left: 0.9rem;
            padding-right: 0.9rem;
        }

        .teacher-assessment-lesson-grid {
            grid-template-columns: 1fr;
        }

        .teacher-assessment-stats {
            grid-template-columns: 1fr 1fr;
            min-width: 0;
        }

        .teacher-assessment-card__actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() !== 'en';
    $teacherName = trim(($teacher->first_name ?? '') . ' ' . ($teacher->last_name ?? ''));
    $teacherName = $teacherName !== ''
        ? ($isRtl ? __('teacher_portal.common.teacher_prefix') . $teacherName : $teacherName)
        : __('teacher_portal.common.teacher_default');
    $lessonCount = collect($teacher_lessons)->count();
    $labels = [
        'banner' => __('teacher_portal.marks.banner'),
        'room' => __('teacher_portal.marks.room'),
        'class' => __('teacher_portal.marks.class'),
        'lessons' => __('teacher_portal.marks.lessons'),
        'lesson_title' => __('teacher_portal.marks.lesson_title'),
        'lesson_text' => __('teacher_portal.marks.lesson_text'),
        'empty_title' => __('teacher_portal.marks.empty_title'),
        'empty_text' => __('teacher_portal.marks.empty_text'),
        'exams' => __('teacher_portal.marks.exams'),
        'quizzes' => __('teacher_portal.marks.quizzes'),
        'tests' => __('teacher_portal.marks.tests'),
    ];
@endphp

<div class="main-panel teacher-dashboard-home">
    <div class="content-wrapper">
        <div class="teacher-assessment-shell">
            <section class="teacher-assessment-hero">
                <div class="teacher-assessment-hero__grid">
                    <div>
                        <span class="teacher-assessment-hero__eyebrow">{{ $labels['banner'] }}</span>
                        <h2 class="teacher-assessment-hero__title">{{ __('teacher_portal.marks.title') }}</h2>
                        <p class="teacher-assessment-hero__text">{{ __('teacher_portal.marks.subtitle') }}</p>
                    </div>

                    <div class="teacher-assessment-stats">
                        <div class="teacher-assessment-stat">
                            <strong>{{ $lessonCount }}</strong>
                            <span>{{ $labels['lessons'] }}</span>
                        </div>
                        <div class="teacher-assessment-stat">
                            <strong>{{ $room_name }}</strong>
                            <span>{{ $labels['room'] }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="teacher-assessment-panel">
                <div class="teacher-assessment-panel__head">
                    <div>
                        <h3>{{ $labels['lesson_title'] }}</h3>
                        <p>{{ $labels['lesson_text'] }}</p>
                    </div>
                </div>

                <div class="teacher-assessment-lesson-grid">
                    @forelse ($teacher_lessons as $lesson)
                        <article class="teacher-assessment-card">
                            <span class="teacher-assessment-card__accent" aria-hidden="true"></span>
                            <div class="teacher-assessment-card__body">
                                <span class="teacher-assessment-card__eyebrow">{{ $labels['lesson_title'] }}</span>
                                <h4 class="teacher-assessment-card__title">{{ $lesson->name }}</h4>
                                <div class="teacher-assessment-card__meta">
                                    <span><i class="mdi mdi-google-classroom"></i>{{ $labels['class'] }}: {{ $class->name ?? '' }}</span>
                                    <span><i class="mdi mdi-door-closed"></i>{{ $labels['room'] }}: {{ $room_name }}</span>
                                </div>

                                <div class="teacher-assessment-card__actions">
                                    <a href="{{ route('teacher_exam', [$room_id, $teacher->id, $lesson->id]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="mdi mdi-clipboard-text-outline"></i>
                                        {{ $labels['exams'] }}
                                    </a>
                                    <a href="{{ route('teacher_quize', [$room_id, $teacher->id, $lesson->id]) }}" class="btn btn-outline-success btn-sm">
                                        <i class="mdi mdi-book-open-variant"></i>
                                        {{ $labels['quizzes'] }}
                                    </a>
                                    <a href="{{ route('dashboard.StudentsRoomLesson_quize1', [$room_id, $teacher->id, $lesson->id]) }}" class="btn btn-light btn-sm">
                                        <i class="mdi mdi-badge-account-horizontal-outline"></i>
                                        {{ $labels['tests'] }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="teacher-workflow-empty">
                            <i class="mdi mdi-book-open-page-variant-outline"></i>
                            <strong>{{ $labels['empty_title'] }}</strong>
                            <span>{{ $labels['empty_text'] }}</span>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
