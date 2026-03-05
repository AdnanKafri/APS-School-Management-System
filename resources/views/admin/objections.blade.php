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
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم    الاعتراضات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


@php
$about = \App\About_us::find(1);
@endphp
<input type="hidden" name="year_id" id="years" value={{$year2->id}}>
 <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" action="{{route('delete_objection')}}" method="POST">
                                        @csrf


                                        <div class="modal-header" style="
    text-align: right;">


                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">حذف صورة  </h4>
                                        </div>
                                        <div class="modal-body">
                                             <input class="delete1"  id="objec_id" hidden   name="id" >
                                            <p style="
    text-align: right;">  هل انت متأكد من حذف  </p>
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
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586"> جدول الاعتراضات  </h1>
        </div>
         <div class="row" >
            <div class="col-12 col-lg-6">
                <select name="classes" id="classes_select" class="form-control">
                    <option value=""> جميع الصفوف </option>
                    @foreach ($classes as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-6">
                <select name="rooms" id="rooms_classes" class="form-control">
                    <option value=""> جميع الشعب </option>
                </select>
            </div>
        </div>
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">اسم الطالب  </th>
                     <th scope="col" class="sort" data-sort="budget">معلومات    </th>
                      <th scope="col" class="sort" data-sort="budget"> السبب   </th>
                        <th scope="col" class="sort" data-sort="budget">  تاريخ الاعتراض    </th>
                    <th scope="col" class="sort" data-sort="status">اسم الاستاذ</th>
                      <th scope="col" class="sort" data-sort="status"> الحالة </th>
                       <th scope="col" class="sort" data-sort="status"> حذف </th>



                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


                </tbody>
              </table>



        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >
$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="">جميع الشعب</option>`);
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
$('#rooms_classes,#classes_select').change(function () {
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
             data : function (d) {
                d.classes = $('#classes_select').val();
                d.rooms= $('#rooms_classes').val();
            },
            "type": "GET",
            "url": "{{ route('getobj') }}",
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
                    return `${full.student_first_name} ${full.student_last_name} `;
                }
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room_name} / ${full.classe_name} /  ${full.lesson}   ` ;
                }
            },
              {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.name}`;
                }
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.created}`;
                }
            },

             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.teacher_first_name} ${full.teacher_last_name}`;
                }
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.type ==1  ?  `<p> تمت المعالجة </p>` :`<p>
                    قيد المعالجة
                    </p>`}`;
                }
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `
                        <a  data-id="${ full.id }" style="font-size:18px !important"    data-toggle="modal" data-target=".deleteEmployeeModal"  class="btn btn-info btn-sm edit" title=" تعديل "  style="font-size:18px !important">
                            <i class="fa fa-trash" style="color: #eff0f1"></i>
                        </a>

                    `;
                }
            },

        ]
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


$(document).on('click','.edit',function (e) {


 $('#objec_id').val($(this).data('id'));



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
