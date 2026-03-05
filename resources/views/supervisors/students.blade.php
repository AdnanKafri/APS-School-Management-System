@extends('supervisors.layouts.app')

@section('email')
{{ $supervisor->email }}
@endsection

@section('image')
{{ asset('storage/'.$supervisor->image) }}
@endsection

@section('name')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}

@endsection
@section('my_info')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}
@endsection


@section('classes')
{{ route('dashboard.supervisor.classes',$supervisor->id) }}
@endsection



@section('classes2')
{{ route('dashboard.supervisor.classes2',$supervisor->id) }}
@endsection

@section('messages')
{{ route('dashboard.supervisor.teachers',$supervisor->id) }}
@endsection

<head>
    <style>
        a{
        color:#019983 !important;
    }
            a:hover{
            color: #337AB7 !important;
            transition: all 1s ease;
            text-decoration: none !important;
        }


    </style>
</head>

@section('content')



<div class="block-header">

    <select name="test_type" class="test_type" id="test_type" style="width: 200%; height: 35px; margin-left: 12px;direction: rtl">

        <option style="text-align: right" value="0">اختر...</option>
        <option value="1">شفوية</option>
        <option value="2">وظائف و أوراق عمل</option>
        <option value="3">نشاطات و مبادرات</option>
        <option value="4">مذاكرة</option>
        <option value="5">درجة اختبار الفصل </option>    </select>


</div>




 <!-- Select -->



 <div class="row">
     <div class="col-md-4">

     </div>


 <div class="col-md-6">

    <ul class="nav nav-tabs tab-nav-right" role="tablist" style="text-align: center">
        <li role="presentation"><a href="mydiv" class="mydiv" data-toggle="tab">الفصل الأول</a></li>
          <li role="presentation"><a href="mydiv2"  class="mydiv2" data-toggle="tab">الفصل الثاني</a></li>
          <li role="presentation"><a href="mydiv3"  class="mydiv3" data-toggle="tab">المحصلة</a></li>

      </ul>

</div>

<div class="col-md-2">

</div>
 </div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="mydiv"  style="direction: rtl">

    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
              درجات الفصل الأول
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: right"> الاسم</th>
                        <th style="text-align: right">الهاتف</th>
                        <th style="text-align: right">الشفهي</th>
                        <th style="text-align: right">الوظائف</th>
                        <th style="text-align: right">النشاط</th>
                        <th style="text-align: right">المذاكرة</th>
                        <th style="text-align: right">الامتحان الفصلي</th>
                        {{-- <th>Action</th> --}}

                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($students as $item)
                    <tr>




                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td>{{ $item->phone }}</td>



                    <form  method="post">
                        @csrf
                        <input type="hidden" name="term" value="term1">
                            <input type="hidden" name="room_id" value="{{ $room_id }}">
                        <input type="hidden" name="student_id" value="{{$item->id}}">
                        <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                        @foreach ($item->student_mark as $item2)

                        <td>{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}</td>

                        <td>{{ json_decode($item2->mark,true)[$lesson_id]['homework'] }}</td>
                        <td>{{json_decode($item2->mark,true)[$lesson_id]['activities']}}</td>
                        <td>{{json_decode($item2->mark,true)[$lesson_id]['quize']}}</td>
                        <td>{{ json_decode($item2->mark,true)[$lesson_id]['exam'] }}</td>


                        {{-- <td><a class="btn btn-success btn-sm one">ارسال</a></td> --}}
                        @endforeach

                    </form>


                    </tr>

                    @endforeach




                </tbody>
            </table>
        </div>
    </div>
</div>









