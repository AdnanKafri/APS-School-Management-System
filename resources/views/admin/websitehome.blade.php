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
        <a class="breadcrumbs__item is-active">الصفحة الاساسية</a>
        <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection
@section('content')
    <div class="container-fluid mt-3" style="padding-bottom: 55px;padding-top: 55px;">




        {{-- <div class="row">
                    <div class="col-lg-3 col-sm-6">

                    </div>
                    <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                             <a href="{{ route('advantages') }}">
                         <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	fas fa-star"></i></span>
                                <h2 class="text-white" style="text-align: right;"> ماذا نقدم  </h2>
                            </div>
                        </div>
                        </a>

                    </div>
                    <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                            <a href="{{route('slider')}}">

                          <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                                <h2 class="text-white" style="text-align: right;">   السلايدر </h2>
                            </div>
                        </div>
                        </a>
                    </div>
                      <div class="col-lg-3 col-sm-6">


                    </div>

                </div> --}}

        <div class="row">

            {{-- <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                <a href="<?php echo e(route('advantages')); ?>">
                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	fas fa-star"></i></span>
                            <h2 class="text-white" style="text-align: right;"> ماذا نقدم </h2>
                        </div>
                    </div>
                </a>

            </div> --}}

            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('slider')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> السلايدر </h2>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('vision_mission_website')); ?>">

                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> الرسالة والرؤية </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                <a href="<?php echo e(route('about')); ?>">
                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	fas fa-star"></i></span>
                            <h2 class="text-white" style="text-align: right;"> من نحن </h2>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('service_website')); ?>">

                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> خدماتنا </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('our_services_feature_website')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> الخدمات و الميزات </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('how_it_works_website')); ?>">

                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> كيف نعمل </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('gallery')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> معرض الصور </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6" style="    padding-right: 0px;">
                <a href="<?php echo e(route('counter_website')); ?>">
                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	fas fa-star"></i></span>
                            <h2 class="text-white" style="text-align: right;"> عداد الموقع </h2>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('testimonials_website')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> التوصيات </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('blogs_website')); ?>">

                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> المدونات </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('footer_website')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> معلومات التواصل </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('faqs_website')); ?>">

                    <div class="card gradient-2">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> الاسئلة الشائعة </h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="<?php echo e(route('contact_website')); ?>">

                    <div class="card gradient-1">
                        <div class="card-body">

                            <span class="float-left display-2 opacity-5"><i class="	far fa-image "></i></span>
                            <h2 class="text-white" style="text-align: right;"> رسائل العملاء </h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- <div class="col-lg-3 col-sm-6">


                                                        </div> -->

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">

            </div>
            {{-- <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                        <a href="{{ route('other') }}">
                        <div class="card gradient-3">
                            <div class="card-body">

                              <span class="float-left display-2 opacity-5"><i class="fas fa-info-circle "></i></span>
                              <h2 class="text-white" style="text-align: right;">   تفاصيل اخرى </h2>
                            </div>
                        </div>
                        </a>
                    </div> --}}
            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <!--<div class="card gradient-4">-->
                <!--     <div class="card-body">-->

                <!--         <span class="float-left display-2 opacity-5"><i class="fas fa fa-map"></i></span>-->
                <!--         <h2 class="text-white" style="text-align: right;">من نحن </h2>-->
                <!--     </div>-->
                <!-- </div>-->
            </div>
            <div class="col-lg-3 col-sm-6">

            </div>

        </div>



    </div>
@endsection
