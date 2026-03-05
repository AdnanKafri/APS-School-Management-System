@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
@endsection
<style>

@media (min-width: 768px) and (max-width:1100px){
    .col-md-3 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 70%;
    flex: 0 0 47%;
   max-width: 47%;
}
  }
  @media(min-width:200px) and (max-width:700px){
    .col-md-3{
      padding-left: 0px !important;
      padding-right: 0px !important;
    }
}
  </style>
</head>
@section('content')
<div class="main-panel" style="background: #f8f9fb;">
	<ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">الدروس</a></li>

   </ul>
	<div class="content-wrapper pb-0">
	  <!--content -->
		<!--card of subjects-->
		  <div class="container" style="padding-bottom: 100px;" >
			<div class="row">
    
				  <!--start card-->
				  @foreach ($lectures as $lecture)
				  @if($lecture->lecture_time < $now )
				  <div class="col-md-3 lcol">
					<div class="card__collection clear-fix  animated fadeInDown">
				  <div class="cards cards--two"  data-aos="fade-down"
				  data-aos-easing="linear"
				  data-aos-duration="1500">
					 <h3 style="text-align: center;margin-top: 20px;color: white;">{{ $lecture->name }}  </h3>
					  <!--img src="../download (26).jpg" alt="Cards Image"-->
					  <div class="row lessonrow" style="left: 35px;
					  z-index: 999;
					  position: absolute;
					  top: 75%;">
						<a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"  class="button2"><span>محتوى الدرس</span><i></i></a>
					  </div>
					  <span class="cards--two__rect"></span>
					  <span class="cards--two__tri">

					  </span>

					</div>
					</div>
				  </div>
				  @endif
					@endforeach

					<!--end card-->
					<!--start card-->

					<!--end card-->
					<!--start card-->

					<!--end card-->


			</div><!---end row-->






	<!-- partial -->
  </div>
  <!-- main-panel ends -->
</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>
	@endsection
	@section('js')
	<script>
		   $( document ).ready(function(){
           $('.lesson11').addClass('active') ;
     })
		AOS.init();
	  </script>
	@endsection
