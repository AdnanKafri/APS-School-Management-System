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
    #table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم   الفصول</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


@php
$about = \App\About_us::find(1);
@endphp


<div class="modal fade" id="up_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('term_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل فصل</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                         <input type="text" id="term_id" hidden name="term_id" >
                        <label>الإسم  </label>
                        <input type="text" id="term" name="name" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم " required>
                    </div>

                        <div class="form-group">
                            <label>  اختر السنة  </label>
                        <br>
                            <select class="form-control a year" required name="year_id" >
                            @isset($years)
                                @foreach ($years as $year)
                                    <option value="{{$year->id}}">  {{$year->name}} </option>
                                @endforeach
                            @endisset

                            </select>


                        </div>
                        <div class="form-group">
                            <label>  اختر   الفصل  </label>
                        <br>
                            <select class="form-control a  term1" required  name="type">

                                <!--<option value="1"> الفصل الاول  </option>-->
                                <!-- <option value="2"> الفصل الثاني  </option>-->

                            </select>


                        </div>
                         <div class="form-group">
                        <label> بداية الفصل   </label>
                        <input type="datetime-local" id="start" name="start" class="form-control a" style="direction:rtl"
                            required>
                    </div>
                     <div class="form-group">
                        <label> نهاية الفصل   </label>
                        <input type="datetime-local" id="end" name="end" class="form-control a" style="direction:rtl"
                            required>
                    </div>

                        {{-- <div class="form-group">
                           <label > الفصل الحالي   </label>
                        <input type="checkbox" id="current_term" name="current_term" value="1" >


                        </div> --}}


                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('term_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء فصل</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الإسم  </label>
                        <input type="text" name="name" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم " required>
                    </div>

                        <div class="form-group">
                            <label>  اختر السنة  </label>
                        <br>
                            <select class="form-control a" required name="year_id" >
                                @foreach ($years as $year)
                                    <option value="{{$year->id}}">  {{$year->name}} </option>
                                @endforeach
                            </select>


                        </div>
                        <div class="form-group">
                            <label>  اختر   الفصل  </label>
                        <br>
                            <select class="form-control a" required  name="type">

                                <option value="1"> الفصل الاول  </option>
                                 <option value="2"> الفصل الثاني  </option>

                            </select>


                        </div>
                         <div class="form-group">
                        <label> بداية الفصل   </label>
                        <input type="datetime-local" name="start" class="form-control a" style="direction:rtl"
                            required>
                    </div>
                     <div class="form-group">
                        <label> نهاية الفصل   </label>
                        <input type="datetime-local" name="end" class="form-control a" style="direction:rtl"
                            required>
                    </div>

                        {{-- <div class="form-group">
                           <label > الفصل الحالي   </label>
                        <input type="checkbox" name="current_term" value="1" >


                        </div> --}}


                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول  الفصول</h1>
        </div>
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء فصل </button>
         <button type="button" class="btn mb-1 btn-success" style="font-size: 25px;font-weight: 600;background: #6ABAA3;border-color: #6ABAA3"> <a href="{{route('year')}}"> تحديد السنة  </a>   </button>
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم </th>
                     <th scope="col" class="sort" data-sort="budget">بداية الفصل  </th>
                      <th scope="col" class="sort" data-sort="budget">نهاية الفصل  </th>
                    <th scope="col" class="sort" data-sort="status">السنة</th>
                    <th scope="col" class="sort" data-sort="status"> النوع</th>
                    <th scope="col" class="sort" data-sort="status">  الحالي  </th>
                    <th scope="col" class="sort" data-sort="status"> العمليات   </th>


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


var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getterm') }}",
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
                    return `${full.name}`;
                },orderable : false
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.start != null ?  `<p>${full.start}</p>` : "" }`;
                },orderable : false
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.end != null ?  `<p>${full.end}</p>`: "" }`;
                },orderable : false
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.year.name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    let term_type = `الأول` ;
                    if (full.type == 2){
                        term_type = 'الثاني' ;
                    }
                    return `<p>${term_type}</p>`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    let status = 'لا' ;
                    let style = `style="color:red;"` ;
                    if (full.current_term == 1){
                         style = `style="color:green;"` ;
                        status = 'نعم' ;
                    }
                    return `${full.current_term != null ?  `<p ${style}>${status}</p>` : ""}`;
                },orderable : false
            },


            {
                data: 'id',
                render: function (data, type, full) {
                    return `
                        <a  data-id="${ full.id }" style="font-size:18px !important" data-type="${full.type}" data-year="${full.year.name}" data-yearid="${full.year.id}"  data-current_term="${full.current_term}" data-name="${ full.name }" data-start="${ full.start }" data-end="${ full.end }" data-toggle="modal" data-target="#up_teacher"  class="btn btn-info btn-sm edit" title=" تعديل "  style="font-size:18px !important">
                            <i class="fa fa-eye fa-x" style="color: #eff0f1"></i>
                        </a>

                    `;
                },orderable : false
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
   $('.term1').empty();
     yearid=  $(this).data('yearid');
      year=  $(this).data('year');
    var data = $(this).data('data');
 $('#term_id').val($(this).data('id'));
    $('#term').val($(this).data('name'));
     $('#start').val($(this).data('start'));
      $('#end').val($(this).data('end'));
      if($(this).data('current_term')==1){
          $('#current_term').attr('checked', true);


      }
        if($(this).data('current_term')==0){
          $('#current_term').removeAttr('checked');
      }

      $('.year').val(yearid);
      if($(this).data('type')==1){
            $('.term1').append(` <option value="1"> الفصل الاول  </option>
                                 <option value="2"> الفصل الثاني  </option>`);
      }
       else if ($(this).data('type')==2){
           $('.term1').append(` <option value="2"> الفصل  الثاني  </option>
                                 <option value="1"> الفصل الاول   </option>`);
      }







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
