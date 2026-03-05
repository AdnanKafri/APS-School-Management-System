@extends('admin.master')

@section('content')

            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5" ><i class="far fa-edit"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم التسجيل والقبول</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fa fa-money"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم متابعة الأقساط المالية</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('students') }}">
                            <div class="card gradient-3">
                                <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-user-alt"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم شؤون الطلاب</h2>
                                </div>
                            </div>
                        </a>
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

                                <span class="float-left display-2 opacity-5"><i class="	fas fa-pen-alt"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم المنسقين</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-sticky-note"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم الموجهين</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('lessons') }}">
                        <div class="card gradient-3">
                            <div class="card-body">

                              <span class="float-left display-2 opacity-5"><i class="fas fa-bars"></i></span>
                              <h2 class="text-white" style="text-align: right;">قسم المناهج </h2>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-user-tie"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم المشرفين التربويين</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('backups') }}">
                        <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-archive"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم النسخ الاحتياطي</h2>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="far fa-calendar-alt"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم برنامج الدوام و الاختبارات</h2>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	fas fa-user-clock"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم متابعة المدير للحصص مباشرة</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="	far fa-file-alt"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم التقارير والاحصائيات</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-book-open"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم توليد الجلاءات</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="far fa-id-badge"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم صلاحيات المستخدم</h2>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-phone-volume"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم التواصل</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-user-friends"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم التوظيف</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
               
                    <div class="col-lg-3 col-sm-6">
                         <a href="{{ route(' websitecontroller') }}">
                        <div class="card gradient-1">
                            <div class="card-body">

                                <span class="float-left display-2 opacity-5"><i class="fas fa-user-cog"></i></span>
                                <h2 class="text-white" style="text-align: right;">قسم التحكم الكامل بالموقع </h2>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('classes') }}">
                            <div class="card gradient-2">
                                <div class="card-body">

                                    <span class="float-left display-2 opacity-5"><i class="far fa-building"></i></span>
                                    <h2 class="text-white" style="text-align: right;">قسم الصفوف</h2>

                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <a href="{{ route('sessions') }}">
                            <div class="card gradient-3">
                                <div class="card-body">

                                    <span class="float-left display-2 opacity-5"><i class="far fa-building"></i></span>
                                    <h2 class="text-white" style="text-align: right;">قسم الحصص</h2>

                                </div>
                            </div>
                        </a>
                    </div>



                </div>
        </div>

        @endsection

