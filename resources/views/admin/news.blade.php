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

    <a  class="breadcrumbs__item is-active">   الاخبار  </a>

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
                             <a href="{{ route('newsdetails') }}">
                         <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fa fa-newspaper-o"></i></span>
                                <h2 class="text-white" style="text-align: right;">  تفاصيل الاخبار   </h2>
                            </div>
                        </div>
                        </a>

                    </div>
                    {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                         <a href="{{ route('category') }}">
                          <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-list-alt "></i></span>
                                <h2 class="text-white" style="text-align: right;">  تصنيفات الاخبار   </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}
                      <div class="col-lg-3 col-sm-6">


                    </div>

                </div>




        </div>

        @endsection

