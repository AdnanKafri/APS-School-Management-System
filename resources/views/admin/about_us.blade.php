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

    <a  class="breadcrumbs__item is-active">  من نحن </a>

    <a  href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')
                
            <div class="container-fluid mt-3" style="padding-bottom: 55px;padding-top: 55px;" >




                <div class="row">
                    <div class="col-lg-3 col-sm-6">

                    </div>
                    <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                             <a href="{{ route('about') }}">
                         <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	fas fa-star"></i></span>
                                <h2 class="text-white" style="text-align: right;"> من نحن   </h2>
                            </div>
                        </div>
                        </a>

                    </div>
                    <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                         <a href="{{ route('more_details') }}">
                          <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-bar-chart "></i></span>
                                <h2 class="text-white" style="text-align: right;">  تفاصيل اكثر  </h2>
                            </div>
                        </div>
                        </a>
                    </div>
                      <div class="col-lg-3 col-sm-6">


                    </div>

                </div>




        </div>

        @endsection

