@extends('coordinators.master')
@section('css')
<style>
   :root {
  --rad: 0.6rem;
  --dur: 0.3s;
  --color-dark: white;
  --color-light: #84a7c4;
  --color-brand: #f38639;
  --font-fam: 'Lato', sans-serif;
  --height: 3rem;
  --btn-width: 3rem;
  --bez: cubic-bezier(0, 0, 0.43, 1.49);
}

 #new{
  position: relative;
  width: 19rem;
  background: var(--color-brand);
  border-color: #f38639;
  border-radius: var(--rad);

  margin: 0 auto;


}
input{
  height: var(--height);
  font-family: var(--font-fam);
  border: 0;
  color: var(--color-dark);
  font-size: 1.3rem;



}
input[type="search"] {
  outline: 0;
  width: 100%;
  background: var(--color-light);
  padding: 0 1.5rem;
  border-radius: var(--rad);
  appearance: none;
  transition: all var(--dur) var(--bez);
  transition-property: width, border-radius;
  z-index: 1;
  position: relative;


}

input:not(:placeholder-shown) {
  border-radius: var(--rad) 0 0 var(--rad);
  width: calc(100% - var(--btn-width));

}
input:not(:placeholder-shown) + button {
  display: block;
  color: white;
}
label {
  position: absolute;
  clip: rect(1px, 1px, 1px, 1px);
  padding: 0;
  border: 0;
  height: 1px;
  width: 1px;
  overflow: hidden;
}

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
    content: "السؤال ";
	color: #094e89;
  }
  table tbody tr td:nth-child(2):before {
    content: "الجواب ";
	color: #094e89;

  }
  table tbody tr td:nth-child(3):before {
    content: "الصف ";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "العلامة ";
	color: #094e89;
  }
  table tbody tr td:nth-child(4):before {
    content: "عمليات التعديل ";
	color: #094e89;
  }

}

/* end table */
/*select and option */
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
/**/

.tab1cards {
  display: flex;
  flex-direction: row;
  justify-content: center;
}

</style>
@endsection
@section('content')


@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: "تمت اضافة السؤال بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('update'))
<script>
    window.onload = function () {
        notif({
            msg: "تمت تعديل سؤال  بنجاح ",
            type: "success"
        })
    }
</script>
@endif


<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                <h1 class="mb-0 bread"> اضافة محتوى مؤتمت </h1>
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> اضافة محتوى مؤتمت </a>
      <!--<a  href="{{ route('coordinator_quize',[$class->id,$lesson->id]) }}" class="breadcrumbs__item">المذاكرات   </a>-->
      <a  href="{{ route('coordinator_lesson',[$class->id,$lesson->id]) }}" class="breadcrumbs__item ">{{ $lesson->name }} </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class->id ) }}" class="breadcrumbs__item ">{{ $class->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->
<div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">حذف السؤال</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form action="{{ route('question_delete') }}" method="post">
@csrf
</div>
<div class="modal-body">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="question_id" id="question_id" value="">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
<button type="submit" class="btn btn-danger">تاكيد</button>
</div>
</form>
</div>
</div>
</div>

<br>
<br>
<br>
<br>
<input hidden value="{{ $lesson_id }}" id="lesson_id">
<div class="col-md-12 heading-section text-center ftco-animate">
<span class="subheading"></span>
<div class="tab1cards">

    <a  href="{{ route('add_questions',[$class->id ,$lesson_id ]) }}" type="button" class="btn btn-primary"
    style="padding-top: 13px;">
        اضافة سؤال &nbsp; <i class="fa fa-plus"></i> </a>&nbsp;
        <a href="{{ route('sections',[$class->id ,$lesson_id ]) }}" class="btn btn-primary"  type="button "  style="padding-top: 13px;">
               اضافة فقرة  &nbsp;  <i class="fa fa-plus"> </i></a>&nbsp;
              <!--<a href="{{ route('exams',[$class->id ,$lesson_id ]) }}" class="btn btn-primary"  type="button "  style="padding-top: 13px;">-->
              <!--  <i class=""> </i> المذاكرات </a>&nbsp;-->
                <input  hidden  value="{{ $class->id }}" class="exam12">


     </div>
     <br>
              <br>
              <br>
              <br>
     <form  id="new"   onsubmit="event.preventDefault();" role="search" style="direction: rtl;">
        <label for="search" style="direction: rtl;"></label>
        <input id="search" type="search"  style="color: white;" placeholder="البحث .."  />

      </form>



