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
        <li class="li"><a href="#">  الأوسمة</a></li>

     </ul>
        <div class="content-wrapper pb-0">
          <!--tablist -->

<div class="warpper">
<input class="radio" id="one" name="group" type="radio" checked>
<input class="radio" id="two" name="group" type="radio">
<input class="radio" id="three" name="group" type="radio">

<div class="tabs">
  <label class="tab" id="one-tab" for="one">  الأوسمة </label>

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
              <th>اسم  الاستاذ </th>
              <th> الاسم  </th>
              <th>تاريخ المنح</th>
              <th> الصورة</th>

            </tr>
          </thead>
          <tbody>
            @foreach($rewads as $rewad)
            <tr>
                {{-- <td>اسم الاستاذ الأول </td> --}}
                <td  data-label="اسم المادة">{{ $rewad->lesson->name }} </td>
                <td  data-label="اسم  الاستاذ">{{ $rewad->teacher->first_name }} {{ $rewad->teacher->last_name }} </td>
                <td data-label="الاسم "> {{ $rewad->rewad_and_sanction->name }}  </td>
                <td data-label="تاريخ المادة"> {{ $rewad->created_at }}  </td>
            
                <td data-label=" الصورة"><img src="{{ asset('storage/'.$rewad->rewad_and_sanction->image) }}"
                    id="image6" alt="Not found" width="50" alt=""> </td>
               
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
      <!--end tabel-->
  </div>

</div>
</div>
<br>
<br>
          <!-- end tablist -->
 

	@endsection
  @section('js')
  <script>
     $(document).ready(function(){
      $('.medal11').addClass('active') ;
    })
  </script>

  	@endsection
