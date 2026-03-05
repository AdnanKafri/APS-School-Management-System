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
    }
    td{
        font-size: 17px;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .dropdown-item{
        color: black !important;
        width: auto !important;
    }
    .fa-folder{
        margin: 2px;
    }
    .dorat{
        color: blue !important;
    }
    img{
        border-radius:50%;
    }
    /* ///////////////////////////////////// */


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
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
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
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
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}








.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
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
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
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
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}

th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
.dt-button{
    color: black !important;
}
#table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection



@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم طلبات تعديل المعلومات   </a>
    <a href="{{ route('secret_keeper') }}" class="breadcrumbs__item ">امين السر الاكتروني </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')



<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">طلبات تعديل معلومات  الطلاب </h1>
        </div>
       
        <div class="m-4">
             <div class="row" >
                    <div class="col-12 col-lg-4">
                    <select class="form-control "   name="stage" id="stage_id_filter1">
                        <option value="0">  جميع المراحل </option>
                        @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-12 col-lg-4">
                    
                        
                        <select  name="classes" id="classes_select" class="form-control" >
                            <option value="0"> جميع الصفوف </option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <select  name="rooms" id="rooms_classes" class="form-control" >
                            <option value="0"> جميع الشعب </option>
                        </select>
                    </div>
                </div>
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" >الإسم الأول</th>
                        <th scope="col" class="sort" >الكنية</th>
                        <th scope="col" class="sort" >الصف </th>
                        <th scope="col" class="sort" > الشعبة</th>
                       
                        <th scope="col" class="sort" >التاريخ </th>
                        
                        <th scope="col" class="sort" > رقم التواصل </th>
                         <th scope="col" class="sort" >الرسالة</th>
                        <th scope="col" class="sort" > حذف</th>
                         <th scope="col" class="sort" > تعديل </th>
                      
                      </tr>
                </thead>
                <tbody >
                    @foreach($request_edit as $item)
                    <tr>
                        <td>{{$item->student->first_name}}</td>
                        <td>{{$item->student->last_name}}</td>
                        <td>{{$item->student->room[0]->name}}</td>
                        <td>{{$item->student->room[0]->classes->name}}</td>
                        <td>{{$item->created_at}}</td>  
                        
                        <td>{{$item->phone}}</td>
                          <td>{{$item->message}}</td>
                            <td><a href=".delete_invoice" data-toggle="modal" class="delete1" data-id="{{$item->id}}" style="
                                direction: ltr;color: red !important;"><i class='fa fa-trash'></i> </a></td>
                                <td>
                                 
                         
                               <a href="{{ route('student_details2',$item->student->id) }}"  style="color: #0083FF"><i class="fa fa-eye fa-2x" style="color: #008CC4;font-size: medium"></i></a>
                            
                                 </td>
 

                    </tr>
                    @endforeach
                    

                  
                </tbody>
              </table>

        </div>
    </div>
</div>
<div class="modal fade delete_invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete" action="{{route('delete_request_edit')}}" method="POST">
                @csrf


                <div class="modal-header">

                    <h4 class="modal-title">حذف طلب تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="text-align: right;
                ">
                     <input class="delete11"  hidden   name="id" >
                    <p>       هل انت متاكد من حذف الطلب</p>
                  
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal"
                        value="الغاء">

                    <button class="btn btn-danger" type="submit">حذف</button>


                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<!--<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>

$(document).ready(function () {
 $('#table_xx').DataTable();
$('.delete1').on('click', function () {
    var id = $(this).data('id');

    $('.delete11').val(id);

});
$(document).on('change', '#stage_id_filter1', function () {

// var year_id = $('#years').val();
var stage_id = $(this).val();
var url = "{{ URL::to('SMT/admin/stages_class_secret') }}/" + stage_id ;
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $('#classes_select').empty();
        $('#classes_select').append(`<option value="0"> جميع الصفوف </option>`);
        $.each(data, function (key, value) {
            $('#classes_select').append(
                `<option value="${value.id}">${value.name}</option>`);
        });
        $('#rooms_classes').empty();
        $('#rooms_classes').append(`<option value="0">جميع الشعب</option>`);
        myfunction();
    },


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
    myfunction();
});
$(document).on('change', '#rooms_classes', function () {
    myfunction();
})
function myfunction(){ 
    var url = "{{ URL::to('SMT/admin/filter_getstudents_request_edit') }}/";
    if ($.fn.DataTable.isDataTable('#table_xx')) {
        $('#table_xx').DataTable().destroy();
    }
    $('#table_xx tbody').empty();
    $.ajax({
        url: url,
        data: {
            stage: $('#stage_id_filter1').val(),
            classes: $('#classes_select').val(),
            room: $('#rooms_classes').val()
        },
        type: "get",
        contentType: 'application/json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                $('#table_xx tbody').append(`
                    <tr>
                        <td>${value.student.first_name}</td>
                        <td>${value.student.last_name}</td>
                        <td>${value.student.room[0].name}</td>
                        <td>${value.student.room[0].classes.name}</td>
                        <td>${value.created_at}</td>  
                        <td>${value.phone}</td>
                        <td>${value.message}</td>
                        <td><a href=".delete_invoice" data-toggle="modal" class="delete1" data-id="${value.id}" style="direction: ltr;color: red !important;"><i class='fa fa-trash'></i> </a></td>
                        <td>
                            <a href="{{ url('SMT/admin/student_details2') }}/${value.id}" style="color: #0083FF"><i class="fa fa-eye fa-2x" style="color: #008CC4;font-size: medium"></i></a>
                        </td>
                    </tr>`);
            });
            $('#table_xx').DataTable();
        },
        error: function (error) {
            console.log(error);
            // Handle the error here
        }
    });
};

})
</script>
@endsection
