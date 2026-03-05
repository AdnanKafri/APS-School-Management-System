@extends('school_controller.layouts.app')
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
.title {
    font-weight: 900;
    font-size: 22px;
    color: #152C4F;
    float: right;
}
</style>
@endsection
@section('content')



        <!-- partial -->

        <div class="main-panel" style="background: #f8f9fb;">
          <ul class="breadcrumbs" style="padding-bottom: 7px;
          padding-top: 11px;">
            <li class="li"><a href="{{route('dashboard.coordinator') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a href="#">{{ $room_name }}</a></li>

         </ul>

          <div class="content-wrapper pb-0">

            <div class="container animated fadeInDown" style="padding-top: 40px;">
              <div class="row">


                @foreach ($lessonsArray as $item)

                <div class="col-md-4">
                    <div class="cookie-card">
                    <span class="title"> {{ $item->name }} </span>
                    <div class="actions" style="padding-top: 20px;width: fit-content;">
                        <button class="pref">
                        </button>
                        <a  href="{{ route('coordinator_subjects_lectures',['lesson_id' =>$item->id ,'room_id'=>$room_id]) }}"  class="accept">
                            الدروس
                        </a>
                         <a  style="    width: max-content;" href="{{ route('teacher_question',['lesson_id' =>$item->id ,'room_id'=>$room_id]) }}"  class="accept">
                               الاسئلة 
                        </a>
                    </div>
                </div>
            </div><!--end col-md-4 -->


    @endforeach

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

