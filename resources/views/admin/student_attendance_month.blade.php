@extends('admin.master')
@section('style')

<style>
.content-body{
        min-height: 0px !important;
}


</style>
       @endsection
       
       
@section('breadcrumbs')

<nav class="breadcrumbs">
    <nav class="breadcrumbs">
        <a  class="breadcrumbs__item is-active"> حضور  الطالب   </a>
        <a  href="{{ route('students') }}" class="breadcrumbs__item is-active">قسم الطلاب
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
</nav>

@endsection
       
@section('content')
            
            <div class="container-fluid mt-3" style="padding-bottom: 55px;padding-top: 55px;" >
                <div class="row">
                    @if($month)
                   @foreach ( $month as $key=>$item )
                   <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                    <a href="{{ route('admin.student_attendance',[$student_id,$room,$key]) }}">
                 
                   <div class="card gradient-2" style="background-image: linear-gradient(230deg, #52fcec, #a7a2fb);">
                     <div class="card-body">

                         <span class="float-left display-2 opacity-5"><i class="far fa-folder-open"></i></span>
                         <h2 class="text-white" style="text-align: right;"> {{$item}} </h2>
                     </div>
                 </div>
                 </a>
             </div>
                   @endforeach
                   @else
                   <p style="margin: auto;">لايوجد بيانات مرتبطة  بالطالب </p>
                   @endif
                    
                    
                 
                   
                </div>
              
               

        </div>

        @endsection

