@extends('admin.master')
<head>
    <style>
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {

            background-color: #0f0 !important;
        }
        td{
            text-align: center;
        }
    </style>
</head>

@section('content')

<div class="col" style="direction:rtl;text-align:right">
    <div class="card">

<input type="hidden" name="count" id="count" value="{{ $count }}">
            <!-- Card header -->
        <!--    @if(session()->has('success'))-->
        <!--    <div class="alert alert-success text-center"  style="font-size: 20px">-->
        <!--         {{ session()->get('success') }}-->
        <!--    </div>-->
        <!--@endif-->

@auth('web')



@endauth
        <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
            <li class="nav-item" style="">
              <a class="nav-link mb-sm-3 mb-md-0 active mydiv" id="tabs-text-1-tab" data-toggle="tab" href="#mydiv" role="tab" aria-controls="tabs-text-1" aria-selected="true">الفصل الأول</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0 mydiv2" id="tabs-text-2-tab " data-toggle="tab" href="#tabs-text-2" role="tab" aria-controls="tabs-text-2" aria-selected="false">الفصل التاني</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mb-sm-3 mb-md-0 mydiv3" id="tabs-text-3-tab" data-toggle="tab" href="#tabs-text-3" role="tab" aria-controls="tabs-text-3" aria-selected="false">المحصلة</a>
            </li>
          </ul>

            <div class="card-header border-0" >
              <h2 class="mb-0 text-success term_text">جدول علامات الطلاب</h2>
              <select name="test_type" class="test_type" id="test_type" style="width: 30%;direction: rtl">
                <option style="text-align: right" value="">اختر...</option>
                <option value="1">شفوية</option>
                <option value="2">وظائف و أوراق عمل</option>
                <option value="3">نشاطات و مبادرات</option>
                <option value="4">مذاكرة</option>
                <option value="5">درجة اختبار الفصل </option>
            </select>
            </div>


<div class="table-responsive" id="mydiv" >

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                    <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                    <th scope="col" class="sort" data-sort="budget">شفوية</th>
                    <th scope="col" class="sort" data-sort="budget">وظائف و أوراق عمل</th>
                    <th scope="col" class="sort" data-sort="budget">نشاطات و مبادرات</th>
                    <th scope="col" class="sort" data-sort="budget">مذاكرة</th>
                    <th scope="col" class="sort" data-sort="budget">درجة اختبار الفصل الأول</th>
                    <th scope="col" class="sort" data-sort="budget">العملية</th>


                  </tr>
                </thead>
                <tbody class="list">



@if ($count!=0)

@foreach ($students as $item)

<tr>
<!--<th scope="row">-->
<!-- {{$item->id}}-->
<!-- </th>-->



 <td class="budget" style="direction:rtl;text-align:right">


 {{$item->first_name}}  {{$item->last_name}}


 </td>


     <td class="budget" style="direction:rtl;text-align:right">

     {{$item->phone}}

     </td>

 {{-- <td class="text-right">
     <div class="dropdown">
       <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-ellipsis-v"></i>
       </a>
       <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
       <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
         data-id="{{$value->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
             title="Delete">&#xE872; Delete</i></a>
         <a class="dropdown-item" href="#">Another action</a>
         <a class="dropdown-item" href="#">Something else here</a>
       </div>
     </div>

   </td> --}}
<form  method="post">
@csrf
<input type="hidden" name="term" value="term1">
<input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="student_id" value="{{$item->id}}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
@foreach ($item->student_mark as $item2)

<td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark,true)[$lesson_id]['oral']}}" name="oral" id=""></td>

<td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark,true)[$lesson_id]['homework'] }}" name="homework" id=""></td>
<td><input type="text" style="width: 40px" value="{{json_decode($item2->mark,true)[$lesson_id]['activities']}}" name="activities" id=""></td>
<td><input type="text" style="width: 40px" value="{{json_decode($item2->mark,true)[$lesson_id]['quize']}}" name="quize" id=""></td>
<td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark,true)[$lesson_id]['exam'] }}" name="exam" id=""></td>




@endforeach


<td><a class="btn btn-success btn-sm one">حفظ</a></td>




</form>


 </tr>
@endforeach




</tbody>
</table>

</div>



