@extends('teachers2.layouts.app')

@section('css')
<style>
    body.teacher-portal-body .teacher-book-page {
        min-height: 100%;
    }

    body.teacher-portal-body .teacher-book-banner {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(280px, 380px);
        gap: 1.25rem;
        align-items: stretch;
        padding: 1.5rem 1.75rem;
        background: linear-gradient(145deg, #ffffff 0%, #f3f7ff 100%);
        border: 1px solid rgba(67, 130, 224, 0.12);
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(17, 24, 39, 0.06);
    }

    body.teacher-portal-body .teacher-book-banner__copy {
        display: grid;
        gap: 0.55rem;
        min-width: 0;
    }

    body.teacher-portal-body .teacher-book-banner__eyebrow {
        display: inline-flex;
        width: fit-content;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        background: rgba(67, 130, 224, 0.12);
        color: #2257b9;
        font-weight: 700;
        font-size: 0.88rem;
    }

    body.teacher-portal-body .teacher-book-banner__title {
        margin: 0;
        color: #152C4F;
        font-size: 1.85rem;
        line-height: 1.3;
        font-weight: 800;
    }

    body.teacher-portal-body .teacher-book-banner__text {
        margin: 0;
        color: #64748b;
        line-height: 1.9;
        font-size: 0.98rem;
    }

    body.teacher-portal-body .teacher-book-banner__meta {
        display: grid;
        gap: 0.85rem;
        min-width: 0;
    }

    body.teacher-portal-body .teacher-book-meta-card {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        padding: 1rem 1.1rem;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(21, 44, 79, 0.08);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        color: #152C4F;
        min-height: 66px;
    }

    body.teacher-portal-body .teacher-book-meta-card i {
        font-size: 1.2rem;
        color: #4382E0;
    }

    body.teacher-portal-body .teacher-book-meta-card strong {
        display: block;
        font-size: 0.92rem;
        color: #64748b;
        font-weight: 600;
    }

    body.teacher-portal-body .teacher-book-meta-card span {
        display: block;
        font-weight: 800;
        color: #111827;
    }

    body.teacher-portal-body .teacher-book-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.9rem;
        margin-top: 1.4rem;
        margin-bottom: 1.2rem;
    }

    body.teacher-portal-body .teacher-book-toolbar__note {
        margin: 0;
        color: #64748b;
        line-height: 1.8;
    }

    body.teacher-portal-body .teacher-book-action {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        border: 0;
        border-radius: 14px;
        padding: 0.9rem 1.15rem;
        min-height: 48px;
        background: linear-gradient(135deg, #4382E0 0%, #2b5fb7 100%);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 12px 26px rgba(67, 130, 224, 0.22);
        text-decoration: none;
    }

    body.teacher-portal-body .teacher-book-action:hover {
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    body.teacher-portal-body .teacher-lecture-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.25rem;
    }

    body.teacher-portal-body .teacher-lecture-card {
        display: grid;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 22px;
        background: #fff;
        border: 1px solid rgba(21, 44, 79, 0.08);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.06);
        min-height: 100%;
    }

    body.teacher-portal-body .teacher-lecture-card__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }

    body.teacher-portal-body .teacher-lecture-card__date {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        background: rgba(67, 130, 224, 0.12);
        color: #2257b9;
        font-size: 0.85rem;
        font-weight: 700;
        white-space: nowrap;
    }

    body.teacher-portal-body .teacher-lecture-card__title {
        margin: 0;
        color: #152C4F;
        font-size: 1.1rem;
        line-height: 1.5;
        font-weight: 800;
    }

    body.teacher-portal-body .teacher-lecture-card__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    body.teacher-portal-body .teacher-lecture-card__actions .button,
    body.teacher-portal-body .teacher-lecture-card__actions .button a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        border-radius: 14px;
        padding: 0.7rem 1rem;
        font-weight: 700;
        text-decoration: none;
    }

    body.teacher-portal-body .teacher-lecture-card__icon-row {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: #94a3b8;
    }

    body.teacher-portal-body .teacher-lecture-card__icon-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid rgba(21, 44, 79, 0.08);
        background: #fff;
        color: #152C4F;
    }

    body.teacher-portal-body .teacher-lecture-card__icon-btn:hover {
        text-decoration: none;
        background: #f8fbff;
    }

    body.teacher-portal-body .teacher-book-empty {
        display: grid;
        gap: 0.6rem;
        justify-items: center;
        text-align: center;
        padding: 2rem 1.25rem;
        border-radius: 22px;
        border: 1px dashed rgba(67, 130, 224, 0.26);
        background: rgba(255, 255, 255, 0.95);
        color: #475569;
    }

    body.teacher-portal-body .teacher-book-empty i {
        font-size: 2rem;
        color: #4382E0;
    }

    body.teacher-portal-body .teacher-book-empty strong {
        font-size: 1.05rem;
        color: #152C4F;
    }

    body.teacher-portal-body .teacher-book-empty span {
        max-width: 42rem;
        line-height: 1.9;
    }

    body.teacher-portal-body .teacher-modal .modal-dialog {
        max-width: 760px;
    }

    body.teacher-portal-body .teacher-modal .modal-content {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.22);
    }

    body.teacher-portal-body .teacher-modal .modal-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
    }

    body.teacher-portal-body .teacher-modal .modal-body {
        padding: 1.25rem;
    }

    body.teacher-portal-body .teacher-modal .modal-footer {
        padding: 1rem 1.25rem 1.25rem;
        border-top: 1px solid rgba(15, 23, 42, 0.08);
        gap: 0.75rem;
    }

    body.teacher-portal-body .teacher-modal .form-control {
        min-height: 48px;
        border-radius: 14px;
        border-color: rgba(71, 85, 105, 0.2);
        box-shadow: none;
    }

    body.teacher-portal-body .teacher-modal .form-group {
        margin-bottom: 1rem;
    }

    body.teacher-portal-body .teacher-modal .form-group label {
        margin-bottom: 0.45rem;
        font-weight: 700;
        color: #152C4F;
    }

    @media (max-width: 1199.98px) {
        body.teacher-portal-body .teacher-book-banner {
            grid-template-columns: 1fr;
        }

        body.teacher-portal-body .teacher-lecture-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        body.teacher-portal-body .teacher-book-banner {
            padding: 1.25rem;
        }

        body.teacher-portal-body .teacher-book-banner__title {
            font-size: 1.5rem;
        }

        body.teacher-portal-body .teacher-book-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        body.teacher-portal-body .teacher-lecture-grid {
            grid-template-columns: 1fr;
        }

        body.teacher-portal-body .teacher-modal .modal-dialog {
            margin: 0.75rem;
        }

        body.teacher-portal-body .teacher-modal .modal-body,
        body.teacher-portal-body .teacher-modal .modal-header,
        body.teacher-portal-body .teacher-modal .modal-footer {
            padding-inline: 1rem;
        }
    }
