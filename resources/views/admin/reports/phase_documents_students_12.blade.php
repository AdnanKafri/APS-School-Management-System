@extends('admin.master')

@section('style')
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

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
    }

    td {
        font-size: 17px;
    }

    a.page-link {
        color: #7571f9 !important;
    }

    .pagination {
        justify-content: center;
    }

    .dropdown-item {
        color: black !important;
        width: auto !important;
    }

    .fa-folder {
        margin: 2px;
    }

    .dorat {
        color: blue !important;
    }

    img {
        border-radius: 50%;
    }

    /* ///////////////////////////////////// */


    .wrapper {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper .option {
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
    }

    .wrapper .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper .option .dot::before {
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    .wrapper input[type="radio"] {
        display: none;
    }

    #option-1:checked:checked~.option-1,
    #option-2:checked:checked~.option-2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-1:checked:checked~.option-1 .dot,
    #option-2:checked:checked~.option-2 .dot {
        background: #fff;
    }

    #option-1:checked:checked~.option-1 .dot::before,
    #option-2:checked:checked~.option-2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-1:checked:checked~.option-1 span,
    #option-2:checked:checked~.option-2 span {
        color: #fff;
    }

    .wrapper_lang {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper_lang .option {
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
    }

    .wrapper_lang .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper_lang .option .dot::before {
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    .wrapper_lang input[type="radio"] {
        display: none;
    }

    #option-lang1:checked:checked~.option-lang1,
    #option-lang2:checked:checked~.option-lang2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-lang1:checked:checked~.option-lang1 .dot,
    #option-lang2:checked:checked~.option-lang2 .dot {
        background: #fff;
    }

    #option-lang1:checked:checked~.option-lang1 .dot::before,
    #option-lang2:checked:checked~.option-lang2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper_lang .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-lang1:checked:checked~.option-lang1 span,
    #option-lang2:checked:checked~.option-lang2 span {
        color: #fff;
    }

    th {
        font-size: 20px;
        border-bottom: 1px solid #008991 !important;
        text-align: center !important;
    }

    td {
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center;
    }
    .table .thead-light th {
    color: #495057;
    background-color: white;
    /* border-color: #dee2e6; */
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item ">الطلاب</a>
    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item is-active">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

<!------------------------------------------------>

@php
$about = \App\Other::find(1);
@endphp
{{-- <div class=" col-12 col-lg-2" style="text-align: left;">
    <a class="btn btn-success" >  <a href="{{ route('export_student1') }}"></a>تصدير الطلاب </a>
</div> --}}



{{-- ////////// --}}






<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب</h1>
        </div>

        <div class="row">

            <select class="form-control col-12 col-lg-3" id="class_id_filter">
                <option value=" ">اختر صف</option>
                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

            <select class="form-control col-12 col-lg-3" id="room_id_filter">
                <option value="">اختر شعبة</option>
            </select>
        </div>
         <div class="table-responsive" style="overflow-x: scroll;">
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="budget">رقم الطالب  </th>-->
                        <th scope="col" class="sort" data-sort="budget">رقم التسجيل   </th>
                        <th scope="col" class="sort" data-sort="budget">الإسم الأول</th>
                        <th scope="col" class="sort" data-sort="status">الكنية</th>
                        {{-- <th scope="col" class="sort" data-sort="completion">العنوان</th>
                        <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                        <th scope="col" class="sort" data-sort="completion">الصورة</th> --}}
                        <th scope="col" class="sort" data-sort="completion">الصف</th>
                        <th scope="col" class="sort" data-sort="completion">الشعبة</th>
                        <th scope="col" class="sort" data-sort="completion">الوثيقة</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('js')







<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script>

    var i=0;
    var v=0;
var x=[];
var obj ={ };
var obj1={ };

console.log(obj);
    var table_test = $('#table_xx').DataTable({

        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudents') }}",
            data: function (d) {
                 d.class_id =$('#class_id_filter').val();
                d.room_id = $('#room_id_filter').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);

                return json.aaData;
            }
        },

        columns: [
            // {

            //     data: 'id',
            //     render: function (data, type, full) {

            //         if(full.room[0].id==v  && (full.id in obj)!=true ){
            //             i= i+1;

            //             console.log(i);
            //           obj[full.id]=i;
            //             obj1[full.room[0].id]=obj;
            //             }else if((full.id in obj)!=true && jQuery.inArray(full.room[0].id,x)==-1) {

            //                 i=1;
            //                  x.push(full.room[0].id)
            //                 obj[full.id]=i;
            //                  obj1[full.room[0].id]=obj;
            //                                       ;

            //             }

            //                                         console.log(obj1);

            //         return `${obj[full.id]}`;
            //     },orderable : false
            //     },

               {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.id}`;
                },orderable : false
            },

        {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.first_name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                },orderable : false
            },
            // {
            //     data: 'id',
            //     render: function (data, type, full) {
            //         return `${full.address}`;
            //     },orderable : false
            // },
            // {
            //     data: 'id',
            //     render: function (data, type, full) {
            //         return `${full.details.phone != null ? full.details.phone : ''}`;
            //     },orderable : false
            // },
            // {
            //     data: 'id',
            //     render: function (data, type, full) {
            //         return `${full.details.personal_image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.details.personal_image}" >` : ""}`;
            //     },orderable : false
            // },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].classes.name : ""}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    v=full.room[0].id;
                    return `${full.room[0] != null ? full.room[0].name : ""}`;
                },orderable : false
            },
            {

                data: 'id',
                render: function (data, type, full) {
                    return `

                <a href="{{ url('SMT/admin/students/phase_12') }}/${full.id}" target="_blank">
                <i class=" fa fa-archive" style="color: #0083FF;font-size: medium"></i>
                </a> `;
                },orderable : false
            },

        ],
        // dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
        ]
    });


    $('#room_id_filter').change(function () {
        table_test.draw();
    })


    // $(document).on('click', '.edit_teacher', function (e) {
    //     var data = $(this).data('data');

    //     $('#edit_teacher_id').val(data.id);
    //     $('#edit_first_name').val(data.first_name);
    //     $('#edit_last_name').val(data.last_name);
    //     $('#edit_date_birth').val(data.date_birth);
    //     $('#edit_address').val(data.address);
    //     $('#edit_phone').val(data.phone);
    //     $('#edit_email').val(data.email);

    //     console.log(data.id);
    // });







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


    $(document).on('change', '#class_id_filter', function () {

        var year_id = $('#years').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $('#room_id_filter').empty();
                $('#room_id_filter').append(`<option value="">اختر الشعبة </option>`);
                $.each(data, function (key, value) {
                    $('#room_id_filter').append(
                        `<option value="${value.id}">${value.name}</option>`);
                });
                table_test.draw();
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


</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
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

    $(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="0">جميع الشعب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
        });
    },


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
</script>
@endsection
