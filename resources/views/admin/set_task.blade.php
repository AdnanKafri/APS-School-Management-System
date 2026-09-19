@extends('admin.layouts.v2')

@section('page_title', 'تحديد مهام المدرس')
@section('page_subtitle', 'تكليف المواد والشعب للعام الدراسي الحالي')
@section('body_class', 'teacher-assignment-v2')

@section('style')
<style>
    .teacher-assignment-v2 .assignment-shell { display: grid; gap: 1.25rem; direction: rtl; }
    .teacher-assignment-v2 .assignment-card { border: 1px solid var(--v2-border); border-radius: 18px; box-shadow: 0 14px 32px rgba(36,30,62,.07); }
    .teacher-assignment-v2 .assignment-card .card-body { padding: 1.5rem; }
    .teacher-assignment-v2 .assignment-context { display: flex; flex-wrap: wrap; gap: .75rem; align-items: center; }
    .teacher-assignment-v2 .assignment-context__name { font-size: 1.25rem; font-weight: 800; color: var(--v2-text); }
    .teacher-assignment-v2 .assignment-badge { display: inline-flex; align-items: center; gap: .35rem; padding: .45rem .75rem; border-radius: 999px; background: rgba(91,75,138,.1); color: var(--v2-primary); font-weight: 700; }
    .teacher-assignment-v2 .assignment-notice { margin: 0; border-radius: 12px; line-height: 1.8; }
    .teacher-assignment-v2 .assignment-row { position: relative; display: grid; grid-template-columns: minmax(0,1fr) minmax(0,1fr) minmax(0,1fr) auto; gap: 1rem; align-items: end; padding: 1rem; border: 1px solid var(--v2-border); border-radius: 14px; background: #fcfbff; }
    .teacher-assignment-v2 .assignment-row__field { min-width: 0; }
    .teacher-assignment-v2 .assignment-row label { display: block; margin-bottom: .45rem; color: var(--v2-text); font-weight: 700; }
    .teacher-assignment-v2 .assignment-row .form-control { min-height: 44px; border-color: #dcd9e8; border-radius: 10px; }
    .teacher-assignment-v2 .assignment-row .form-control:focus { border-color: var(--v2-primary); box-shadow: 0 0 0 .18rem rgba(91,75,138,.12); }
    .teacher-assignment-v2 .assignment-row__hint { margin: .45rem 0 0; color: var(--v2-muted); font-size: .82rem; line-height: 1.6; }
    .teacher-assignment-v2 .assignment-row__remove { min-width: 44px; min-height: 44px; border-radius: 10px; }
    .teacher-assignment-v2 .assignment-actions { display: flex; flex-wrap: wrap; gap: .75rem; align-items: center; justify-content: space-between; margin-top: 1.25rem; }
    .teacher-assignment-v2 .assignment-existing { margin: 0; padding-right: 1.15rem; color: var(--v2-muted); }
    .teacher-assignment-v2 .assignment-existing li { margin-bottom: .45rem; }
    .teacher-assignment-v2 .assignment-feedback { margin-top: .55rem; color: #b42318; font-size: .85rem; font-weight: 700; }
    @media (max-width: 991px) { .teacher-assignment-v2 .assignment-row { grid-template-columns: 1fr; } .teacher-assignment-v2 .assignment-row__remove { width: 100%; } }
</style>
@endsection

@section('breadcrumbs')
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">لوحة التحكم</a>
    <span class="breadcrumbs__sep" aria-hidden="true">/</span>
    <a href="{{ route('teachers') }}" class="breadcrumbs__item">المدرسون</a>
    <span class="breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__item is-active">تحديد مهام المدرس</span>
</nav>
@endsection

@section('content')
<div class="assignment-shell">
    <section class="card v2-card assignment-card">
        <div class="card-body">
            <div class="assignment-context">
                <span class="assignment-context__name">{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
                <span class="assignment-badge"><i class="fas fa-calendar-alt"></i> العام الدراسي الحالي: {{ $year->name }}</span>
            </div>
        </div>
    </section>

    <section class="card v2-card assignment-card">
        <div class="card-body">
            <p class="alert alert-warning assignment-notice">
                <strong>تنبيه:</strong> الحفظ يعتمد القائمة الكاملة أدناه لتكليفات هذا المدرس في العام الدراسي الحالي فقط. أي تكليف حالي لا يظهر في هذه القائمة سيتم إزالته، أما تكليفات الأعوام السابقة فلن تتغير.
            </p>

            @php($formErrors = $errors ?? session('errors'))
            @if($formErrors && $formErrors->any())
                <div class="alert alert-danger mt-3 mb-0">
                    <ul class="mb-0 pr-3">
                        @foreach($formErrors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="teacher-assignment-form" method="POST" action="{{ route('teacher.store_set_task') }}" class="mt-3" novalidate>
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

                <div id="assignment-rows"></div>

                <div class="assignment-actions">
                    <button type="button" id="add-assignment-row" class="btn btn-outline-primary"><i class="fas fa-plus ml-1"></i> إضافة مادة أو شعبة</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save ml-1"></i> حفظ التكليفات</button>
                </div>
            </form>
        </div>
    </section>

    @if($currentAssignments->isNotEmpty())
        <section class="card v2-card assignment-card">
            <div class="card-body">
                <h3 class="h5 font-weight-bold mb-3">التكليفات الحالية</h3>
                <ul class="assignment-existing">
                    @foreach($currentAssignments as $assignment)
                        <li>{{ optional($assignment->lesson)->name ?? 'مادة غير متاحة' }} — {{ $assignment->room_name ?? 'شعبة غير متاحة' }}</li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</div>

<template id="assignment-row-template">
    <div class="assignment-row">
        <div class="assignment-row__field">
            <label>الصف</label>
            <select name="class_id[]" class="form-control js-assignment-class" required>
                <option value="">اختر الصف الدراسي</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="assignment-row__field js-lesson-field">
            <label>المادة الدراسية</label>
            <select class="form-control" disabled><option>اختر الصف أولاً</option></select>
        </div>
        <div class="assignment-row__field js-room-field">
            <label>الشعبة</label>
            <select class="form-control" disabled><option>اختر الصف أولاً</option></select>
        </div>
        <button type="button" class="btn btn-outline-danger assignment-row__remove js-remove-assignment" title="إزالة"><i class="fas fa-times"></i><span class="sr-only">إزالة</span></button>
    </div>
</template>
@endsection

@section('js')
<script>
(function ($) {
    var lessonsUrlTemplate = @json(route('teacher_lessons', ['class_id' => '__class_id__']));
    var roomsUrlTemplate = @json(route('rooms', ['class_id' => '__class_id__']));
    var rows = $('#assignment-rows');
    var template = document.getElementById('assignment-row-template');

    function option(value, label) {
        return $('<option>').val(value).text(label);
    }

    function addRow() {
        var fragment = document.importNode(template.content, true);
        rows.append(fragment);
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        rows.find('.js-remove-assignment').prop('disabled', rows.find('.assignment-row').length === 1);
    }

    function setFieldMessage(field, message) {
        field.find('.assignment-feedback').remove();
        field.append($('<div class="assignment-feedback">').text(message));
    }

    rows.on('change', '.js-assignment-class', function () {
        var classSelect = $(this);
        var row = classSelect.closest('.assignment-row');
        var lessonField = row.find('.js-lesson-field');
        var roomField = row.find('.js-room-field');
        var classId = classSelect.val();

        lessonField.html('<label>المادة الدراسية</label><select class="form-control" disabled><option>جارٍ تحميل المواد...</option></select>');
        roomField.html('<label>الشعبة</label><select class="form-control" disabled><option>جارٍ تحميل الشعب...</option></select>');
        if (!classId) {
            lessonField.html('<label>المادة الدراسية</label><select class="form-control" disabled><option>اختر الصف أولاً</option></select>');
            roomField.html('<label>الشعبة</label><select class="form-control" disabled><option>اختر الصف أولاً</option></select>');
            return;
        }

        $.when(
            $.getJSON(lessonsUrlTemplate.replace('__class_id__', encodeURIComponent(classId))),
            $.getJSON(roomsUrlTemplate.replace('__class_id__', encodeURIComponent(classId)))
        ).done(function (lessonsResponse, roomsResponse) {
            var lessons = lessonsResponse[0] || [];
            var roomsData = roomsResponse[0] || [];
            var lessonSelect = $('<select class="form-control js-assignment-lesson" required>').append(option('', lessons.length ? 'اختر المادة الدراسية' : 'لا توجد مواد لهذا الصف'));
            var roomSelect = $('<select class="form-control js-assignment-room" multiple required>').append(option('', roomsData.length ? 'اختر الشعبة أو الشعب' : 'لا توجد شعب مجهزة لهذا الصف'));

            lessons.forEach(function (lesson) { lessonSelect.append(option(lesson.id, lesson.name)); });
            if (roomsData.length) { roomSelect.append(option('0', 'كافة الشعب')); }
            roomsData.forEach(function (room) { roomSelect.append(option(room.id, room.name)); });

            lessonField.html('<label>المادة الدراسية</label>').append(lessonSelect);
            roomField.html('<label>الشعبة</label>').append(roomSelect);
            if (!lessons.length) { setFieldMessage(lessonField, 'لا توجد مواد مرتبطة بهذا الصف.'); }
            if (!roomsData.length) { setFieldMessage(roomField, 'لا توجد شعب مجهزة لهذا الصف في العام الدراسي الحالي.'); }
        }).fail(function () {
            lessonField.html('<label>المادة الدراسية</label><select class="form-control" disabled><option>تعذر تحميل المواد</option></select>');
            roomField.html('<label>الشعبة</label><select class="form-control" disabled><option>تعذر تحميل الشعب</option></select>');
            setFieldMessage(roomField, 'تعذر تحميل البيانات. يرجى تحديث الصفحة والمحاولة مجدداً.');
        });
    });

    rows.on('change', '.js-assignment-lesson', function () {
        var row = $(this).closest('.assignment-row');
        var roomSelect = row.find('.js-assignment-room');
        var lessonId = $(this).val();
        roomSelect.removeAttr('name');
        if (lessonId) {
            roomSelect.attr('name', 'room_id[' + lessonId + '][]');
        }
    });

    rows.on('change', '.js-assignment-room', function () {
        var values = $(this).val() || [];
        if (values.indexOf('0') !== -1 && values.length > 1) {
            $(this).val(['0']);
        }
    });

    $('#add-assignment-row').on('click', addRow);
    rows.on('click', '.js-remove-assignment', function () {
        $(this).closest('.assignment-row').remove();
        updateRemoveButtons();
    });

    $('#teacher-assignment-form').on('submit', function (event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            this.reportValidity();
            return;
        }
        if (!window.confirm('سيتم حفظ القائمة الحالية كتَكليفات المدرس للعام الدراسي الحالي. هل تريد المتابعة؟')) {
            event.preventDefault();
        }
    });

    addRow();
})(jQuery);
</script>
@endsection
