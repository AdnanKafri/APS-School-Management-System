@extends('admin.master')
@section('style')
    <style>
        .content-body {
            min-height: 0px !important;
        }
    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">قسم التحكم الكامل بالموقع</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('content')
    <div class="container-fluid mt-3" style="padding-bottom: 55px;padding-top: 55px;">




        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                <a href="{{ route('websitehome') }}">
                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	fas fa-home"></i></span>
                            <h2 class="text-white" style="text-align: right;">الصفحة الرئيسية </h2>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                <a href="{{ route('school_data') }}">
                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	fas fa-home"></i></span>
                            <h2 class="text-white" style="text-align: right;">بيانات المدرسة </h2>
                        </div>
                    </div>
                </a>

            </div>
            {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                           <a href="{{ route('websitecontactus') }}">

                          <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-id-badge"></i></span>
                                <h2 class="text-white" style="text-align: right;">اتصل بنا </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}
            <div class="col-lg-3 col-sm-6">


            </div>

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>
            {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                        <a href="{{ route('news') }}">
                        <div class="card gradient-3">
                            <div class="card-body">

                              <span class="float-left display-2 opacity-5"><i class="fas fa-newspaper-o"></i></span>
                              <h2 class="text-white" style="text-align: right;">   الاخبار </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}
            {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                         <a href="{{ route('about_us1') }}">
                       <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa fa-map"></i></span>
                                <h2 class="text-white" style="text-align: right;">من نحن </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}
            <div class="col-lg-3 col-sm-6">

            </div>

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>

            {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                         <a href="{{ route('admin.our_team') }}">
                       <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class='fa fa-group'></i></span>
                                <h2 class="text-white" style="text-align: right;">فريقنا  </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}

            <div class="col-lg-4 col-sm-6">

            </div>

        </div>



    </div>
@endsection