</style>
@endsection

@section('content')
@php
    $isRtl = app()->getLocale() !== 'en';
    $labels = [
        'dashboard' => json_decode('"\\u0627\\u0644\\u0635\\u0641\\u062d\\u0629 \\u0627\\u0644\\u0631\\u0626\\u064a\\u0633\\u064a\\u0629"'),
        'lessons_content' => json_decode('"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u062f\\u0631\\u0648\\u0633 \\u0648\\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649"'),
        'lesson' => json_decode('"\\u0627\\u0644\\u062f\\u0631\\u0633"'),
        'room' => json_decode('"\\u0627\\u0644\\u0634\\u0639\\u0628\\u0629"'),
        'today' => json_decode('"\\u0627\\u0644\\u064a\\u0648\\u0645"'),
        'lectures' => json_decode('"\\u0627\\u0644\\u062f\\u0631\\u0648\\u0633"'),
        'toolbar_note' => json_decode('"\\u0627\\u0633\\u062a\\u062e\\u062f\\u0645 \\u0625\\u0636\\u0627\\u0641\\u0629 \\u062f\\u0631\\u0633 \\u0644\\u0625\\u0646\\u0634\\u0627\\u0621 \\u062f\\u0631\\u0633 \\u062c\\u062f\\u064a\\u062f\\u060c \\u062b\\u0645 \\u0623\\u0636\\u0641 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0644\\u0631\\u0628\\u0637 \\u0627\\u0644\\u0641\\u0644\\u0627\\u0645 \\u0623\\u0648 \\u0627\\u0644\\u0631\\u0648\\u0627\\u0628\\u0637."'),
        'add_lecture' => json_decode('"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u062f\\u0631\\u0633"'),
        'view_content' => json_decode('"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0629 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649"'),
        'add_content' => json_decode('"\\u0625\\u0636\\u0627\\u0641\\u0629 \\u0645\\u062d\\u062a\\u0648\\u0649"'),
        'no_lectures_title' => json_decode('"\\u0644\\u0627 \\u062a\\u0648\\u062c\\u062f \\u062f\\u0631\\u0648\\u0633 \\u0645\\u0631\\u062a\\u0628\\u0637\\u0629 \\u0628\\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629 \\u062d\\u0627\\u0644\\u064a\\u0627\\u064b"'),
        'no_lectures_text' => json_decode('"\\u0627\\u0628\\u062f\\u0623 \\u0628\\u0625\\u0636\\u0627\\u0641\\u0629 \\u062f\\u0631\\u0633 \\u062c\\u062f\\u064a\\u062f \\u0645\\u0646 \\u0627\\u0644\\u0623\\u0639\\u0644\\u0649\\u060c \\u062b\\u0645 \\u0627\\u0631\\u0628\\u0637 \\u0628\\u0647 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0648\\u0627\\u0644\\u0641\\u0644\\u0627\\u0645 \\u0627\\u0644\\u0645\\u0631\\u062a\\u0628\\u0637\\u0629."'),
        'lecture_name' => json_decode('"\\u0627\\u0633\\u0645 \\u0627\\u0644\\u062f\\u0631\\u0633"'),
        'lecture_date' => json_decode('"\\u062a\\u0627\\u0631\\u064a\\u062e \\u0638\\u0647\\u0648\\u0631 \\u0627\\u0644\\u062f\\u0631\\u0633"'),
        'cancel' => json_decode('"\\u0625\\u0644\\u063a\\u0627\\u0621"'),
        'save' => json_decode('"\\u062d\\u0641\\u0638"'),
        'edit_lecture' => json_decode('"\\u062a\\u0639\\u062f\\u064a\\u0644 \\u0627\\u0644\\u062f\\u0631\\u0633"'),
        'delete_lecture' => json_decode('"\\u062d\\u0630\\u0641 \\u062f\\u0631\\u0633"'),
        'confirm' => json_decode('"\\u062a\\u0623\\u0643\\u064a\\u062f"'),
        'delete_message' => json_decode('"\\u0647\\u0644 \\u0623\\u0646\\u062a \\u0645\\u062a\\u0623\\u0643\\u062f \\u0645\\u0646 \\u0639\\u0645\\u0644\\u064a\\u0629 \\u0627\\u0644\\u062d\\u0630\\u0641\\u061f"'),
    ];
    $lessonName = $lesson->name ?? ($isRtl ? $labels['lesson'] : 'Lesson');
    $roomName = $room->name ?? ($isRtl ? $labels['room'] : 'Room');
    $lectureCount = isset($lectures) ? $lectures->count() : 0;
    $todayText = \Carbon\Carbon::now()->locale($isRtl ? 'ar' : 'en')->translatedFormat($isRtl ? 'l? j F Y' : 'l, j F Y');
