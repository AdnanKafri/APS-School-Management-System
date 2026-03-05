@extends('admin.supervisors.layouts.new_app')
@section('css')
<style>

</style>

@endsection
@section('content')

<div class="main-panel" style="background: #f8f9fb;">
	<ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">
	  <li class="li"><a href="{{ route('admin_dashboard_supervisor') }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">{{ $room_name }}</a></li>

   </ul>

	<div class="content-wrapper pb-0">

	  <div class="container animated fadeInDown" style="padding-top: 40px;">
		<div class="row">

		  @foreach ( $lessons as $item )
		  <div class="col-md-4">
			<div class="cookie-card">
			  <span class="title"> {{ $item->name }} </span>
			  <div class="actions" style="padding-top: 20px">
				  <button class="pref">
				  </button>
				  <a  href="{{ route('admin.edu_supervisor.subjects.lectures',['lesson_id' =>$item->id ,'room_id'=>$room_id]) }}"  class="accept">
					  الدروس
				  </a>
				  {{-- <a  href="{{route('teacher.books',['lesson_id' =>$item->id ,'teacher_id'=>$teacher->id,'room_id'=>$room_id])}}"  class="accept">
					  المحتوى
				  </a> --}}
			  </div>
		  </div>
	  </div><!--end col-md-4 -->
	  @endforeach
	  </div>
	  </div>

	  <div class="container mt-5">
		  <div class="row" style="direction: rtl;">
			<div class="col-md-12  mr-auto">

			  </div><!--end-->
			</div>

		  </div>
		</div>
		  <!--card of subjects-->

</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>


@endsection
@section('js')
@endsection
