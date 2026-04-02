@extends('teachers2.layouts.app')

@section('teacher_page_title')
{{ app()->getLocale() === 'en' ? 'Dashboard' : 'لوحة التحكم' }}
@endsection

@section('teacher_page_subtitle')
{{ app()->getLocale() === 'en' ? 'A quick overview of your classes, rooms, and lessons.' : 'نظرة سريعة على الصفوف والشعب والدروس الخاصة بك.' }}
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() !== 'en';
    $teacherName = trim(($teacher->first_name ?? '') . ' ' . ($teacher->last_name ?? ''));
    $teacherName = $teacherName !== '' ? ($isRtl ? 'أ. ' . $teacherName : $teacherName) : ($isRtl ? 'الأستاذ' : 'Teacher');
    $teacherRoomIds = $teacher->rooms->pluck('id')->unique();
    $roomCount = $teacherRoomIds->count();
    $classCount = collect($classes)->count();
    $todayText = \Carbon\Carbon::now()->locale($isRtl ? 'ar' : 'en')->translatedFormat($isRtl ? 'l، j F Y' : 'l, j F Y');
    $labels = [
        'greeting' => $isRtl ? 'مرحباً' : 'Hello',
        'banner_intro' => $isRtl ? 'لوحة الأستاذ' : 'Teacher Dashboard',
        'classes' => $isRtl ? 'الصفوف' : 'Classes',
        'rooms' => $isRtl ? 'الشعب' : 'Rooms',
        'section_heading' => $isRtl ? 'الصفوف والشعب الدراسية' : 'Classes & Rooms',
        'section_text' => $isRtl ? 'اختر الصف من التبويبات ثم افتح الشعبة المطلوبة للوصول إلى الدروس والمحتوى المرتبط بها.' : 'Choose a class from the tabs, then open the room to access its lessons and related content.',
        'empty_title' => $isRtl ? 'لا توجد شعب مرتبطة بهذا الصف حالياً' : 'No rooms are linked to this class yet',
        'empty_text' => $isRtl ? 'عند إضافة شعبة مرتبطة بك ستظهر هنا تلقائياً.' : 'Once a room is assigned to you, it will appear here automatically.',
        'card_button' => $isRtl ? 'عرض الدروس' : 'View Lessons',
        'card_text' => $isRtl ? 'شعبة تعليمية مرتبطة بهذا الصف، ويمكنك من خلالها الوصول إلى الدروس والمحتوى المخصص.' : 'A teaching room connected to this class. Open it to access lessons and related content.',
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
        <div class="teacher-dashboard-home__canvas">
            <section class="teacher-dashboard-banner">
                <div class="teacher-dashboard-banner__copy">
                    <span class="teacher-dashboard-banner__eyebrow">{{ $labels['banner_intro'] }}</span>
                    <h2 class="teacher-dashboard-banner__title">{{ $labels['greeting'] }}، {{ $teacherName }} <span aria-hidden="true">👋</span></h2>
                    <p class="teacher-dashboard-banner__date">{{ $todayText }}</p>
                </div>

                <div class="teacher-dashboard-banner__stats">
                    <span class="teacher-dashboard-banner__chip">
                        <strong>{{ $classCount }}</strong>
                        <em>{{ $labels['classes'] }}</em>
                    </span>
                    <span class="teacher-dashboard-banner__chip">
                        <strong>{{ $roomCount }}</strong>
                        <em>{{ $labels['rooms'] }}</em>
                    </span>
                </div>
            </section>

            <section class="teacher-dashboard-panel">
                <div class="teacher-dashboard-panel__head">
                    <div>
                        <h3>{{ $labels['section_heading'] }}</h3>
                        <p>{{ $labels['section_text'] }}</p>
                    </div>
                </div>

                <ul class="nav nav-tabs teacher-dashboard-tabs" data-tabs="tabs">
                    @foreach ($classes as $index => $item)
                        <li class="nav-item">
                            <a class="nav-link {{ $index === 0 ? 'active' : '' }}" href="#tab-{{ $item->id }}" role="tab" data-toggle="tab">
                                {{ $item->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content teacher-dashboard-tabs__content">
                    @foreach ($classes as $index => $item)
                        @php
                            $visibleRooms = $item->room->filter(fn($room) => $teacherRoomIds->contains($room->id));
                        @endphp
                        <div role="tabpanel" class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $item->id }}">
                            @if($visibleRooms->isEmpty())
                                <div class="teacher-dashboard-empty">
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
                                        <a class="teacher-room-card" href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room->id, 'teacher_id' => $teacher->id]) }}" style="--room-accent-start: {{ $accent[0] }}; --room-accent-end: {{ $accent[1] }};">
                                            <span class="teacher-room-card__accent" aria-hidden="true"></span>
                                            <div class="teacher-room-card__body">
                                                <span class="teacher-room-card__class">{{ $item->name }}</span>
                                                <h4 class="teacher-room-card__title">{{ $room->name }}</h4>
                                                <p class="teacher-room-card__meta">{{ $labels['card_text'] }}</p>
                                                <span class="teacher-room-card__action">
                                                    {{ $labels['card_button'] }}
                                                    <i class="mdi {{ $isRtl ? 'mdi-arrow-left' : 'mdi-arrow-right' }}"></i>
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
