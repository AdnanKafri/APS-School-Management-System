@extends('teachers2.layouts.app')

@section('teacher_page_title')
{{ __('teacher_portal.exams_quizzes.title') }}
@endsection

@section('teacher_page_subtitle')
{{ __('teacher_portal.exams_quizzes.subtitle') }}
@endsection

@section('css')
<style>
    .teacher-workflow-shell {
        display: grid;
        gap: 1.25rem;
    }

    .teacher-workflow-hero {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 22px;
        padding: 0.95rem 1rem;
        background:
            radial-gradient(circle at top left, rgba(99, 102, 241, 0.18), transparent 32%),
            linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
    }

    .teacher-workflow-hero__grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 0.75rem;
        align-items: center;
    }

    .teacher-workflow-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.24rem 0.6rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.08);
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.76rem;
        margin-bottom: 0.45rem;
    }

    .teacher-workflow-hero__title {
        margin: 0;
        font-size: clamp(1.2rem, 1.7vw, 1.6rem);
        line-height: 1.2;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-workflow-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.5rem;
        min-width: 190px;
    }

    .teacher-workflow-stat {
        border-radius: 14px;
        padding: 0.7rem 0.75rem;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        text-align: center;
    }

    .teacher-workflow-stat strong {
        display: block;
        font-size: 1.05rem;
        line-height: 1;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-workflow-stat span {
        display: block;
        margin-top: 0.18rem;
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 600;
    }

    .teacher-class-stack {
        display: grid;
        gap: 0.8rem;
    }

    .teacher-workflow-section-head {
        display: grid;
        gap: 0.2rem;
        padding: 0 0.15rem;
    }

    .teacher-workflow-section-head__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #6366f1;
        font-weight: 800;
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .teacher-workflow-section-head h3 {
        margin: 0;
        font-size: 1rem;
        line-height: 1.25;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-class-card {
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .teacher-class-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.8rem 0.9rem;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.06) 0%, rgba(255, 255, 255, 0.96) 100%);
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
    }

    .teacher-class-card__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6366f1;
        margin-bottom: 0.2rem;
    }

    .teacher-class-card__header h3 {
        margin: 0;
        font-size: 1rem;
        line-height: 1.25;
        font-weight: 800;
        color: #0f172a;
    }

    .teacher-class-card__count {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 0.55rem;
        border-radius: 14px;
        background: rgba(79, 70, 229, 0.09);
        color: #4338ca;
        font-weight: 800;
        font-size: 0.9rem;
    }

    .teacher-room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 0.65rem;
        padding: 0.8rem 0.9rem 0.9rem;
    }

    .teacher-room-card {
        position: relative;
        display: block;
        min-height: 100%;
        padding: 0.9rem;
        border-radius: 16px;
        border: 1px solid rgba(148, 163, 184, 0.15);
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96));
        text-decoration: none;
        color: inherit;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .teacher-room-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        border-color: rgba(99, 102, 241, 0.24);
        text-decoration: none;
    }

    .teacher-room-card__accent {
        position: absolute;
        inset-inline-start: 0;
        top: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--room-accent-start, #6366f1), var(--room-accent-end, #22c55e));
    }

    .teacher-room-card__body {
        display: grid;
        gap: 0.4rem;
        padding-top: 0.35rem;
    }

    .teacher-room-card__class {
        display: inline-flex;
        align-self: flex-start;
        padding: 0.22rem 0.55rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.08);
        color: #4338ca;
        font-size: 0.74rem;
        font-weight: 700;
    }

    .teacher-room-card__title {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.3;
        color: #0f172a;
        font-weight: 800;
    }

    .teacher-room-card__action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #4f46e5;
        font-weight: 800;
        font-size: 0.82rem;
        margin-top: 0.1rem;
    }

    .teacher-workflow-empty {
        display: grid;
        place-items: center;
        gap: 0.45rem;
        min-height: 140px;
        padding: 1rem;
        border-radius: 16px;
        border: 1px dashed rgba(148, 163, 184, 0.4);
        background: rgba(248, 250, 252, 0.8);
        color: #64748b;
        text-align: center;
    }

    .teacher-workflow-empty i {
        font-size: 1.55rem;
        color: #94a3b8;
    }

    .teacher-workflow-empty strong {
        color: #0f172a;
        font-weight: 800;
    }

    @media (max-width: 991.98px) {
        .teacher-workflow-hero__grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575.98px) {
        .teacher-workflow-hero,
        .teacher-class-card__header,
        .teacher-room-grid {
            padding-left: 0.9rem;
            padding-right: 0.9rem;
        }

        .teacher-room-grid {
            grid-template-columns: 1fr;
        }

        .teacher-workflow-stats {
            grid-template-columns: 1fr 1fr;
            min-width: 0;
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
    $teacherRoomIds = $teacher->rooms->pluck('id')->unique();
    $classCount = collect($classes)->count();
    $roomCount = $teacherRoomIds->count();
    $labels = [
        'banner' => __('teacher_portal.exams_quizzes.banner'),
        'classes' => __('teacher_portal.exams_quizzes.classes'),
        'rooms' => __('teacher_portal.exams_quizzes.rooms'),
        'section_title' => __('teacher_portal.exams_quizzes.section_title'),
        'section_text' => __('teacher_portal.exams_quizzes.section_text'),
        'class' => __('teacher_portal.exams_quizzes.class'),
        'open_room' => __('teacher_portal.exams_quizzes.open_room'),
        'empty_title' => __('teacher_portal.exams_quizzes.empty_title'),
        'empty_text' => __('teacher_portal.exams_quizzes.empty_text'),
        'card_text' => __('teacher_portal.exams_quizzes.card_text'),
    ];
    $roomAccents = [
        ['#4f46e5', '#7c3aed'],
        ['#2563eb', '#06b6d4'],
        ['#7c3aed', '#ec4899'],
        ['#0f766e', '#14b8a6'],
        ['#9333ea', '#6366f1'],
        ['#1d4ed8', '#8b5cf6'],
    ];
@endphp

<div class="main-panel teacher-dashboard-home">
    <div class="content-wrapper">
        <div class="teacher-workflow-shell">
            <section class="teacher-workflow-hero">
                <div class="teacher-workflow-hero__grid">
                    <div>
                        <span class="teacher-workflow-hero__eyebrow">{{ $labels['banner'] }}</span>
                        <h2 class="teacher-workflow-hero__title">{{ __('teacher_portal.exams_quizzes.title') }}</h2>
                    </div>

                    <div class="teacher-workflow-stats">
                        <div class="teacher-workflow-stat">
                            <strong>{{ $classCount }}</strong>
                            <span>{{ $labels['classes'] }}</span>
                        </div>
                        <div class="teacher-workflow-stat">
                            <strong>{{ $roomCount }}</strong>
                            <span>{{ $labels['rooms'] }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="teacher-class-stack">
                <div class="teacher-workflow-section-head">
                    <span class="teacher-workflow-section-head__eyebrow">{{ $labels['section_title'] }}</span>
                    <h3>{{ $teacherName }}</h3>
                    <p>{{ $labels['section_text'] }}</p>
                </div>

                @forelse ($classes as $item)
                    @php
                        $visibleRooms = $item->room->filter(fn ($room) => $teacherRoomIds->contains($room->id));
                    @endphp
                    <section class="teacher-class-card">
                        <header class="teacher-class-card__header">
                            <div>
                                <span class="teacher-class-card__eyebrow">{{ $labels['class'] }}</span>
                                <h3>{{ $item->name }}</h3>
                            </div>
                            <span class="teacher-class-card__count">{{ $visibleRooms->count() }}</span>
                        </header>

                        @if($visibleRooms->isEmpty())
                            <div class="teacher-workflow-empty" style="margin: 1rem;">
                                <i class="mdi mdi-folder-open-outline"></i>
                                <strong>{{ $labels['empty_title'] }}</strong>
                                <span>{{ $labels['empty_text'] }}</span>
                            </div>
                        @else
                            <div class="teacher-room-grid">
                                @foreach ($visibleRooms as $room)
                                    @php
                                        $accent = $roomAccents[$loop->index % count($roomAccents)];
                                    @endphp
                                    <a class="teacher-room-card" href="{{ route('teacher.marks.subjects', ['room_id' => $room->id, 'teacher_id' => $teacher->id]) }}" style="--room-accent-start: {{ $accent[0] }}; --room-accent-end: {{ $accent[1] }};">
                                        <span class="teacher-room-card__accent" aria-hidden="true"></span>
                                        <div class="teacher-room-card__body">
                                            <span class="teacher-room-card__class">{{ $item->name }}</span>
                                            <h4 class="teacher-room-card__title">{{ $room->name }}</h4>
                                            <span class="teacher-room-card__action">
                                                {{ $labels['open_room'] }}
                                                <i class="mdi {{ $isRtl ? 'mdi-arrow-left' : 'mdi-arrow-right' }}"></i>
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @empty
                    <section class="teacher-workflow-empty">
                        <i class="mdi mdi-folder-open-outline"></i>
                        <strong>{{ $labels['empty_title'] }}</strong>
                        <span>{{ $labels['empty_text'] }}</span>
                    </section>
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