<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="mydiv2" style="direction: rtl">





    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
              درجات الفصل الثاني
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th style="text-align: right"> الاسم</th>
                        <th style="text-align: right">الهاتف</th>
                        <th style="text-align: right">الشفهي</th>
                        <th style="text-align: right">الوظائف</th>
                        <th style="text-align: right">النشاط</th>
                        <th style="text-align: right">المذاكرة</th>
                        <th style="text-align: right">الامتحان الفصلي</th>
                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($students as $item)
                    <tr>

                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td>{{ $item->phone }}</td>



                    <form method="post">
                        @csrf
                        <input type="hidden" name="term" value="term2">
                        <input type="hidden" name="room_id" value="{{ $room_id }}">
                        <input type="hidden" name="student_id" value="{{$item->id}}">
                        <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
                        @foreach ($item->student_mark as $item2)

                        <td>{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}</td>

                        <td>{{ json_decode($item2->mark2,true)[$lesson_id]['homework'] }}</td>
                        <td>{{json_decode($item2->mark2,true)[$lesson_id]['activities']}}</td>
                        <td>{{json_decode($item2->mark2,true)[$lesson_id]['quize']}}</td>
                        <td>{{ json_decode($item2->mark2,true)[$lesson_id]['exam'] }}</td>






                        {{-- <td><a class="btn btn-success btn-sm one">ارسال</a></td> --}}
                        @endforeach

                    </form>


                    </tr>

                    @endforeach




                </tbody>
            </table>
        </div>
    </div>
</div>













<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="mydiv3" style="direction: rtl">





    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
                جدول المحصلات

</h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        {{-- <th style="text-align:right">الرقم التسلسلي</th> --}}
                        <th style="text-align:right"> الاسم</th>
                        <th style="text-align:right">درجة أعمال</th>
                        <th style="text-align:right">امتحان</th>
                        <th style="font-size: 16px; text-align:right">محصلة الفصل الأول</th>

                        <th style="text-align:right">درجة أعمال</th>
                        <th style="text-align:right">امتحان</th>
                        <th style="text-align:right">محصلة الفصل الثاني</th>



                        <th>مجموع درجات الفصلين</th>
                        <th>متوسط درجات الفصلين</th>
                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>


                    @foreach ($students as $item)

                    <tr>
                    {{-- <th scope="row">
                     {{$item->id}}
                     </th> --}}



                     <td class="budget">


                     {{$item->first_name}}  {{$item->last_name}}


                     </td>




                           @foreach ($item->student_mark as $item2)
                           <td class="budget">

                           {{ json_decode($item2->result1,true)[$lesson_id]['term1_quizes'] }}
                              </td>
                              <td class="budget">
                           {{ json_decode($item2->result1,true)[$lesson_id]['term1_exam'] }}
                       </td>
                       <td class="budget" style="font-size: 16px; font-weight: bold;  text-align: center">

                           {{ json_decode($item2->result1,true)[$lesson_id]['term1_result'] }}
                       </td>

                           @endforeach


                           @foreach ($item->student_mark as $item2)
                           <td>
                               {{ json_decode($item2->result2,true)[$lesson_id]['term2_quizes'] }}

                           </td>

                           <td>
                               {{ json_decode($item2->result2,true)[$lesson_id]['term2_exam'] }}

                           </td>

                           <td style="font-size: 16px; font-weight: bold; text-align: center">
                               {{ json_decode($item2->result2,true)[$lesson_id]['term2_result'] }}

                           </td>

                           @endforeach

                           @foreach ($item->student_mark as $item2)
                           <td>
                               {{ json_decode($item2->result,true)[$lesson_id]['year_result'] }}

                           </td>

                           <td>
                               {{ json_decode($item2->result,true)[$lesson_id]['year_result'] /2 }}

                           </td>


                           @endforeach


                     </tr>
                    @endforeach




                </tbody>
            </table>
        </div>
    </div>
</div>





@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

$(document).on('click','.one',function(e){

e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('admin.teacher_student_mark') }}",
    enctype:'multipart/form-data',
    data: $(this).parent().parent().find('form:first').serialize(),
    success:function(data){
console.log(data);

swal({
  title: "Good job!",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

});




    });

