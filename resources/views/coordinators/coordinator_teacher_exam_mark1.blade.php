@extends('coordinators.master')
@section('css')
<style>
 /*
 /*table */
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
    content: "اسم الطالب";
	color: #094e89;

  }
  table tbody tr td:nth-child(3):before {
    content: "رقم الطالب ";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "العلامة";
	color: #094e89;
  }
  table tbody tr td:nth-child(5):before {
    content: "عمليات التعديل ";
	color: #094e89;
  }
  table tbody tr td:nth-child(6):before {
    content: "تحميل الملف";
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

<!-- END nav -->


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                   
                    <h1 class="mb-0 bread">{{ $exam1->name }} </h1>
                  
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
      <a  class="breadcrumbs__item is-active">  العلامات </a>
        <a  href="{{ route('coordinator_show_eaxm_room',[$class_id->id,$lesson->id,$room->id,$teacher->id ]) }}" class="breadcrumbs__item ">الامتحانات  </a>
     <a  href="{{ route('coordinator_tacher_room1',[$class_id->id,$lesson->id,$teacher->id]) }}" class="breadcrumbs__item ">{{ $room->name }}   </a>
     <a  href="{{ route('dashboard.coordinator_teacher',[$class_id->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class_id->id ) }}" class="breadcrumbs__item ">{{ $class_id->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->


<br>
<br>
<br>
<br>


<span class="subheading"></span>
<div class="tab1cards">
<input  class="homeid"  hidden value="{{ $exam1->id}}">
                <div class="select" style=" border-radius: 5px; " >
                  <select  class="choice">
                    <option value="0" > اختر الطلاب   </option>

                    <option value="1" > المتقدمين   </option>
                    <option value="2" > غير المتقدمين   </option>



                  </select>
                  </div>

     </div>


     <br>


    <br>

    <br>
    <br>
<!-- marks of homework -->
      <table class="table1" >
        <thead>
            <tr>
                <input hidden value="{{$teacher->id}}" class="teacher_id" >
                <input style="height: 50px; width:60px"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input style="height: 50px; width:60px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                <th>الرقم التسلسلي </th>
                <th>اسم الطالب </th>
   
                <th>العلامة </th>
                <th>عمليات التعديل  </th>
      
               <th>الاوسمة </th>
            </tr>
        </thead>
        <tbody>

                     <input style="height: 50px; width:60px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">

            @foreach ($quize_result as $item)

          
            <tr>
                <form action="{{ route('dashboard.teacher.student_save_mark') }}" method="post" enctype="multipart/form-data">
                    @csrf

                <td>{{ $item->student->id }}</td>
                <td>{{ $item->student->first_name }} {{ $item->student->last_name }} </td>
              

                <td>
              
              


                    <input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="{{ $item->id }}" type="text">

                       <input   style="height: 50px; width:60px" name="mark" value="{{ $item->result!=null ?$item->result : '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input1"  type="text">

                  


                     <input style="height: 50px; width:60px"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input style="height: 50px; width:60px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="{{ $item->student->id }}" type="text">

                </td>
                <td>
         



                <a href="{{ route('correct_exam1',[$exam1->id,$item->student->id,$teacher->id]) }}" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تصحيح الامتحان  </a>&nbsp;&nbsp;&nbsp;



            
                <!--<button type="submit" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تعديل  </button>-->
            </td>

 <td style="height: 86px">
              
                
                 
                @if ($item->exam_id == $exam_id  )
                        @if ($item->medal ==  "1" )
             


                        <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                @elseif($item->medal ==  "2" )
                 <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
                @elseif($item->medal ==  "3" )
                 <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
                @endif

                
                @endif
             
                
                
                
                
                
            </td>
            </tr>
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




})
$(document).on('change', '.choice', function () {

var lect=$(this).val();
var home =$('.homeid').val();
var room_id=$('.room_id').val();
var teacher_id=$('.teacher_id').val()
 var data={
                       
                        "room_id":room_id,

                    }
var url = "{{ URL::to('SMARMANger/dashboard/coordinator/examstudent1') }}/" + lect+"/"+home+"/"+room_id ;
$.ajax({
url: url,
data : data,
type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);

if(lect==1){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
         medal=`<td style="height: 86px"> </td>`
        if(value.exam_result2.length>0){
    $.each(value.exam_result2, function (key1, value1) {
        if(value1.exam_id==home){
            d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
    <input   style="height: 50px; width:60px; margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
            if(value1.medal=="1"){
         medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
            </td>`
  }
  else if(value1.medal=="2"){
        medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
            </td>`
      
  }
  else if(value1.medal=="3"){
        medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
            </td>`
  }

}


})
}


        $('.table1 tbody').append(`


        <tr  id="st">

            <td>${ value.id }</td>
<td>${ value.first_name } ${ value.last_name}</td>

<td>${d}</td>

<td> <a href="{{url('SMARMANger/dashboard/coordinator/correct_exam1') }}/${home}/${value.id}/${teacher_id}" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تصحيح الامتحان  </a>
   </td>
${medal}

</tr> `)

});

}
else if(lect==2){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
          medal=`<td style="height: 86px"> </td>`
          d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:60px; margin: auto;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text">`
        if(value.exam_result2){
            
        if(value.exam_result2.length>0){

    $.each(value.exam_result2, function (key1, value1) {
        if(value1.exam_id==home){
            if(value1.result2 != null){
            d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="${value1.id}" type="text">
    <input   style="height: 50px; width:60px; margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
          if(value1.medal=="1"){
         medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
            </td>`
  }
  else if(value1.medal=="2"){
        medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
            </td>`
      
  }
  else if(value1.medal=="3"){
        medal=` <td style="height: 86px">

                <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
            </td>`
  }
         
         
            }
                   
}
else{
    d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:60px; margin: auto;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `

}
})
}
  $('.table1 tbody').append(`<tr  id="st">

            <td>${ value.id }</td>
<td>${ value.first_name } ${ value.last_name}</td>


<td>${d}</td>

<td> <a href="{{url('SMARMANger/dashboard/coordinator/correct_exam1') }}/${home}/${value.id}/${teacher_id}" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تصحيح الامتحان  </a>

    </td>
  ${medal}

    </tr> `)
}

else{
     d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="" type="text">
    <input   style="height: 50px; width:60px; margin: auto;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
    if(value.id==room_id){
          $.each(value.student, function (key, value2) {
         
           $('.table1 tbody').append(`<tr  id="st">

            <td>${ value2.id }</td>
<td>${ value2.first_name } ${ value2.last_name}</td>

<td>${d}</td>

<td> <a href="{{url('SMARMANger/dashboard/coordinator/correct_exam1') }}/${home}/${value2.id}/${teacher_id}" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تصحيح الامتحان  </a>

    </td>
  ${medal}

    </tr> `)
     })  
    }
  
}

      

});

}

 

},
error: function (xhr) {

}

});})

    </script>
@endsection

