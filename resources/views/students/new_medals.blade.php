@extends('students.layouts.app4')
@section('title')
الأوسمة
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/prizes.css') }}">
     <style>

/*end style cards*/
.checkbox:checked + label,
      .checkbox:not(:checked) + label{

        position: relative;
        background-color: white !important;
        cursor: pointer;
        margin: 0 auto;
        text-align: center;
        margin-right: 6px;
        margin-left: 6px;
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 3px solid #bdc3c7;
        background-size: cover;
        background-position: center;
        box-sizing: border-box;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
        background-image: url("{{  asset('student/demo/icons/p-1.png') }}");
        animation: border-transform 6s linear infinite alternate forwards;
          -webkit-animation-play-state: paused;
          -moz-animation-play-state: paused;
          animation-play-state: paused;
      }
      .checkbox.scnd + label{
        background-image: url("{{  asset('student/demo/icons/p-2.png') }}");
      }
      .checkbox.thrd + label{
        background-image: url("{{  asset('student/demo/icons/p-3.png') }}");
      }
     @media(min-width:1100px) and (max-width:2000px){
        .medalcontent{
            width:87% !important;
            right: 5% !important;
        }
     }

	 </style>

	@endsection
    @section('content')
    <div class="main-panel" style="background: #f8f9fb;">
      <ul class="breadcrumbs" style="padding-bottom: 7px;
      padding-top: 11px;">

        <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
        <li class="li"><a href="#">الاوسمة</a></li>

     </ul>
        <div class="content-wrapper pb-0">
          <!--tablist -->

<div class="warpper">
<input class="radio" id="one" name="group" type="radio" checked>
<input class="radio" id="two" name="group" type="radio">
<input class="radio" id="three" name="group" type="radio">

<div class="tabs">
  <!--<label class="tab" id="one-tab" for="one"> النشاط الصفي</label>-->
  <!--<label class="tab" id="two-tab" for="two">الامتحانات</label>-->
  <label class="tab" id="three-tab" for="three">الاختبارات</label>
</div>

<div class="panels">
  <div class="panel" id="one-panel">
    <div class="panel-title"></div>
      <!--table-->
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>اسم المادة</th>
              <th>تاريخ المنح</th>
              <th>الأوسمة</th>

            </tr>
          </thead>
          <tbody>
            @foreach($medals as $medal)
            <tr>
                {{-- <td>اسم الاستاذ الأول </td> --}}
                <td  data-label="اسم المادة">{{ $medal->lesson->name }} </td>
                <td data-label="تاريخ المادة"> {{ $meson->created_at }}  </td>
                @if($medal->medal == '1')
                <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-1.png') }}" class="img1" alt="gold"> </td>
                @elseif($medal->medal == '2')
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-2.png') }}" class="img1" alt="silver"> </td>
                @else
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-3.png') }}" class="img1" alt="pronze"> </td>
                @endif
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
      <!--end tabel-->
  </div>
  <div class="panel" id="two-panel">
    <div class="panel-title"></div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>اسم المادة</th>
            <th>تاريخ المنح</th>
            <th>الأوسمة</th>

          </tr>
        </thead>
        <tbody>
            @foreach($exam_medals as $medal)
            <tr>
                {{-- <td>اسم الاستاذ الأول </td> --}}
                <td data-label="اسم المادة">{{ $medal->lesson->name }} </td>
                <td data-label="تاريخ المادة"> {{ $medal->lesson->created_at }}  </td>
                @if($medal->medal == '1')
                <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-1.png') }}" class="img1" alt="gold"> </td>
                @elseif($medal->medal == '2')
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-2.png') }}" class="img1" alt="silver"> </td>
                @else
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-3.png') }}" class="img1" alt="pronze"> </td>
                @endif
            </tr>
            @endforeach

        </tbody>
      </table>
    </div>
  </div>
  <div class="panel" id="three-panel">
    <div class="panel-title"></div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>اسم المادة</th>
            <th>تاريخ المنح</th>
            <th>الأوسمة</th>

          </tr>
        </thead>
        <tbody>
            @foreach($test_medals as $medal)
            <tr>
                {{-- <td>اسم الاستاذ الأول </td> --}}
                <td data-label="اسم المادة">{{ $medal->lesson->name }} </td>
                <td data-label="تاريخ المادة"> {{ $medal->lesson->created_at }}  </td>
                @if($medal->medal == '1')
                <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-1.png') }}" class="img1" alt="gold"> </td>
                @elseif($medal->medal == '2')
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-2.png') }}" class="img1" alt="silver"> </td>
                @else
                    <td data-label="الاوسمة"><img src="{{ asset('student/demo/icons/p-3.png') }}" class="img1" alt="pronze"> </td>
                @endif
            </tr>
            @endforeach


        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
          <!-- end tablist -->
          <!--start prizes-->

  <div class="section " style="padding-top: 40px;z-index: 999;">
      <div class="container">
          <div class="row full-height justify-content-center">
              <div class="col-md-12  align-self-center padding-tb">
                  <div class="section mx-auto text-center slider-height-padding medalcontent">
                        <input class="checkbox frst" type="radio" id="slide-1" name="slider" checked/>
                        <label for="slide-1"></label>
                        <input class="checkbox scnd" type="radio" name="slider" id="slider-2"/>
                        <label for="slider-2"></label>
                        <input class="checkbox thrd" type="radio" name="slider" id="slider-3"/>
                        <label for="slider-3"></label>
                <br>
                <br>

                      <ul class="ul">

                          <li class="li">


              <div class="row" style="padding:15px">
                @foreach ($lessons as $lesson)
               <div class="col-md-2 newcol-2">
              <!--start subject-->
              <div class="container5">
                <img src="{{ asset('student/demo/icons/subject.jpg') }}" />
                <div class="title">  {{ $lesson->name }}
                  <br>
                  <h7>{{ $lesson->golden_medals_count }} </h7>
                </div>
              </div>
              <!--end subject-->
              </div>
              @endforeach

              </div>
                          </li>
              <!-- end gold prize-->

              <!-- start silver prize -->
                          <li class="li">
              <div class="row" style="padding:15px">
                @foreach ($lessons as $lesson)
                <div class="col-md-2 newcol-2">
               <!--start subject-->
               <div class="container5">
                 <img src="{{ asset('student/demo/icons/subject.jpg') }}" />
                 <div class="title">  {{ $lesson->name }}
                   <br>
                   <h7>{{ $lesson->silver_medals_count }} </h7>
                 </div>
               </div>
               <!--end subject-->
               </div>
               @endforeach
               </div>
                          </li>
              <!-- end silver prize-->


          <!-- start pronze prize -->
                          <li class="li">

              <div class="row" style="padding:15px">
                @foreach ($lessons as $lesson)
                <div class="col-md-2 newcol-2">
               <!--start subject-->
               <div class="container5">
                 <img src="{{ asset('student/demo/icons/subject.jpg') }}" />
                 <div class="title">  {{ $lesson->name }}
                   <br>
                   <h7>{{ $lesson->pronze_medals_count }} </h7>
                 </div>
               </div>
               <!--end subject-->
               </div>
               @endforeach
               </div>
                          </li>
              <!-- end pronze prize -->

                      </ul>
                  </div>
              </div>
            </div>
      </div>
  </div>
	@endsection
  @section('js')
  <script>
     $(document).ready(function(){
      $('.medal11').addClass('active') ;
    })
  </script>

  	@endsection
