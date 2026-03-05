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
    <a  class="breadcrumbs__item is-active">قسم   تفاصيل الفاتورة</a>
    <a href="{{ route('students_financial') }}" class="breadcrumbs__item ">قسم  الاقساط المالية   </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


@php
$about = \App\About_us::find(1);
@endphp
<br>
<br>

<div class="col">
  <div class="" style="justify-content: center">
    <button  class="btn btn-primary"  id="screenshot" style="justify-content: center">طباعة </button>

  </div>
    <div class="card" id="dvContainer">


     
      <div class="card-header border-0" style="text-align: center;">
        <h3 class="mb-0" style="display:inline-block">  جدول تفاصيل الفواتير للطالب</h3>
        <input id="name_student" hidden value="{{$student->first_name}} ">
        <h3 style=" text-align:center; color:green">{{$student->first_name}} {{$student->last_name}}</h3>
      </div>
<div class="table-responsive">



        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">Id</th>
              <th scope="col" class="sort" data-sort="budget">Invoice Number</th>
              <th scope="col" class="sort" data-sort="status">Invoice Amount</th>
              <th scope="col" class="sort" data-sort="budget">Payment Type </th>
              <th scope="col" class="sort" data-sort="status">Bank Name </th>
              <th scope="col" class="sort" data-sort="completion">Date</th>
              <th scope="col" class="sort" data-sort="completion"></th>

            </tr>
          </thead>
          <tbody class="list" id="mydiv">
          @foreach ($invoices_details as $item)

         <tr>
              <th scope="row">
              {{$item->id}}
              </th>
              <td class="budget">
              {{$item->invoice_number}}

            </td>

            <td class="budget">
              {{$item->invoice_amount}}

            </td>
            <td class="budget">
              {{$item->payment_type}}

            </td>
            <td class="budget">
              {{$item->bank_name}}

            </td>

            <td class="budget">
              {{$item->created_at}}

            </td>




              <td class="text-right">
                <a  class="details dropdown-item" title="printe"
                data-id="{{$item->id}}"><i class="fa fa-eye fa-2x" style="color: #008CC4"></i></a>
                {{-- <div class="dropdown"> --}}
                  {{-- <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a> --}}
                  {{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"> --}}
                  {{-- <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                    data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                        title="Delete" style="color: black !important;">&#xE872; حذف</i></a> --}}
                  {{-- <a  class="details dropdown-item"
                    data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                        title="printe" style="color: black !important;">&#xE872; طباعة</i></a> --}}
                  {{-- </div> --}}
{{--
                </div> --}}
              </td>


            </tr>


         @endforeach



          </tbody>
        </table>

      </div>


    </div>
    </div>

    <div class="modal fade deleteEmployeeModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <form id="form_delete" method="POST">
                  @csrf
                  <div class="modal-header">
                      <h4 class="modal-title">Delete element</h4>
                      <button type="button" class="close" data-dismiss="modal"
                          aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                      <p>Are you sure you want to delete these Records?</p>
                      <p class="text-warning"><small>This action cannot be undone.</small></p>
                  </div>
                  <div class="modal-footer">
                      <input type="button" class="btn btn-default" data-dismiss="modal"
                          value="Cancel">

                      <button class="btn btn-danger">Delete</button>


                  </div>
              </form>
          </div>
      </div>
  </div>


                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
                <script>

$(document).ready(function () {

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students/invoices_delete')}}/"+id;
    $('#form_delete').attr("action", url);


});

});
$(document).on('click', '.details', function () {

var invoices_id = $(this).data('id');
var student_name = $(this).data('name');

$('#invoices_id').val($(this).data('id'));


var url = "{{ URL::to('SMT/admin/students/invoices_print')}}/" + invoices_id;
$('.details').attr('href',url);


});

$(document).on("click", "#screenshot", function () {
  // window.print();
  var DocumentContainer = document.getElementById('dvContainer');
    var WindowObject = window.open('', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
    WindowObject.document.writeln(DocumentContainer.innerHTML);
    WindowObject.document.close();
    WindowObject.focus();
    WindowObject.print();
    WindowObject.close();
  // $("#dvContainer").print();
//   var divToPrint=document.getElementById('dvContainer');

// var newWin=window.open('','Print-Window');

// newWin.document.open();

// newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

// newWin.document.close();


    });
</script>

@endsection

@section('js')


@endsection
