@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center !important;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .form-group{
        margin: 0px !important;
    }

.dt-button{
    font-size: 20px !important;
    color: black !important;
    line-height: 2
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">حضور المعلمين</a>
    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير و الاحصائيات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


  <div class="modal fade detailsModal ">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header" >
                        <h4 class="modal-title" style="color: #f00">التفاصيل</h4>
                        <button type="button" class="close"
                        style="color: #f00" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th> الصف </th>
                                    <th> اسم المادة </th>
                                    <th> عدد مرات الحضور </th>
                                </tr>
                            </thead>
                            <tbody id="add_details" >

                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول المدرسين</h1>
        </div>
        <div class="row" >
            <div class="col-12 col-lg-2">
                <select name="classes" id="classes_select" class="form-control">
                    <option value=""> جميع الصفوف </option>
                    @foreach ($classes as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-2">
                <select name="rooms" id="rooms_classes" class="form-control">
                    <option value=""> جميع الشعب </option>
                </select>
            </div>
            <div class=" col-12 col-lg-3">
                <label for=""> من :  </label>
                <input type="date" class="form-control" id="start_date" style="display: inline-block;width: 70%">
            </div>
            <div class=" col-12 col-lg-3">
                <label for=""> الى :  </label>
                <input type="date" class="form-control" id="end_date" style="display: inline-block;width: 70%">
            </div>
        </div>
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th> عدد مرات الحضور </th>
                    <th> التفاصيل </th>
                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


                </tbody>
              </table>



        </div>
    </div>
</div>
@php
    $year2 = \App\Year::where('current_year',1)->first();
@endphp
<input type="hidden" name="year_id" id="years" value={{$year2->id}}>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script> --}}
<script >





$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="">جميع الشعب</option>`);
table_test.draw();
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

$('#rooms_classes,#start_date,#end_date').change(function () {
        table_test.draw();
})

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 50,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getteachers2') }}",
            data : function (d) {
                d.classes = $('#classes_select').val();
                d.rooms= $('#rooms_classes').val();
                d.start2= $('#start_date').val();
                d.end2= $('#end_date').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.first_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    var sum = 0;
                    $.each(full.user.student_schedule_tracer, function (indexInArray, valueOfElement) {
                        sum += valueOfElement.count;
                    });
                    return `${sum}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `<a class="btn btn-success button_details" data-toggle="modal" data-target=".detailsModal" data-details='${JSON.stringify(full.user.student_schedule_tracer)}' > تفاصيل </a>`;
                }
            },
        ]
    });


    $(document).on('click', '.button_details', function () {
        console.log( $(this).data('details') );
        $('#add_details').empty();
        $.each($(this).data('details'), function (indexInArray, valueOfElement) {
            $('#add_details').append(`
                    <tr>
                        <td>${@json($lesson)[valueOfElement.lesson_id] != undefined ?( @json($classes2)[@json($lesson2)[valueOfElement.lesson_id]] ): ""}</td>
                        <td>${@json($lesson)[valueOfElement.lesson_id] != undefined ? @json($lesson)[valueOfElement.lesson_id] : ""}</td>
                        <td>${valueOfElement.count}</td>
                    </tr>
            `);
        });
    });


$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});
$(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


$(document).on('click','.edit_teacher',function (e) {
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
 $(".english_name").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});
</script>

@endsection
