@extends('admin.master')
@section('style')
    <style>
        .content-body {
            min-height: 0px !important;
        }

        /* .text-white{
        margin: 0px !important;
    } */
        .text-white {
            color: #fff !important;
            margin-top: 30px;
            font-size: 20px;
        }

        .card {
            height: auto;
            text-align: center !important
        }

        * {
            text-align: center !important;
            direction: rtl !important;
            font
        }

        .gradient-2,
        .dropdown-mega-menu .ext-link.link-3 a {
            background-image: linear-gradient(230deg, #759bff, #843cf6);
        }

        .far {
            font-weight: 400;
            font-size: 60px;
            position: relative;
            top: -15px;
        }
    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item ">قسم تقارير اتمام مرحلة</a>
        <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('content')
    <div class="container-fluid mt-3" style="padding-bottom: 55px;padding-top: 55px;">

        <div class="row justify-content-center">


            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="{{route('phase_documents_students_7_to_9')}}">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <span class="float-left display-2 opacity-5"><i class="far  fa-calendar"></i></span>
                            <h2 class="text-white" style="text-align: right;">وثائق اتمام مرحلة التعليم الابتدائي</h2>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="{{route('phase_documents_students_10_to_11')}}">

                    <div class="card gradient-2">
                        <div class="card-body">
                            <span class="float-left display-2 opacity-5"><i class="far  fa-calendar"></i></span>
                            <h2 class="text-white" style="text-align: right;"> وثائق اتمام مرحلة الصف التاسع</h2>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6"style="    padding-right: 0px;">
                <a href="{{route('phase_documents_students_12')}}">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <span class="float-left display-2 opacity-5"><i class="far  fa-calendar"></i></span>
                            <h2 class="text-white" style="text-align: right;">  وثائق اتمام مرحلة الثالث الثانوي   </h2>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
@endsection
