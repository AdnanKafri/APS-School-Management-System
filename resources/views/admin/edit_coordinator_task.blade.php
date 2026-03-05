@extends('admin.master')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
        }

        .modal-confirm {
            color: #636363;
            width: 400px;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }

        .modal-confirm .modal-body {
            color: #999;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }

        .modal-confirm .modal-footer a {
            color: #999;
        }

        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }

        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
        }

        .modal-confirm .btn,
        .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
        }

        .modal-confirm .btn-secondary {
            background: #c1c1c1;
        }

        .modal-confirm .btn-secondary:hover,
        .modal-confirm .btn-secondary:focus {
            background: #a8a8a8;
        }

        .modal-confirm .btn-danger {
            background: #f15e5e;
        }

        .modal-confirm .btn-danger:hover,
        .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }

        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }
    </style>
@endsection

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active"> تعديل مهام المشرف المدرسي</a>
        <a href ="{{ route('coordinators') }}" class="breadcrumbs__item "> قسم مشرفي المدرسة </a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection


@section('content')


    <div class="container" style="margin: 50px">
        <div class="row">

            <div class="col-md-12">
                <h3 class="text-center">تعديل مهام المشرف المدرسي</h3>
            </div>


            <div class="col-md-12">
                <form class="form" action="{{ route('coordinator.update_task') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="coordinator_id" value="{{ $coordinator->id }}">
                    @if (isset($coordinator->classes2))
                        @foreach ($coordinator->classes2 as $class)
                            <div class="cont"
                                style="border:1px solid #aaa; padding:10px; text-align:right; margin-bottom:10px">
                                <div>
                                    <div class="deldiv" style="text-align:left;color:red">
                                        <i class="fa fa-window-close fa-x" style="cursor:pointer" title="الغاء"
                                            aria-hidden="true"></i>
                                    </div>
                                    <label>الصف</label>
                                    <div class="form-group">
                                        <input type="hidden" value="{{ $class->id }}" class="lesson_old">
                                        <select name="class_id[]" id="classes" required class="form-control classes one"
                                            style="min-height: 36px;direction: rtl">
                                            <option value="{{ $class->id }}" selected>{{ $class->name }} </option>
                                        </select>
                                    </div>
                                    <div class="form-group class_rooms" id="class_rooms_{{ $class->id }}" style="text-align:right">
                                        <label>الشعبة الدراسية</label>
                                        @foreach ($class->rooms as $room)
                                            @if ($room->selected == true)
                                                <input class="req1" name="room_id[{{ $class->id }}][]" data-id="{{ $class->id }}"
                                                    type="checkbox" id="{{ $room->name }}{{ $room->id }}"
                                                    value="{{ $room->id }}" checked>
                                                <label for="{{ $room->name }}{{ $room->id }}">&nbsp;{{ $room->name }}
                                                    &nbsp;</label>
                                            @else
                                                <input class="req1" name="room_id[{{ $class->id }}][]" data-id="{{ $class->id }}"
                                                    type="checkbox" id="{{ $room->name }}{{ $room->id }}"
                                                    value="{{ $room->id }}">
                                                <label for="{{ $room->name }}{{ $room->id }}">&nbsp;{{ $room->name }}
                                                    &nbsp;</label>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="form-group class_lessons" id="class_lessons_{{ $class->id }}" style="text-align:right">
                                        <label>المادة الدراسية</label>
                                        @foreach ($class->lessons as $lesson)
                                            @if ($lesson->selected == true)
                                                <input class="req" name="lesson_id[{{ $class->id }}][]" data-id="{{ $class->id }}"
                                                    type="checkbox" id="{{ $lesson->name }}_{{ $lesson->id }}"
                                                    value="{{ $lesson->id }}" checked>
                                                <label for="{{ $lesson->name }}_{{ $lesson->id }}">&nbsp;{{ $lesson->name }}
                                                    &nbsp;</label>
                                            @else
                                                <input class="req" name="lesson_id[{{ $class->id }}][]" data-id="{{ $class->id }}"
                                                    type="checkbox" id="{{ $lesson->name }}_{{ $lesson->id }}"
                                                    value="{{ $lesson->id }}">
                                                <label for="{{ $lesson->name }}_{{ $lesson->id }}">&nbsp;{{ $lesson->name }}
                                                    &nbsp;</label>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif
                    <span style="cursor: pointer; margin-top:45px;"
                        class="hvr-sweep-to-top btn btn-info btn-block add_new_work_experiences hover" href="">اضافة
                        مهمة جديدة </span>
                    <button type="submit" id="confirm1" hidden>حفظ</button>
                    <div class="text-center">
                        <!-- Button HTML (to Trigger Modal) -->
                        <a href="#myModal" class="trigger-btn btn btn-success" data-toggle="modal">حفظ</a>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm" style="">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box" style="border-color: green !important">
                        <div class="icon-preview col s6 m3"><i class="material-icons dp48"
                                style="color: green">done</i><span></span></div>
                    </div>
                    <h4 class="modal-title w-100">هل أنت متأكد ؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>هل حقاً تريد حفظ هذه التغييرات .</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="button" id="ok" class="btn btn-success">تأكيد</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