@endphp

<div class="main-panel teacher-book-page" style="background: #f8f9fb;">
    <div class="content-wrapper pb-0">
        <div class="teacher-dashboard-inner">
            <ul class="breadcrumbs teacher-breadcrumbs" style="padding-bottom: 7px;padding-top: 11px;">
                <li class="li"><a href="{{ route('dashboard.teacher') }}">{{ $labels['dashboard'] }}</a></li>
                <li class="li"><a href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room->id, 'teacher_id' => $teacher->id]) }}">{{ $roomName }}</a></li>
                <li class="li"><a href="#">{{ $lessonName }}</a></li>
            </ul>

            <section class="teacher-book-banner animated fadeInDown">
                <div class="teacher-book-banner__copy">
                    <span class="teacher-book-banner__eyebrow">{{ $labels['lessons_content'] }}</span>
                    <h2 class="teacher-book-banner__title">{{ $lessonName }}</h2>
                    <p class="teacher-book-banner__text">{{ $isRtl ? json_decode('"\\u0645\\u0646 \\u0647\\u0646\\u0627 \\u064a\\u0645\\u0643\\u0646\\u0643 \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u062f\\u0631\\u0648\\u0633 \\u0627\\u0644\\u0645\\u0631\\u062a\\u0628\\u0637\\u0629 \\u0628\\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u0627\\u062f\\u0629\\u060c \\u0625\\u0636\\u0627\\u0641\\u0629 \\u0645\\u062d\\u062a\\u0648\\u0649 \\u062c\\u062f\\u064a\\u062f\\u060c \\u0648\\u0645\\u0631\\u0627\\u062c\\u0639\\u0629 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0627\\u0644\\u0645\\u0646\\u0634\\u0648\\u0631 \\u0636\\u0645\\u0646 \\u0627\\u0644\\u0634\\u0639\\u0628\\u0629."') : 'Manage the lectures linked to this subject, add new content, and review the published materials for this room.' }}</p>
                </div>
                <div class="teacher-book-banner__meta">
                    <div class="teacher-book-meta-card">
                        <i class="mdi mdi-home-city-outline" aria-hidden="true"></i>
                        <div>
                            <strong>{{ $labels['room'] }}</strong>
                            <span>{{ $roomName }}</span>
                        </div>
                    </div>
                    <div class="teacher-book-meta-card">
                        <i class="mdi mdi-calendar-month-outline" aria-hidden="true"></i>
                        <div>
                            <strong>{{ $labels['today'] }}</strong>
                            <span>{{ $todayText }}</span>
                        </div>
                    </div>
                    <div class="teacher-book-meta-card">
                        <i class="mdi mdi-book-open-page-variant" aria-hidden="true"></i>
                        <div>
                            <strong>{{ $labels['lectures'] }}</strong>
                            <span>{{ $lectureCount }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="teacher-book-toolbar">
                <div>
                    <p class="teacher-book-toolbar__note">{{ $labels['toolbar_note'] }}</p>
                </div>
                <div>
                    <a href="#lectureCreateModal" class="teacher-book-action" data-toggle="modal">
                        <i class="mdi mdi-plus"></i>
                        <span>{{ $labels['add_lecture'] }}</span>
                    </a>
                </div>
            </div>

            <div class="teacher-lecture-grid newarticls">
                @forelse ($lectures as $item)
                    <article class="teacher-lecture-card div_lesson ll_{{ $item->id }}">
                        <div class="teacher-lecture-card__head">
                            <div>
                                <div class="teacher-lecture-card__date">
                                    <i class="mdi mdi-calendar" aria-hidden="true"></i>
                                    <span>{{ $item->lecture_time }}</span>
                                </div>
                                <h3 class="teacher-lecture-card__title">{{ $item->name }}</h3>
                            </div>
                            <div class="teacher-lecture-card__icon-row">
                                <button type="button" class="teacher-lecture-card__icon-btn lecture-delete-btn" data-toggle="modal" data-target="#lectureDeleteModal" data-lec_id="{{ $item->id }}" aria-label="{{ $labels['delete_lecture'] }}">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="teacher-lecture-card__icon-btn lecture-edit-btn" data-toggle="modal" data-target="#lectureEditModal" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-time="{{ $item->lecture_time }}" aria-label="{{ $labels['edit_lecture'] }}">
                                    <i class="mdi mdi-pencil" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <div class="teacher-lecture-card__actions">
                            <button class="button" type="button">
                                <a href="{{ route('dashboard.student.lessons.book_details', [$lesson->id, $teacher->id, $room->id, $item->id]) }}" style="color: #fff;">
                                    {{ $labels['view_content'] }}
                                </a>
                            </button>
                            <button class="button" type="button">
                                <a href="{{ route('dashboard.teacher_rooms2', [$class->id, $teacher->id, $room->id, $item->id]) }}" style="color: #fff;">
                                    {{ $labels['add_content'] }}
                                </a>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="teacher-book-empty col-12">
                        <i class="mdi mdi-bookshelf"></i>
                        <strong>{{ $labels['no_lectures_title'] }}</strong>
                        <span>{{ $labels['no_lectures_text'] }}</span>
                        <a href="#lectureCreateModal" class="teacher-book-action" data-toggle="modal">
                            <i class="mdi mdi-plus"></i>
                            <span>{{ $labels['add_lecture'] }}</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade teacher-modal" id="lectureCreateModal" tabindex="-1" role="dialog" aria-labelledby="lectureCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureCreateModalLabel">{{ $labels['add_lecture'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('dashboard.lessons.lecture.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lecture_name_create">{{ $labels['lecture_name'] }}</label>
                        <input required type="text" name="name" id="lecture_name_create" class="form-control" placeholder="{{ $labels['lecture_name'] }}">
                    </div>
                    <div class="form-group">
                        <label for="lecture_time_create">{{ $labels['lecture_date'] }}</label>
                        <input required name="lecture_time" id="lecture_time_create" class="form-control" type="date">
                    </div>
                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" data-dismiss="modal">{{ $labels['cancel'] }}</button>
                    <button type="submit" class="button">{{ $labels['save'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade teacher-modal" id="lectureEditModal" tabindex="-1" role="dialog" aria-labelledby="lectureEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureEditModalLabel">{{ $labels['edit_lecture'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('dashboard.lessons.lecture.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="lecture_edit_id">
                    <div class="form-group">
                        <label for="lecture_name_edit">{{ $labels['lecture_name'] }}</label>
                        <input required type="text" name="name" id="lecture_name_edit" class="form-control" placeholder="{{ $labels['lecture_name'] }}">
                    </div>
                    <div class="form-group">
                        <label for="lecture_time_edit">{{ $labels['lecture_date'] }}</label>
                        <input required name="lecture_time" id="lecture_time_edit" class="form-control" type="date">
                    </div>
                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" data-dismiss="modal">{{ $labels['cancel'] }}</button>
                    <button type="submit" class="button">{{ $labels['save'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade teacher-modal" id="lectureDeleteModal" tabindex="-1" role="dialog" aria-labelledby="lectureDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureDeleteModalLabel">{{ $labels['delete_lecture'] }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('dashboard.lec.delete') }}" method="post">
                @csrf
                <div class="modal-body" style="text-align: center;">
                    {{ $labels['delete_message'] }}
                    <input type="hidden" name="question_id" id="lecture_delete_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="button" data-dismiss="modal">{{ $labels['cancel'] }}</button>
                    <button type="submit" class="button">{{ $labels['confirm'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).on('click', '.lecture-edit-btn', function () {
        var lecId = $(this).data('id');
        var lecName = $(this).data('name');
        var lecTime = $(this).data('time');
        $('#lecture_edit_id').val(lecId);
        $('#lecture_name_edit').val(lecName);
        $('#lecture_time_edit').val(lecTime);
    });

    $(document).on('click', '.lecture-delete-btn', function () {
        $('#lecture_delete_id').val($(this).data('lec_id'));
    });
</script>
@endsection