{{-- ------------------------------------------------------------- --}}




<div class="table-responsive" id="mydiv2" style="direction:rtl;text-align:right">


  <table class="table align-items-center table-flush">
  <thead class="thead-light">
   <tr>
     <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
     <th scope="col" class="sort" data-sort="budget"> الاسم</th>
     <th scope="col" class="sort" data-sort="budget">الهاتف</th>
     <th scope="col" class="sort" data-sort="budget">شفوية</th>
     <th scope="col" class="sort" data-sort="budget">وظائف و أوراق عمل</th>
     <th scope="col" class="sort" data-sort="budget">نشاطات و مبادرات</th>
     <th scope="col" class="sort" data-sort="budget">مذاكرة</th>
     <th scope="col" class="sort" data-sort="budget">درجة اختبار الفصل الأول</th>
     <th scope="col" class="sort" data-sort="budget">العملية</th>


   </tr>
  </thead>
  <tbody class="list" style="direction:rtl;text-align:right">




     @foreach ($students as $item)

    <tr style="direction:rtl;text-align:right">
    <!--<th scope="row">-->
    <!-- {{$item->id}}-->
    <!-- </th>-->



     <td class="budget" style="direction:rtl;text-align:right">


     {{$item->first_name}}  {{$item->last_name}}


     </td>


         <td class="budget" style="direction:rtl;text-align:right">

         {{$item->phone}}

         </td>

     {{-- <td class="text-right">
         <div class="dropdown">
           <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-ellipsis-v"></i>
           </a>
           <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
           <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
             data-id="{{$value->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                 title="Delete">&#xE872; Delete</i></a>
             <a class="dropdown-item" href="#">Another action</a>
             <a class="dropdown-item" href="#">Something else here</a>
           </div>
         </div>

       </td> --}}
  <form method="post">
  @csrf
  <input type="hidden" name="term" value="term2">
  <input type="hidden" name="room_id" value="{{ $room_id }}">
