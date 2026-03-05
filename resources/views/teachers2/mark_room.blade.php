@extends('teachers2.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('teachers_2/assets/css/newteacher.css')}}">
<style>
.nav-tabs {
    border: 0 !important;
    padding: 50px 0.7rem !important;
}
   div .card .card-header {
    background: transparent !important;
    border-bottom: 0 !important;
    border-radius: 0 !important;
    padding: 0 !important;
}
.nav-tabs>.nav-item>.nav-link.active {
    background-color: #152c4fc7 !important;
    border-radius: 30px !important;
    color: #FFFFFF !important;
}

</style>
@endsection
@section('content')
<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{route('teacher.mark_class')}}"> دفتر العلامات </a></li>
      <li class="li"><a href="#">علامات المواد</a></li>

   </ul>
    <div class="content-wrapper pb-0">
      <div class="container mt-5">
        <div class="row" style="direction: rtl;">
          <div class="col-md-12  mr-auto">

            <!-- Nav tabs -->
            <div class="card">
                <div class="card-header">

                  <ul class="nav nav-tabs justify-content-center" role="tablist">
                      @php
                      $i=0;
                      @endphp
                      @foreach ($teacher_lessons as $item )
                      @php
                      $i=$i+1;
                      @endphp
                      @if ($i==1)
                      <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab"  href="#tab-{{ $item->id }}" role="tab">
                            <!--i class="now-ui-icons objects_umbrella-13"></i--> علامات {{ $item->name }}
                          </a>
                        </li>
                        @else

                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab"  href="#tab-{{ $item->id }}" role="tab">
                            <!--i class="now-ui-icons objects_umbrella-13"></i--> علامات {{ $item->name }}
                          </a>
                        </li>
                      @endif
                      @endforeach
                  </ul>

                </div><!--end card header-->
                <div class="card-body">
                  <!-- Tab panes -->
                  <div class="tab-content text-center">
                      @php
                      $i=0;
                      @endphp
                      @foreach ($teacher_lessons as $item)
                      @php
                      $i=$i+1;
                      @endphp

                  <div role="tabpanel" @if($i == 1) class="tab-pane active"
                       @else class="tab-pane" @endif id="tab-{{ $item->id }}">

                      <div class="container animated bounceInLeft">
                         <div class="row" >
                          


                          <div class="col-md-4" style="margin-bottom: 10px;">
                            <div class="cookieCard">
                              <p class="cookieHeading">دفتر العلامات</p>
                              <a href="{{ route('dashboard.StudentsRoomLessontotal',[$room_id,$teacher->id,$item->id]) }}" class="acceptButton" style="color: #fff;">العلامات</a>
                            </div>
                          </div>

                          <!-- Phase 4: Parallel Gradebook Button -->
                          <div class="col-md-4" style="margin-bottom: 10px;">
                            <div class="cookieCard" style="border: 2px solid #5e72e4;">
                              <p class="cookieHeading">دفتر الدرجات (الجديد)</p>
                              <p class="cookieDescription" style="font-size: 12px; margin-bottom: 5px;">إدخال جميع العلامات</p>
                              <a href="{{ route('teacher.gradebook.index', [$item->class_id, $room_id, $item->id]) }}" class="acceptButton" style="background-color: #5e72e4; color: #fff;">فتح الدفتر</a>
                            </div>
                          </div>

                      

                        </div>

                      </div>
                    </div>

                   @endforeach



                  </div>
                </div><!--end card body-->
              </div><!--end-->
          </div>

        </div>
      </div>
        <!--card of subjects-->

</div>
</div>

@endsection
