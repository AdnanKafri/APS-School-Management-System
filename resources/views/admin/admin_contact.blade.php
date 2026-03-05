@extends('admin.master')
@section('style')
<style>
    * {
        direction: rtl !important;
        /* text-align: center; */
    }

    button,
    a {
        color: white !important;
    }

    .form-group {
        text-align: right;
    }

    label {
        font-size: 20px;
        color: black;
    }

    input {
        font-size: 17px !important;
    }

    th {
        font-size: 20px;
        border: 0px !important;
        text-align: center !important;
    }

    td {
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }

    tr {
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }

    a.page-link {
        color: #7571f9 !important;
    }

    .pagination {
        justify-content: center;
    }

    .form-group {
        margin: 0px !important;
    }
    #table_xx_wrapper{
    overflow: auto;
}
.table .thead-light th {
    color: #495057;
    background-color: white;
    border-color: #dee2e6;
}
.select2-container {
    width: inherit !important;
}

</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection



@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item is-active "> قسم الرسائل للطلاب </a>
    <a href="{{ route('student_contact') }}" class="breadcrumbs__item "> قسم التواصل مع الطلاب </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

@if(session()->has('success'))

<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ session()->get('success') }}
</div>
@endif



@php
$about = \App\About_us::find(1);
@endphp