<input type="hidden" name="student_id" value="{{$item->id}}">
<input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  @foreach ($item->student_mark as $item2)

  <td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['oral']}}" name="oral" id=""></td>

  <td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['homework'] }}" name="homework" id=""></td>
  <td><input type="text" style="width: 40px" value="{{json_decode($item2->mark2,true)[$lesson_id]['activities']}}" name="activities" id=""></td>
  <td><input type="text" style="width: 40px" value="{{json_decode($item2->mark2,true)[$lesson_id]['quize']}}" name="quize" id=""></td>
  <td><input type="text" style="width: 40px" value="{{ json_decode($item2->mark2,true)[$lesson_id]['exam'] }}" name="exam" id=""></td>




  @endforeach


  <td><a class="btn btn-success btn-sm one">حفظ</a></td>




  </form>


     </tr>
    @endforeach


  @endif






                    </tbody>
                  </table>

                </div>


                {{-- ================================================================= --}}






                <div class="table-responsive" id="mydiv3" >

                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                        <th scope="col" class="sort" data-sort="budget">
                            درجة اعمال
                        </th>
                        <th scope="col" class="sort" data-sort="budget">امتحان</th>
                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> محصلة الفصل الأول</th>
                        <th scope="col" class="sort" data-sort="budget">
                          درجة اعمال
                      </th>
                      <th scope="col" class="sort" data-sort="budget">امتحان</th>
                      <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> محصلة الفصل التاني</th>

                      <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع درجات الفصلين</th>

                      <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> متوسط درجات الفصلين</th>

                        {{-- <th scope="col" class="sort" data-sort="budget">Action</th> --}}


                      </tr>
                    </thead>
                    <tbody class="list">




                        @foreach ($students as $item)

                       <tr>
                       <!--<th scope="row">-->
                       <!-- {{$item->id}}-->
                       <!-- </th>-->



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

                          <td class="budget" style="font-size: 16px; font-weight: bold;  text-align: center">

                              @if (isset(json_decode($item2->result,true)[$lesson_id]['year_result'] ))
                              {{ json_decode($item2->result,true)[$lesson_id]['year_result'] }}

                              @endif
                          </td>

                          <td class="budget" style="font-size: 16px; font-weight: bold;  text-align: center">
                              @if (isset(json_decode($item2->result,true)[$lesson_id]['year_result'] ))

                              {{ json_decode($item2->result,true)[$lesson_id]['year_result'] / 2}}
                              @endif

                          </td>
                              @endforeach

                        </tr>
                       @endforeach








                    </tbody>
                  </table>

                </div>





                <div class="modal fade deleteEmployeeModal">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <form id="form_delete" method="POST">
                              @csrf
                              @method('delete')
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

      </div>
  </div>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                  <script>
  $(document).on('click','.one',function(e){

e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('student_mark') }}",
    enctype:'multipart/form-data',
    data: $(this).parent().parent().find('form:first').serialize(),
    success:function(data){
console.log(data);
swal({
  title: "حسنا",
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
                      $(document).ready(function () {
                          $('#mydiv2').hide();
                          $('#mydiv3').hide();

                      $('.delete').on('click', function () {
                          var id = $(this).data('id');
                          var url = "{{URL::to('SMARMANger/admin/students')}}";
                          $('#form_delete').attr("action", url);


                      });

                      $('.mydiv2').on('click', function () {
                          $('#mydiv2').show();

                          $('#mydiv').hide();
                          $('#mydiv3').hide();


                      });

                      $('.mydiv').on('click', function () {
                          $('#mydiv').show();

                          $('#mydiv2').hide();
                          $('#mydiv3').hide();


                      });

                      $('.mydiv3').on('click', function () {
                          $('#mydiv3').show();

                          $('#mydiv').hide();

                          $('#mydiv2').hide();


                      });


                      $('.test_type').on('change', function () {




  $('#mydiv').empty();
  if($(this).val()==1){

    var type="";
      type+=`
  @if ($count!=0)

      <form action="{{ route('student_mark' ) }}" method="post">
      @csrf
  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">شفوية</th>




                    </tr>
                  </thead>
                  <tbody class="list">




                      @foreach ($students as $item)

                     <tr>




                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>


      <form action="{{ route('student_mark')}}" method="post">
      @csrf
          @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['oral'] }}" name="oral[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach





                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>
              </form>
              @endif


  `;

  }else if($(this).val()==2){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">وظائف و أوراق عمل</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">




                      @foreach ($students as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}

                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['homework'] }}" name="homework[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach





                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>

              </form>
              @endif

  `;

  }else if($(this).val()==3){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">نشاطات و مبادرات</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">




                      @foreach ($students as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}


                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['activities'] }}" name="activities[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach





                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>
              </form>

              @endif
  `;}
  else if($(this).val()==4){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark' ) }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">مذاكرة</th>



                      {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

                    </tr>
                  </thead>
                  <tbody class="list">




                      @foreach ($students as $item)

                     <tr>

                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>

                      {{-- <td class="text-right">
                          <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
                              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
                                  title="Delete">&#xE872; Delete</i></a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                          </div>

                        </td> --}}



                        @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['quize'] }}" name="quize[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach





                  </tbody>
                </table>

                <button class="btn btn-success">Click</button>
              </form>

              @endif

  `;}

  else if($(this).val()==5){
      type="";

      type+=`
      @if ($count!=0)

      <form action="{{ route('student_mark') }}" method="post">
                          @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="budget"> الاسم</th>
                      <th scope="col" class="sort" data-sort="budget">الهاتف</th>
                      <th scope="col" class="sort" data-sort="budget">درجة اختبار الفصل الأول	</th>




                    </tr>
                  </thead>
                  <tbody class="list">





                      @foreach ($students as $item)

                     <tr>


                      <td class="budget">


                      {{$item->first_name}}  {{$item->last_name}}


                      </td>


                          <td class="budget">

                          {{$item->phone}}

                          </td>




                          @foreach( $item->student_mark as $key1=>$value1)
          @foreach (json_decode($value1['mark'],true) as $key2=>$value2)
          @if ($key2==$lesson_id)
          <td><input type="text" style="width: 40px" value=" {{ $value2['exam'] }}" name="exam[]" id=""></td>

          @endif

          @endforeach
          @endforeach
      <input type="hidden" name="student_id[]" value="{{ $item->id }}">
      <input type="hidden" name="room_id" value="{{ $room->id }}">
      <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
      <input type="hidden" name="term" value="term1">





                      </tr>
                     @endforeach





                  </tbody>
                </table>
                <button class="btn btn-success">Click</button>

              </form>
              @endif

  `;

  }

  $('#mydiv').append(type);


  });












  // ==================================================================================================













  $('.test_type').on('change', function () {
  $('#mydiv2').empty();
  if($(this).val()==1){
  var type="";
  type+=`
  @if ($count!=0)

  <form action="{{ route('student_mark') }}" method="post">
  @csrf
  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
  <thead class="thead-light">
  <tr>
  <th scope="col" class="sort" data-sort="budget"> الاسم</th>
  <th scope="col" class="sort" data-sort="budget">الهاتف</th>
  <th scope="col" class="sort" data-sort="budget">شفوية</th>



  {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

  </tr>
  </thead>
  <tbody class="list">




  @foreach ($students as $item)

  <tr>


  <td class="budget">


  {{$item->first_name}}  {{$item->last_name}}


  </td>


      <td class="budget">

      {{$item->phone}}

      </td>

  {{-- <td class="text-right">
      <div class="dropdown">
        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
          data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
              title="Delete">&#xE872; Delete</i></a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </div>

    </td> --}}

  <form action="{{ route('student_mark') }}" method="post">
  @csrf
  @foreach( $item->student_mark as $key1=>$value1)
  @foreach (json_decode($value1['mark2'],true) as $key2=>$value2)
  @if ($key2==$lesson_id)
  <td><input type="text" style="width: 40px" value=" {{ $value2['oral'] }}" name="oral[]" id=""></td>

  @endif

  @endforeach
  @endforeach
  <input type="hidden" name="student_id[]" value="{{ $item->id }}">
  <input type="hidden" name="room_id" value="{{ $room->id }}">
  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  <input type="hidden" name="term" value="term2">





  </tr>
  @endforeach





  </tbody>
  </table>
  <button class="btn btn-success">Click</button>
  </form>
  @endif

  `;

  }else if($(this).val()==2){
  type="";

  type+=`
  @if ($count!=0)

  <form action="{{ route('student_mark' ) }}" method="post">
  @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
  <thead class="thead-light">
  <tr>
  <th scope="col" class="sort" data-sort="budget"> الاسم</th>
  <th scope="col" class="sort" data-sort="budget">الهاتف</th>
  <th scope="col" class="sort" data-sort="budget">وظائف و أوراق عمل</th>



  {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

  </tr>
  </thead>
  <tbody class="list">




  @foreach ($students as $item)

  <tr>

  <td class="budget">


  {{$item->first_name}}  {{$item->last_name}}


  </td>


      <td class="budget">

      {{$item->phone}}

      </td>

  {{-- <td class="text-right">
      <div class="dropdown">
        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
          data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
              title="Delete">&#xE872; Delete</i></a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </div>

    </td> --}}

    @foreach( $item->student_mark as $key1=>$value1)
  @foreach (json_decode($value1['mark2'],true) as $key2=>$value2)
  @if ($key2==$lesson_id)
  <td><input type="text" style="width: 40px" value=" {{ $value2['homework'] }}" name="homework[]" id=""></td>

  @endif

  @endforeach
  @endforeach
  <input type="hidden" name="student_id[]" value="{{ $item->id }}">
  <input type="hidden" name="room_id" value="{{ $room->id }}">
  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  <input type="hidden" name="term" value="term2">





  </tr>
  @endforeach





  </tbody>
  </table>
  <button class="btn btn-success">Click</button>

  </form>

  @endif
  `;

  }else if($(this).val()==3){
  type="";

  type+=`
  @if ($count!=0)

  <form action="{{ route('student_mark' ) }}" method="post">
  @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
  <thead class="thead-light">
  <tr>
  <th scope="col" class="sort" data-sort="budget"> الاسم</th>
  <th scope="col" class="sort" data-sort="budget">الهاتف</th>
  <th scope="col" class="sort" data-sort="budget">نشاطات و مبادرات</th>



  {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

  </tr>
  </thead>
  <tbody class="list">




  @foreach ($students as $item)

  <tr>


  <td class="budget">


  {{$item->first_name}}  {{$item->last_name}}


  </td>


      <td class="budget">

      {{$item->phone}}

      </td>

  {{-- <td class="text-right">
      <div class="dropdown">
        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
          data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
              title="Delete">&#xE872; Delete</i></a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </div>

    </td> --}}


    @foreach( $item->student_mark as $key1=>$value1)
  @foreach (json_decode($value1['mark2'],true) as $key2=>$value2)
  @if ($key2==$lesson_id)
  <td><input type="text" style="width: 40px" value=" {{ $value2['activities'] }}" name="activities[]" id=""></td>

  @endif

  @endforeach
  @endforeach
  <input type="hidden" name="student_id[]" value="{{ $item->id }}">
  <input type="hidden" name="room_id" value="{{ $room->id }}">
  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  <input type="hidden" name="term" value="term2">





  </tr>
  @endforeach





  </tbody>
  </table>
  <button class="btn btn-success">Click</button>
  </form>
  @endif

  `;
  }
  else if($(this).val()==4){
  type="";

  type+=`
  @if ($count!=0)

  <form action="{{ route('student_mark') }}" method="post">
  @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
  <thead class="thead-light">
  <tr>
  <th scope="col" class="sort" data-sort="budget"> الاسم</th>
  <th scope="col" class="sort" data-sort="budget">الهاتف</th>
  <th scope="col" class="sort" data-sort="budget">مذاكرة</th>



  {{-- <th scope="col" class="sort" data-sort="completion">Action</th> --}}

  </tr>
  </thead>
  <tbody class="list" style="direction:rtl;text-align:right;">




  @foreach ($students as $item)

  <tr style="direction:rtl;text-align:right;">

  <td class="budget">


  {{$item->first_name}}  {{$item->last_name}}


  </td>


      <td class="budget">

      {{$item->phone}}

      </td>

  {{-- <td class="text-right">
      <div class="dropdown">
        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"
          data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"
              title="Delete">&#xE872; Delete</i></a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </div>

    </td> --}}



    @foreach( $item->student_mark as $key1=>$value1)
  @foreach (json_decode($value1['mark2'],true) as $key2=>$value2)
  @if ($key2==$lesson_id)
  <td><input type="text" style="width: 40px" value=" {{ $value2['quize'] }}" name="quize[]" id=""></td>

  @endif

  @endforeach
  @endforeach
  <input type="hidden" name="student_id[]" value="{{ $item->id }}">
  <input type="hidden" name="room_id" value="{{ $room->id }}">
  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  <input type="hidden" name="term" value="term2">





  </tr>
  @endforeach





  </tbody>
  </table>

  <button class="btn btn-success">Click</button>
  </form>
  @endif
  `;}

  else if($(this).val()==5){
  type="";

  type+=`
  @if ($count!=0)

  <form action="{{ route('student_mark' ) }}" method="post">
      @csrf

  <table class="table align-items-center table-flush" style="direction:rtl;text-align:right;">
  <thead class="thead-light">
  <tr>
  <th scope="col" class="sort" data-sort="budget"> الاسم</th>
  <th scope="col" class="sort" data-sort="budget">الهاتف</th>
  <th scope="col" class="sort" data-sort="budget">درجة اختبار الفصل الأول	</th>




  </tr>
  </thead>
  <tbody class="list">





  @foreach ($students as $item)

  <tr>

  <td class="budget">


  {{$item->first_name}}  {{$item->last_name}}


  </td>


      <td class="budget">

      {{$item->phone}}

      </td>




      @foreach( $item->student_mark as $key1=>$value1)
  @foreach (json_decode($value1['mark2'],true) as $key2=>$value2)
  @if ($key2==$lesson_id)
  <td><input type="text" style="width: 40px" value=" {{ $value2['exam'] }}" name="exam[]" id=""></td>

  @endif

  @endforeach
  @endforeach
  <input type="hidden" name="student_id[]" value="{{ $item->id }}">
  <input type="hidden" name="room_id" value="{{ $room->id }}">
  <input type="hidden" name="lesson_id" value="{{ $lesson_id }}">
  <input type="hidden" name="term" value="term2">





  </tr>
  @endforeach





  </tbody>
  </table>
  <button class="btn btn-success">Click</button>

  </form>
  @endif
  `;

  }

  $('#mydiv2').append(type);









  });


                      });
                      </script>






                    @endsection