<!-- marks of homework -->
      <table class="table1" >
        <thead>
            <tr>
                <th>السؤال </th>
                <th>الجواب </th>
                <th>الصف  </th>

                <th>العلامة  </th>
                <th>ملاحظات  </th>
                <th>عمليات التعديل  </th>
            </tr>
        </thead>
        <tbody>
            @php
$i = 0
@endphp

@foreach ($questions as $question )
@php
$i++
@endphp
            <tr >
                <td>{{ $question->question_form }}</td>

                 @if ( is_array(json_decode($question->answer)))
                 <td>
                    @foreach (   json_decode($question->answer)  as $item )
                         {{$item  }},
                    @endforeach

                </td>
                 @else
                 <td>{{ $question->answer }}</td>
                 @endif
                <td>{{ $question->classes->name }}  </td>

                <td>{{ $question->mark }}</td>
                <td>{{ $question->note }}</td>

                <td><a href="{{ route('question_edit',[$question->id,$class->id,$lesson_id]) }}"   class="btn" style="background-color: white; color: rgb(117, 115, 115);" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </a>&nbsp;&nbsp;&nbsp;
                <!--<a href="#"  id="delete_question"class="btn" style="background-color: white; color: rgb(117, 115, 115);" data-question_id="{{ $question->id }}"-->
                <!--    data-toggle="modal" data-target="#delete_question">حذف </a>-->
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
    $('#delete_question').on('show.bs.modal', function(event) {
var button = $(event.relatedTarget)
var question_id = button.data('question_id')
var modal = $(this)
modal.find('.modal-body #question_id').val(question_id);
})
    </script>
    <script>

        $(document).on('keyup', '#search', function () {
            var lect=$('#search').val();
                    var exam=$('.exam12').val();
                    var lesson_id=$('#lesson_id').val();

                    var data={
                            "search":lect,
                            "exam":exam,
                            "lesson_id":lesson_id,

                        }
                    var url = "{{ URL::to('SMARMANger/dashboard/coordinator/search') }}";
                $.ajax({
                    url: url,
                    data : data,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        if(data==1){
                            $('.lecq').append(`  <li> not found</li>`)
                        }
                 console.log(data);
                 $('.table1 tbody').empty();
                 $('.lecq').empty();
                        $.each(data, function (key, value) {
                            $('.table1 tbody').append(`  <tr >
                <td>${ value.question_form }</td>
                <td>${ value.answer }</td>
                <td>${ value.classes.name }  </td>
              
                <td>${ value.mark } </td>
                <td>${ value.note }</td>

                <td><a href="{{url('dashboard/teacher/questions/edit') }}/${value.id}"    class="btn" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </a>&nbsp;&nbsp;&nbsp;<a href="#"  id="delete_question"class="btn" style="background-color: white; color: rgb(117, 115, 115);"data-question_id="${ value.id }"
                    data-toggle="modal" data-target="#delete_question">حذف </a>
                   </td>
            </tr>`)



                        });




                    },
                    error: function (xhr) {

                    }

                })

        })
        $(document).on('change', '.choice', function () {

                    var lect=$(this).val();
                    var exam=$('.exam12').val();

                    $('.lecq').empty();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/lecquestion') }}/" + lect +"/"+exam;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        if(data==1){
                            $('.lecq').append(`  <li> not found</li>`)
                        }
                 console.log(data);
                 $('.table1 tbody').empty();
                 $('.lecq').empty();
                        $.each(data, function (key, value) {
                            $('.table1 tbody').append(`  <tr >
                <td>${ value.question_form }</td>
                <td>${ value.answer }</td>
                <td>${ value.classes.name }  </td>
                <td>${ value.lecture.name }  </td>
                <td>${ value.mark } </td>
                <td>${ value.note }</td>

                <td><a href="{{url('dashboard/teacher/questions/edit') }}/${value.id}"   class="btn" style="background-color: white; color: rgb(117, 115, 115);">تعديل  </a>&nbsp;&nbsp;&nbsp;<a href="#"  id="delete_question" class="btn" style="background-color: white; color: rgb(117, 115, 115);" data-question_id="${ value.id }"
                    data-toggle="modal" data-target="#delete_question">حذف </a>
                   </td>
            </tr>`)



                        });




                    },
                    error: function (xhr) {

                    }

                });})

        </script>
@endsection
