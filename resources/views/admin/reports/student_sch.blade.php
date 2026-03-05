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
  .content-body{
                min-height: auto !important;
        }
#report_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">حضور الطلاب</a>
    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')





<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب </h1>
        </div>
        <div class="row" >
            <div class="col-12 col-lg-2" style="">
                <select name="class_id" id="classes_select" class="form-control ">

                    <option value="">  اختر الصف </option>
                    @foreach ($class  as $item )
                    <option value="{{$item->id}}">   {{$item->name}}  </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-2" style="">
                <select name="" id="rooms_classes" class="form-control ">

                    <option value="">   اختر الشعبة  </option>
                
                </select>
            </div>
            
            <div class="col-12 col-lg-2" style="padding-top: 6px;">
                <select name="student_id" id="rooms_student" class="form-control student_id">

                    <option value="">  اختر الطالب  </option>
                  
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
            <div class=" col-12 col-lg-12" style="padding: 10px;
            text-align: center;">
                <a class="btn btn-success" id="search" > بحث  </a>
            </div>
        </div>
        <br>
        <br>
        <div id="nodata">
            <p style="font-size: x-large;
    text-align: center;">لايوجد بيانات </p>  </div>
        <div class="report" style="display:none">
            
            <table class="table align-items-center " id="report" >
                <thead style="color: black">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">التاريخ </th>
                    <th scope="col" class="sort" data-sort="status">الصف </th>
                    <th scope="col" class="sort" data-sort="status">الشعبة  </th>
                    <th scope="col" class="sort" data-sort="status">المادة  </th>
                    <th scope="col" class="sort" data-sort="status">الحصة  </th>
                    <th scope="col" class="sort" data-sort="status">الحضور   </th>
                    
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
        $(document).on('change', '#rooms_classes', function () {

var year_id = $('#years').val();
var class_id = $(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2/student') }}/" + class_id + "/" + year_id;
$('#rooms_student').empty();
// $('#rooms_student').append(`<option value="">جميع   الطلاب</option>`);
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
$(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_student').empty();
$('#rooms_student').append(`<option value="">جميع الطلاب </option>`);
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

    $('.student_id').select2();
    $('#report').DataTable({dom: 'Bfrtip',

        buttons: [

            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
          

     ],});
    $(document).on('click', '#search', function () {
   $('#nodata').hide();
  $('.report').show();
  
var student_id=$('#rooms_student').val();
var first_date=$('#start_date').val();
var end_date=$('#end_date').val();
var room_id=$('#rooms_classes').val();

var url = "{{ URL::to('SMT/admin/student_sched') }}/" + student_id +"/" +room_id+"/"+first_date+"/"+end_date;
if ($.fn.DataTable.isDataTable('#report')) {
                                $('#report').DataTable().destroy();
                                }
                                $('#report tbody').empty();
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        console.log(data);
        $.each(data, function (key, value) {
            $.each(value.lectures, function (key1, value1) {
                if(  value1.attendance == true){
                    Attend="<p style='color:green'>حضور</p>";

                }
                else if( value1.attendance  == false){
                    Attend="<p style='color:red'>غياب</p>";
                } 
                else{
                    Attend="<p>غير معروف</p>";
                }                       
                                  
                                  
                                
            $('#report tbody').append(`<tr>
                <td>${key}</td>
                <td>${value1.room.classes.name}</td>
                <td>${value1.room.name}</td>
                <td>${value1.lesson.name}</td>
                <td>${value1.lecture_time.name}</td>
                <td>${Attend}</td>
                </tr>`)
            })
        })
        
    
    
        $('#report').DataTable({dom: 'Bfrtip',

    buttons: [


        {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
          
 

],});
    },


});
});
</script>
@endsection