<script>
    $(document).ready(function() {
        $('.lessons').select2();
        $('.rooms').select2();
        $('#ok').click(function() {
            /* when the submit button in the modal is clicked, submit the form */
            var formData = [];

            $.each($('.classes'), function(key, value) {
                var classId = $(this).val();
                var roomIds = [];
                var lessonIds = [];

                $.each($('.req1[data-id="' + classId + '"]:checked'), function(key, value) {
                    roomIds.push($(this).val());
                });

                $.each($('.req[data-id="' + classId + '"]:checked'), function(key, value) {
                    lessonIds.push($(this).val());
                });

                if (roomIds.length > 0 && lessonIds.length > 0) {
                    formData.push({
                        classId: classId,
                        roomIds: roomIds,
                        lessonIds: lessonIds
                    });
                }
            });

            if (formData.length === 0) {
                alert('يرجى اختيار الشعبة والمادة');
                return false;
            }

            // Store the formData in a hidden input field or send it to the server
            var formDataJson = JSON.stringify(formData);
            $('#formDataInput').val(formDataJson);

            // Proceed with form submission
            $('#confirm1').click();
        });

        $(document).on('click', '.deldiv', function() {
            $(this).parent().remove();
        });

        $(document).on('click', '.add_new_work_experiences', function() {
            var type = `
                <div style="border:1px solid #aaa; padding:10px; text-align:right">
                    <div class="deldiv" style="text-align:right;color:red">
                        <i class="fa fa-window-close fa-3x" style="cursor:pointer" title="الغاء" aria-hidden="true"></i>
                    </div>
                    <h1>صف جديد</h1>
                    <div class="form-group" style="text-align:right">
                        <label>الصف</label>
                        <select name="class_id[]" required id="classes" class="form-control classes dep" style="min-height: 36px;direction: rtl">
                            <option value="">اختر الصف الدراسي</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group class_rooms" id="" style="text-align:right"></div>
                    <div class="form-group class_lessons" id="" style="text-align:right"></div>
                    <div></div>
                </div>
            `;

            $(this).prev().append(type);
        });

        $(document).on('change', '.classes', function() {
            var classId = $(this).val();
            var url = "{{ URL::to('SMT/admin/classes/teacher_lessons') }}/" + classId;
            var classRoomsElem = $(this).parent().siblings('.class_rooms');
            var classLessonsElem = $(this).parent().siblings('.class_lessons');

            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                    classRoomsElem.empty();
                    $.each(data.rooms, function(key, value) {
                        classRoomsElem.append(`
                            <input class="req1" name="room_id[${classId}][]" data-id="${classId}" type="checkbox" id="${value.name}${value.id}" value="${value.id}">
                            <label for="${value.name}${value.id}">&nbsp; ${value.name} &nbsp;</label>
                        `);
                    });

                    classLessonsElem.empty();
                    $.each(data.lessons, function(key, value) {
                        classLessonsElem.append(`
                            <input class="req" name="lesson_id[${classId}][]" data-id="${classId}" type="checkbox" id="${value.name}${value.id}" value="${value.id}">
                            <label for="${value.name}${value.id}">&nbsp; ${value.name} &nbsp;</label>
                        `);
                    });

                    $('.lessons').select2({
                        placeholder: "اختر مادة واحدة أو أكثر"
                    });
                    $('.rooms').select2({
                        placeholder: "اختر شعبة واحدة أو أكثر"
                    });
                    $('.select2-search__field').css('text-align', 'right');
                },

        });
    });
});
</script>
@endsection
