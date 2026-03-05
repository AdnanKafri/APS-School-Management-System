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



        <!-- partial -->

        <div class="main-panel" style="background: #f8f9fb;">
          <ul class="breadcrumbs" style="padding-bottom: 7px;
          padding-top: 11px;">
            <li class="li"><a href="{{route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a href="#">{{ $room_name }}</a></li>

         </ul>

          <div class="content-wrapper pb-0">

            <div class="container animated fadeInDown" style="padding-top: 40px;">
              <div class="row">

                @foreach ( $teacher_lessons as $item )
                <div class="col-md-4">
                  <div class="cookie-card">
                    <span class="title"> {{ $item->name }} </span>
                    <div class="actions" style="padding-top: 20px">
                        <button class="pref">
                        </button>
                        <a  href="{{ route('dashboard.lessons.lectures',['lesson_id' =>$item->id ,'teacher_id'=>$teacher->id,'room_id'=>$room_id]) }}"  class="accept">
                            الدروس
                        </a>
                        <a  href="{{route('teacher.books',['lesson_id' =>$item->id ,'teacher_id'=>$teacher->id,'room_id'=>$room_id])}}"  class="accept">
                            المحتوى
                        </a>
                    </div>
                </div>
            </div><!--end col-md-4 -->
            @endforeach
            </div>
            </div>

            <div class="container mt-5">
                <div class="row" style="direction: rtl;">
                  <div class="col-md-12  mr-auto">

                    <!-- Nav tabs -->
                    {{-- <div class="card">
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


                      </div> --}}
                      <!--end card header-->
                      {{-- <div class="card-body">
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
                                    <p class="cookieHeading">علامات الوظائف</p>
                                    <a  href="{{ route('dashboard.StudentsRoomLesson_homeworke',[$room_id,$teacher->id,$item->id]) }}" class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>
                                <div class="col-md-4" style="margin-bottom: 10px;">
                                  <div class="cookieCard">
                                    <p class="cookieHeading">علامات الامتحانات</p>
                                    <a href="#" class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>

                                <div class="col-md-4" style="margin-bottom: 10px;">
                                  <div class="cookieCard">
                                    <p class="cookieHeading">علامات المذاكرت</p>
                                    <a href="#" class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>

                                <div class="col-md-4" style="margin-bottom: 10px;">
                                  <div class="cookieCard">
                                    <p class="cookieHeading">علامات الاختبارات</p>
                                    <a  href="#"class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>

                                <div class="col-md-4" style="margin-bottom: 10px;">
                                  <div class="cookieCard">
                                    <p class="cookieHeading">دفتر العلامات</p>
                                    <a href="#" class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>

                                <div class="col-md-4" style="margin-bottom: 10px;">
                                  <div class="cookieCard">
                                    <p class="cookieHeading">الاوسمة</p>
                                    <a href="{{ route('medal',[$room_id,$teacher->id,$item->id]) }}" class="acceptButton" style="color: #fff;">العلامات</a>
                                  </div>
                                </div>

                              </div>

                            </div>
                          </div>

                         @endforeach



                        </div>
                      </div><!--end card body--> --}}
                    </div><!--end-->
                  </div>

                </div>
              </div>
                <!--card of subjects-->

      </div><!--end container of cards-->
      <!-- page-body-wrapper ends -->
    </div>
    </div><!--end container-scroller-->

    <!-- container-scroller -->
    @endsection
    @section('js')