$(document).ready(function(){

$('alert-warning').fadeOut(6000);
$('.dropdown-toggle').remove();
$('#mydiv2').hide();
    $('#mydiv3').hide();
    $('.mydiv2').on('click', function () {
                        $('#mydiv2').show();

                        $('#mydiv').hide();
                        $('#mydiv3').hide();

                        $('.test_type').show();

                    });

                    $('.mydiv').on('click', function () {
                        $('#mydiv').show();

                        $('#mydiv2').hide();
                        $('#mydiv3').hide();
                        $('.test_type').show();



                    });

                    $('.mydiv3').on('click', function () {
                        $('#mydiv3').show();

                        $('#mydiv').hide();

                        $('#mydiv2').hide();
$('.test_type').hide();

                    });
$(document).on('change','.test_type',function(){



    var type="";
    if($(this).val()==1){

        type+=`

<div class="card">
<div class="header">
  <h2 style="font-weight: bold; font-size: 24px">
    درجات الفصل الأول
  </h2>

</div>
<div class="body table-responsive">
    <form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
  <table class="table table-bordered">
      <thead>
          <tr>
              <th> الاسم</th>
              <th>الهاتف</th>
              <th>الشفهي</th>


              {{-- --------------------------- --}}
          </tr>
      </thead>
      <tbody>



          @foreach ($students as $item)
          <tr>

          <td>{{ $item->first_name }} {{ $item->last_name }}</td>
          <td>{{ $item->phone }}</td>



              @foreach ($item->student_mark as $item2)

              <td>{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}</td>

              <input type="hidden" name="term" value="term1">
       <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
              @endforeach



          </tr>



          @endforeach

</tbody>

  </table>


    </form>
     </div>
</div>`;

$('#mydiv').empty();
$('#mydiv').append(type);
}



else if ($(this).val()==2) {
    type+=`

<div class="card">
<div class="header">
  <h2 style="font-weight: bold; font-size: 24px">
    درجات الفصل الأول
  </h2>

</div>
<div class="body table-responsive">
    <form  action="{{ route('admin.teacher_student_mark' ) }}" method="post">

@csrf
  <table class="table table-bordered">
      <thead>
          <tr>
              <th> الاسم</th>
              <th>الهاتف</th>
              <th>وظائف و أوراق عمل</th>


              {{-- --------------------------- --}}
          </tr>
      </thead>
      <tbody>



          @foreach ($students as $item)
          <tr>

          <td>{{ $item->first_name }} {{ $item->last_name }}</td>
          <td>{{ $item->phone }}</td>



              @foreach ($item->student_mark as $item2)

              <td>{{ json_decode($item2->mark,true)[$lesson_id]['homework']}}</td>

              <input type="hidden" name="term" value="term1">
       <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
              @endforeach



          </tr>



          @endforeach

</tbody>

  </table>


    </form>
     </div>
</div>`;

$('#mydiv').empty();
$('#mydiv').append(type);
}


else if ($(this).val()==3) {
    type+=`

<div class="card">
<div class="header">
  <h2 style=" font-weight: bold; font-size: 24px">
    درجات الفصل الأول
  </h2>

</div>
<div class="body table-responsive">
    <form  action="{{ route('admin.teacher_student_mark' ) }}" method="post">

@csrf
  <table class="table table-bordered">
      <thead>
          <tr>
              <th> الاسم</th>
              <th>الهاتف</th>
              <th> نشاطات و مبادرات </th>


              {{-- --------------------------- --}}
          </tr>
      </thead>
      <tbody>



          @foreach ($students as $item)
          <tr>

          <td>{{ $item->first_name }} {{ $item->last_name }}</td>
          <td>{{ $item->phone }}</td>



              @foreach ($item->student_mark as $item2)

              <td>{{ json_decode($item2->mark,true)[$lesson_id]['activities']}}</td>

              <input type="hidden" name="term" value="term1">
       <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
              @endforeach



          </tr>



          @endforeach

</tbody>

  </table>


    </form>
     </div>
</div>`;

$('#mydiv').empty();
$('#mydiv').append(type);
}

else if ($(this).val()==4) {
    type+=`

<div class="card">
<div class="header">
  <h2 style="font-weight: bold; font-size: 24px">
    درجات الفصل الأول
  </h2>

</div>
<div class="body table-responsive">
    <form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
  <table class="table table-bordered">
      <thead>
          <tr>
              <th> الاسم</th>
              <th>الهاتف</th>
              <th>مذاكرة</th>


              {{-- --------------------------- --}}
          </tr>
      </thead>
      <tbody>



          @foreach ($students as $item)
          <tr>

          <td>{{ $item->first_name }} {{ $item->last_name }}</td>
          <td>{{ $item->phone }}</td>



              @foreach ($item->student_mark as $item2)

              <td>{{ json_decode($item2->mark,true)[$lesson_id]['quize']}}</td>

              <input type="hidden" name="term" value="term1">
       <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
              @endforeach



          </tr>



          @endforeach

</tbody>

  </table>


    </form>
     </div>
</div>`;

$('#mydiv').empty();
$('#mydiv').append(type);
}



else if ($(this).val()==5) {
    type+=`

<div class="card">
<div class="header">
  <h2 style="font-weight: bold; font-size: 24px">
    درجات الفصل الأول
  </h2>

</div>
<div class="body table-responsive">
    <form  action="{{ route('admin.teacher_student_mark' ) }}" method="post">

@csrf
  <table class="table table-bordered">
      <thead>
          <tr>
              <th> الاسم</th>
              <th>الهاتف</th>
              <th>درجة اختبار الفصل </th>


              {{-- --------------------------- --}}
          </tr>
      </thead>
      <tbody>



          @foreach ($students as $item)
          <tr>

          <td>{{ $item->first_name }} {{ $item->last_name }}</td>
          <td>{{ $item->phone }}</td>



              @foreach ($item->student_mark as $item2)

              <td>{{ json_decode($item2->mark,true)[$lesson_id]['exam']}}</td>

              <input type="hidden" name="term" value="term1">
       <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
    <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
              @endforeach



          </tr>



          @endforeach

</tbody>

  </table>


    </form>
     </div>
</div>`;

$('#mydiv').empty();
$('#mydiv').append(type);
}



});





// ========================================================================================




$(document).on('change','.test_type',function(){



var type="";
if($(this).val()==1){

    type+=`

<div class="card">
<div class="header">
<h2 style="font-weight: bold; font-size: 24px">
درجات الفصل الثاني
</h2>

</div>
<div class="body table-responsive">
<form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
<table class="table table-bordered">
  <thead>
      <tr>
          <th> الاسم</th>
          <th>الهاتف</th>
          <th>الشفهي</th>


          {{-- --------------------------- --}}
      </tr>
  </thead>
  <tbody>



      @foreach ($students as $item)
      <tr>




      <td>{{ $item->first_name }} {{ $item->last_name }}</td>
      <td>{{ $item->phone }}</td>



          @foreach ($item->student_mark as $item2)

          <td>{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}</td>

          <input type="hidden" name="term" value="term2">
   <input type="hidden" name="student_id[]" value="{{ $item->id }}">
<input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
          @endforeach



      </tr>



      @endforeach

</tbody>

</table>


</form>
 </div>
</div>`;

$('#mydiv2').empty();
$('#mydiv2').append(type);
}



else if ($(this).val()==2) {
type+=`

<div class="card">
<div class="header">
<h2 style=" font-weight: bold; font-size: 24px">
درجات الفصل الثاني
</h2>

</div>
<div class="body table-responsive">
<form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
<table class="table table-bordered">
  <thead>
      <tr>
          <th> الاسم</th>
          <th>الهاتف</th>
          <th>وظائف و أوراق عمل</th>


          {{-- --------------------------- --}}
      </tr>
  </thead>
  <tbody>



      @foreach ($students as $item)
      <tr>




      <td>{{ $item->first_name }} {{ $item->last_name }}</td>
      <td>{{ $item->phone }}</td>



          @foreach ($item->student_mark as $item2)

          <td>{{ json_decode($item2->mark2,true)[$lesson_id]['homework']}}</td>

          <input type="hidden" name="term" value="term2">
   <input type="hidden" name="student_id[]" value="{{ $item->id }}">
<input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
          @endforeach



      </tr>



      @endforeach

</tbody>

</table>


</form>
 </div>
</div>`;

$('#mydiv2').empty();
$('#mydiv2').append(type);
}


else if ($(this).val()==3) {
type+=`

<div class="card">
<div class="header">
<h2 style=" font-weight: bold; font-size: 24px">
درجات الفصل الثاني
</h2>

</div>
<div class="body table-responsive">
<form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
<table class="table table-bordered">
  <thead>
      <tr>
          <th> الاسم</th>
          <th>الهاتف</th>
          <th> نشاطات و مبادرات </th>


          {{-- --------------------------- --}}
      </tr>
  </thead>
  <tbody>



      @foreach ($students as $item)
      <tr>

      <td>{{ $item->first_name }} {{ $item->last_name }}</td>
      <td>{{ $item->phone }}</td>



          @foreach ($item->student_mark as $item2)

          <td>{{ json_decode($item2->mark2,true)[$lesson_id]['activities'] }}</td>

          <input type="hidden" name="term" value="term2">
            <input type="hidden" name="student_id[]" value="{{ $item->id }}">
    <input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
          @endforeach



      </tr>



      @endforeach

</tbody>

</table>


</form>
 </div>
</div>`;

$('#mydiv2').empty();
$('#mydiv2').append(type);
}

else if ($(this).val()==4) {
type+=`

<div class="card">
<div class="header">
<h2 style="font-weight: bold; font-size: 24px">
درجات الفصل الثاني
</h2>

</div>
<div class="body table-responsive">
<form  action="{{ route('admin.teacher_student_mark' ) }}" method="post">

@csrf
<table class="table table-bordered">
  <thead>
      <tr>
          <th> الاسم</th>
          <th>الهاتف</th>
          <th>مذاكرة</th>


          {{-- --------------------------- --}}
      </tr>
  </thead>
  <tbody>



      @foreach ($students as $item)
      <tr>

      <td>{{ $item->first_name }} {{ $item->last_name }}</td>
      <td>{{ $item->phone }}</td>



          @foreach ($item->student_mark as $item2)

          <td>{{ json_decode($item2->mark2,true)[$lesson_id]['quize'] }}</td>

          <input type="hidden" name="term" value="term2">
   <input type="hidden" name="student_id[]" value="{{ $item->id }}">
<input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
          @endforeach



      </tr>



      @endforeach

</tbody>

</table>


</form>
 </div>
</div>`;

$('#mydiv2').empty();
$('#mydiv2').append(type);
}



else if ($(this).val()==5) {
type+=`

<div class="card">
<div class="header">
<h2 style="font-weight: bold; font-size: 24px">
درجات الفصل الثاني
</h2>

</div>
<div class="body table-responsive">
<form  action="{{ route('admin.teacher_student_mark') }}" method="post">

@csrf
<table class="table table-bordered">
  <thead>
      <tr>
          <th> الاسم</th>
          <th>الهاتف</th>
          <th>درجة اختبار الفصل </th>


          {{-- --------------------------- --}}
      </tr>
  </thead>
  <tbody>



      @foreach ($students as $item)
      <tr>

      <td>{{ $item->first_name }} {{ $item->last_name }}</td>
      <td>{{ $item->phone }}</td>



          @foreach ($item->student_mark as $item2)

          <td>{{ json_decode($item2->mark2,true)[$lesson_id]['exam']}}</td>

          <input type="hidden" name="term" value="term2">
   <input type="hidden" name="student_id[]" value="{{ $item->id }}">
<input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
          @endforeach



      </tr>



      @endforeach

</tbody>

</table>


</form>
 </div>
</div>`;

$('#mydiv2').empty();
$('#mydiv2').append(type);
}



});









});
</script>

