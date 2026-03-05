@extends('admin.master')

@section('content')

            <div class="container-fluid mt-3">
                <div class="row">
                   
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('teachers') }}">
                            <div class="card gradient-4">
                                <div class="card-body">

                                    <span class="float-left display-2 opacity-5"><i class="	fas fa-chalkboard-teacher	"></i></span>
                                    <h2 class="text-white" style="text-align: right;">قسم المعلمين</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	fas fa-home"></i></span>
                                <h2 class="text-white" style="text-align: right;">الصفحة الرئيسية  </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-id-badge"></i></span>
                                <h2 class="text-white" style="text-align: right;">اتصل بنا </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('lessons') }}">
                        <div class="card gradient-3">
                            <div class="card-body">

                              <span class="float-left display-2 opacity-5"><i class="fas fa-newspaper-o"></i></span>
                              <h2 class="text-white" style="text-align: right;">   الاخبار </h2>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa fa-map"></i></span>
                                <h2 class="text-white" style="text-align: right;">من نحن </h2>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

        @endsection

