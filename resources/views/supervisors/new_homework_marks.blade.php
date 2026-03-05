@extends('supervisors.layouts.new_app')
@section('css')
<style>
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
 /* margin-top: -170px;
  margin-bottom: 100px;*/
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "الرقم التسلسلي ";
	color: #094e89;
  }
  table tbody tr td:nth-child(2):before {
    content: "اسم الطالب ";
	color: #094e89;

  }
  table tbody tr td:nth-child(3):before {
    content: "رقم الطالب";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "العلامة ";
	color: #094e89;
  }
  table tbody tr td:nth-child(5):before {
    content: "تحميل الوظيفة ";
    color: #094e89;

  }
  table tbody tr td:nth-child(6):before {
    content: "عمليات التعديل ";
    color: #094e89;

  }

}
.tab1cards {
  display: flex;
  flex-direction: row;
  justify-content: center;
}
:root {
  --background-gradient: linear-gradient(to right top, #f38639  20%, rgb(132, 167, 196))
  --gray: #f38639 ;
  --darkgray: #2c71ad;
}
select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: #f38639;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
  text-align: center;



}
/* Remove IE arrow */
select::-ms-expand {
  display: none;

}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 12em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639 ;



}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #2c71ad ;
  transition: .25s all ease;
  pointer-events: none;


}
/* Transition */
.select:hover::after {
  color: #f38639;



}
</style>
@endsection
@section('content')




<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                     @if($exam1->type==1)
                    <h1 class="mb-0 bread">{{ $exam1->namehomework }}  </h1>
                    @elseif ($exam1->type==2)
                    <h1 class="mb-0 bread">{{ $exam1->name_quize }}  </h1>
                    @endif
            </div>
        </div>
    </div>
</section>
<!-- start new-->


<br>
<br>
<br>
<br>
<span class="subheading"></span>
<div class="tab1cards">
<input  class="homeid"  hidden value="{{ $exam1->id}}">
                {{-- <div class="select" style=" border-radius: 5px; " >
                  <select  class="choice">
                    <option value="0" > اختر الطلاب   </option>

                    <option value="1" > يوجد وظيفة  </option>
                    <option value="2" > لايوجد وظيفة  </option>



                  </select>
                  </div> --}}


     </div>
     <br>


    <br>
<!-- marks of homework -->
      <table class="table1" style="">
        <thead>
            <tr>
                <th>الرقم التسلسلي </th>
                <th>اسم الطالب </th>
                <th> رقم الهاتف </th>
                <th>العلامة  </th>
                {{-- <th>تحميل الوظيفة </th> --}}
                {{-- <th>عمليات التعديل  </th> --}}
            </tr>
        </thead>
        <tbody>

            @foreach ($quize_result as $item)

            @foreach ($item->student as $item2)
            <tr>

                <td>{{ $item2->id }}</td>
                <td>{{ $item2->first_name }} {{ $item2->last_name }} </td>
                <td>{{ $item2->phone }}</td>

                <td class="text-center">

                    @if($item2->exam_result->count()>0)
                    @foreach ($item2->exam_result as $item3)
                    @php
                        $i2=0
                    @endphp
                    @if ($item3->exam_id == $exam_id  )


                    <input style="height: 50px; width:60px;margin: 0 auto"  hidden name="exam_result_id"  value="{{ $item3->id }}" type="text" readonly>

                       <input  hidden style="height: 50px; width:60px;margin: 0 auto" name="mark" value="{{ $item3->result!=null ?$item3->result : '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input1" readonly type="text">

                       @endif


                    @endforeach
                    <input style="height: 50px; width:60px;margin: 0 auto" name="mark" value="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input2"  type="text" readonly>
                    @else
                    <input style="height: 50px; width:60px;margin: 0 auto" name="mark" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text" readonly>
                    @endif
{{--
                     <input style="height: 50px; width:60px"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="{{ $item2->id }}" type="text">
 --}}

                </td>

                {{-- <td>


                    @foreach ($item2->student_lesson_teacher_room_term_exam as $item32)

                    @if ($item32->exam_id == $exam_id  )
                    @if ($item32->type==1)



                        <a href="{{ asset('storage/'.$item32->file) }}"  target="_blank">


                        <img src="{{  asset('teachers/icons8-downloads-2.png') }}" style="height: 50px;width:50px"></a>
                        @endif
                        @else


                        @endif
                        @endforeach


                    </td> --}}
                {{-- <td> <button type="submit" class="btn" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </button> --}}
                    {{-- &nbsp;&nbsp;&nbsp;<a href="#" class="btn btn-primary">حذف </a> --}}
                   </td>

            </tr>
           @endforeach
           @endforeach
        </tbody>
    </table>

<!-- end marks of homework-->
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>


    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

@endsection
@section('js')
<script>
    $(document).ready(function () {
        $.each($('.input1'),function (key,value) {
            var z=value.value;
            $(this).parent().find('.input2').val(z);
        })


        $(document).on('change', '.choice', function () {

var lect=$(this).val();
var home =$('.homeid').val();
var url = "{{ URL::to('SMARMANger/dashboard/teacher/homeworkestudent') }}/" + lect+"/"+home ;
$.ajax({
url: url,
type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);

if(lect==1){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
        if(value.exam_result.length>0){
    $.each(value.exam_result, function (key1, value1) {
        if(value1.result != null){
 var d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
    <input   style="height: 50px; width:60px" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
        }
})
}

else{
    var d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:60px" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
}

        $('.table1 tbody').append(`<tr  id="st">
            <td>${ value.id }</td>
<td>${ value.first_name } ${ value.last_name}</td>
<td>${ value.phone }</td>

<td>${d}</td>
    <td>
<a href="url('storage/'.${value.file}')"  target="_blank">


<img src="{{  asset('teachers/icons8-downloads-2.png') }}" style="height: 30px;width:30px"></a></td>
<td><a href="{{url('dashboard/teacher/questions/edit') }}/${value.id}"   class="btn" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </a>&nbsp;&nbsp;&nbsp;<a href="#"  id="delete_question" class="btn" style="background-color: white; color: rgb(117, 115, 115);" data-question_id="${ value.id }"
data-toggle="modal" data-target="#delete_question">حذف </a></td>
</tr> `)

});

}
else if(lect==2){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
        if(value.exam_result.length>0){
    $.each(value.exam_result, function (key1, value1) {
 var d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
    <input   style="height: 50px; width:60px" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`

})
}

else{
    var d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:60px" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
}

        $('.table1 tbody').append(`<tr  id="st">
            <td>${ value.id }</td>
<td>${ value.first_name } ${ value.last_name}</td>
<td>${ value.phone }</td>

<td>${d}</td>
    <td>
</td>
<td><a href="{{url('dashboard/teacher/questions/edit') }}/${value.id}"   class="btn" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </a>&nbsp;&nbsp;&nbsp;<a href="#"  id="delete_question" class="btn" style="background-color: white; color: rgb(117, 115, 115);" data-question_id="${ value.id }"
data-toggle="modal" data-target="#delete_question">حذف </a></td>
</tr> `)

});

}



},
error: function (xhr) {

}

});})

})

    </script>
@endsection

