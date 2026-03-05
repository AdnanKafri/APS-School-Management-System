@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">
     <style>
@media (min-width: 768px){
  .col-md-6 {
    padding-top: 0px;
  
}
}
      </style>
@endsection

@section('content')
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
  padding-top: 11px;">
   
    <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
    <li class="li"><a href="#">الأحداث</a></li>
    
 </ul>
  <!--content-wrapper -->
<div class="content-wrapper pb-0">
   <div class="container">
    <div class="row">
      @foreach( $events as $item)
      <div class="col-md-6">
        <div class="main_card">
<br/><br/><br/>
<div class="ribbon-wrapper"><div class="glow">&nbsp;</div>
<div class="ribbon-front">
  {{$item->title}} 
</div>

<div class="container" style="margin-top: -40px;direction: rtl;">
<div class="row" >
<div class="col-md-4 newcol" style="left: 48px;">
  <span style="font-size: 15px;color: #fff;margin-left: -9px;"><i class="mdi mdi-calendar" style="font-size: 14px;color: #fff;"></i>&nbsp;   {{ \Carbon\Carbon::parse($item->date)->format('m/d/Y')}}</span>
</div>
</div>
</div>

<p class="event_text">
  {{$item->content}}</p>
<div class="row" style="padding-right: 12px;direction: rtl;">

  <p style="padding: 10px;color: #fff;font-size: 17px;"><i class="mdi mdi-account" style="font-size: 15px;color: #fff;"></i>{{$item->teacher->first_name}} {{$item->teacher->last_name}}</p>
</div>

<div class="ribbon-edge-topleft"></div>
<div class="ribbon-edge-topright"></div>
<div class="ribbon-edge-bottomleft"></div>
<div class="ribbon-edge-bottomright"></div>
</div>
</div>

      </div><!--end col-->
    
    @endforeach 
      </div><!--end col-->

    </div><!--end row-->

   </div>
 
</div><!--content-wrapper-->
<!--end content-->
</div>
@endsection
@section('js')


@endsection