{{-- ////////// --}}

<input type="hidden" name="year_id" id="years" value={{$year2->id}}>
<div class="modal fade" id="selectexport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="min-width: 50%">
        <form action="{{ route('send_message_admin') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"> ارسال رسالة </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-12" style="padding-top: 6px;direction:rtl;text-align: right;">
                            <Label>اختر الصف</Label>
                            <select name="classes[]" id="classes_select1"  multiple="multiple" class=" js-example-basic-single form-control">
                                <option value="0"> جميع الصفوف </option>
                                @foreach ($classes as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <br>
                        <div class="col-12 col-lg-12" style="padding-top: 6px;direction:rtl;text-align: right;">
                            <Label>اختر الشعبة</Label>
                            <select name="rooms[]" id="rooms_classes1"  multiple="multiple" class="form-control">
                                <option value="0"> جميع الشعب </option>
                            </select>
                        </div>
                        <br>
                        <div class="col-12 col-lg-12" style="padding-top: 6px;direction:rtl;text-align: right;">
                            <Label>اختر الطلاب</Label>
                            <select name="student[]" id="student_classes" multiple="multiple" class="form-control">
                                <option value="0"> جميع الطلاب </option>
                            </select>
                        </div>
                        <br>
                        <div class="col-12 col-lg-12" style="padding-top: 6px;direction:rtl;text-align: right;">
                            <textarea required class="form-control" name="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: flex-start;">
                    <a class="btn btn-secondary" data-dismiss="modal">اغلاق</a>
                    <button type="submit" class="btn btn-primary note_disabled">ارسال</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade deleteEmployeeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete" action="{{route('delete_mes')}}" method="POST">
                @csrf


                <div class="modal-header" style="
text-align: right;">


                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                        <h4 class="modal-title">حذف الرسالة  </h4>
                </div>
                <div class="modal-body">
                     <input class="delete1"  id="objec_id" hidden   name="id" >
                    <p style="
text-align: right;">   هل انت متأكد من حذف  </p>
                    <p class="text-warning" style="
text-align: right;"><small>لا يمكن التراجع عن هذا الإجراء
                   </small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal"
                        value="الغاء">

                    <button class="btn btn-danger">حذف </button>


                </div>
            </form>
        </div>
    </div>
</div>


<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول رسائل الطلاب </h1>
        </div>
        <br>
        <div class="row">
            <button type="button" class="btn mb-1 btn-success" data-target="#selectexport" data-toggle="modal"> ارسال
                رسالة </button>
        </div>
        <br>
        <div class="row">
            <select class="form-control col-12 col-lg-4" id="classes_select">
                <option value="">اختر صف</option>
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            <select class="form-control col-12 col-lg-4" id="rooms_classes">
                <option value="">اختر شعبة</option>
            </select>
             <select class="form-control col-12 col-lg-4" id="rooms_student">
                <option value="">اختر  الطالب</option>
            </select>
        </div>
        <div class="m-4">
            <table class="table align-items-center table-striped" id="table_xx">
                <thead class="thead-light" id="thead_append">
                    <tr>
                        <th> الاسم الأول </th>
                        <th> الكنية </th>
                        <th> الصف </th>
                        <th> الشعبة </th>
                        <th> الرسالة </th>
                        <th> تاريخ الارسال </th>
                        <th> حذف </th>
                    </tr>
                </thead>
                <tbody id="tbody_append">

                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>

<script>
   
    $('#rooms_classes').change(function () {
                table_test.draw();
        })
       
        $('#rooms_student').change(function () {
                table_test.draw();
        })

    var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudents_contact_admin') }}",
            data: function (d) {
                d.class_id = $('#classes_select').val();
                d.room_id = $('#rooms_classes').val();
                d.student_id = $('#rooms_student').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [{

                data: 'id',
                render: function (data, type, full) {
                    return `${full.first_name}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].classes.name : ""}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].name : ""}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.message != null ? full.message: ""}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.created_at != null ? full.created_at: ""}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `<button type="button" style="border: none;"data-id="${full.id}"   class="delete" data-toggle="modal" data-target=".deleteEmployeeModal"  >  <i class="fa fa-trash" style="font-size: 19px;color: #af686e"></i>   </button>
                    `;
                },
                orderable : false
            },

        ]
    });


    $(document).on('change', '#classes', function () {
        var class_id = $(this).val();

        var url = "{{ URL::to('SMT/admin/classes/rooms') }}/" + class_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                $('#class_room').empty();
                var type = `

                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });


                $('#class_room').append(type);

            },
            error: function (xhr) {

            }

        });
    });


    $(document).on('change', '#classes_select', function () {

        var year_id = $('#years').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2_role') }}/" + class_id + "/" + year_id;
        $('#rooms_student').empty();
        $('#rooms_student').append(`<option value="">جميع   الطلاب</option>`);
        $('#rooms_classes').empty();
        $('#rooms_classes').append(`<option value="">جميع الشعب</option>`);
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#rooms_classes').append(
                        `<option value="${value.id}">${value.name}</option>`);
                });
                 table_test.draw();
            },
           


        });
    });
    $(document).on('change', '#classes_select1', function () {

        var year_id = $('#years').val();
        var class_id = $(this).val();
      
        var url = "{{ URL::to('SMT/admin/classes/rooms22') }}";
        $('#rooms_classes1').empty();
        $('#rooms_classes1').append(`<option value="0">جميع الشعب</option>`);
        $.ajax({
            data:{
                class_id:class_id,
            },
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#rooms_classes1').append(
                        `<option value="${value.id}">${value.name}</option>`);
                });
            },


        });
    });
    $(document).on('change', '#rooms_classes1', function () {

        var year_id = $('#years').val();
        var class_id = $(this).val();
   
        var url = "{{ URL::to('SMT/admin/classes/rooms22/student2') }}/"+ year_id;
        $('#student_classes').empty();
        $('#student_classes').append(`<option value="0">جميع الطلاب</option>`);
        $.ajax({
            data:{
                class_id:class_id,
            },
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $.each(value, function (key1, value1) {
                    $('#student_classes').append(
                        `<option value="${value1.id}">${value1.first_name}  ${value1.last_name} </option>`
                        );
                });
            });
            },


        });
    });


    $(document).on('change', '#rooms_classes', function () {

var year_id = $('#years').val();
var class_id = $(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2/student') }}/" + class_id + "/" + year_id;
$('#rooms_student').empty();
$('#rooms_student').append(`<option value="">جميع   الطلاب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_student').append(
                `<option value="${value.id}">${value.first_name}  ${value.last_name} </option>`
                );
        });
    },


});
});

    $(document).on('change', '#classes_change', function () {
        $('#mydivroom').empty();

        var year_id = $('#years').val();
        var class_id = $(this).val();

        var type = "";

        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                var type = `
                <label>الشعبة</label>

                <select name="room_change_id" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {
                    type += `<option value="${value.id}">${value.name}</option>`;
                });

                type += `</select>`;
                $('#mydivroom').append(type);
            },


        });
    });


    $('input:radio[name=select]').on('click', function () {

        $('#mydivclass').empty();

        var val = $(this).val();
        var type = "";
        type += `
                <br>
                <div class="form-group" style="text-align:right">
                <label >الصف</label>

                <select name="class_change_id" id="classes_change" class="form-control dep"
                    style="min-height: 36px;direction: rtl" required>
                    <option value="">اختر الصف الدراسي</option>

                @foreach ($classes as $class)

                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach

                </select>

            </div>
        `;
        $('#mydivclass').append(type);

    });



    $(document).on('click', '.change_student', function () {

        $('#student_id').val($(this).data('id'));

        var student_id = $(this).data('id');
        var student_name = $(this).data('name');
        var url = "{{ URL::to('SMARMANger/admin/students/student_detail_prev') }}/" + student_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $('.student_name').text(student_name + " عام " + data.year_name + " كان" +
                    " في الصف  " + data.class_name + " " + data.room_name);
            },
            error: function (xhr) {

            }

        });

    });



    $(document).on('click', '.student_less', function (e) {
        var student_id = $(this).data('id');
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{ route('student.less') }}",
            enctype: 'multipart/form-data',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': student_id,
            },
            success: function (data) {
                $(`#super_${student_id}`).attr('style', 'color:blue');
                $(`#super_${student_id}`).parent().attr('class', 'student_super')
            },
        });
    });

    $(document).on('click', '.student_super', function (e) {
        var student_id = $(this).data('id');
        e.preventDefault();
        $.ajax({

            type: 'post',
            url: "{{ route('student.super') }}",
            enctype: 'multipart/form-data',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': student_id,
            },


            success: function (data) {
                $(`#super_${student_id}`).attr('style', 'color:green');
                $(`#super_${student_id}`).parent().attr('class', 'student_less')
                swal({
                    title: "حسناً",
                    text: "! تمت العملية بنجاح",
                    icon: "success",
                    button: "OK",
                    timer: 2000
                });
            },

        });

    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
       
    $(document).on("click", ".share_teacher", function () {
        $('#pass_share').text($(this).data("pass"));
        $('#username_share').text($(this).data("username"));
        $('#name_share').text($(this).data("name"));
    });

    $(document).on("click", "#screenshot", function () {
        html2canvas(document.querySelector("#dvContainer")).then(canvas => {
            a = document.createElement('a');
            document.body.appendChild(a);
            a.download = $('#name_share').text() + ".png";
            a.href = canvas.toDataURL();
            a.click();
        });
    });


    $(document).on('click', '.edit_teacher', function (e) {
        var data = $(this).data('data');

        $('#edit_teacher_id').val(data.id);
        $('#edit_first_name').val(data.first_name);
        $('#edit_last_name').val(data.last_name);
        $('#edit_date_birth').val(data.date_birth);
        $('#edit_address').val(data.address);
        $('#edit_phone').val(data.phone);
        $('#edit_email').val(data.email);

        console.log(data.id);
    });
    $(".english_name").keypress(function (event) {
        var ew = event.which;
        if (ew == 32)
            return true;
        if (48 <= ew && ew <= 57)
            return true;
        if (65 <= ew && ew <= 90)
            return true;
        if (97 <= ew && ew <= 122)
            return true;
        return false;
    });
    $(document).on('click', '.delete', function () {
    var id = $(this).data('id');


    $('#objec_id').val(id);

});
$('#rooms_classes1').select2();
      $('#student_classes').select2();
      $('#classes_select1').select2();
</script>


@endsection
