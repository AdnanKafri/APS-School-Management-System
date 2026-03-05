@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">
     <style>
       @media (min-width: 768px){
      .col-md-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 40%;
}
     }
	 </style>

@endsection

@section('content')
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">
	 
	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#"> الامتحانات</a></li>
	  
   </ul>
    <div class="content-wrapper pb-0">
      <!--content -->
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="flexcard flexcardBlue">
                <div class="flexcardNumber flexcardNumberBlue">01</div>
                <div class="flex flexcardTitle"><a href="{{ route('dashboard.student.room.main.exams',[$room_id,$student->id]) }}" style="color: #152C4F;">الامتحانات</a></div>
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="flexcard flexcardBlue">
                <div class="flexcardNumber flexcardNumberBlue">02</div>
                <div class="flex flexcardTitle"><a href="{{ route('dashboard.student.room.main.quizes',[$room_id,$student->id]) }}" style="color: #152C4F;">المذاكرات</a></div>
               
              </div>
            </div>

          </div>
        </div>

      <!--end content-->
  
</div>
</div>
	@endsection
    @section('js')
 <script>
   $(document).ready(function(){
   $('.exam11').addClass('active') ;  
 })
    </script>
    @endsection
