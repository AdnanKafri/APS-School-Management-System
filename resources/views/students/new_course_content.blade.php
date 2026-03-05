@extends('students.layouts.app2')
@section('title')
School
@endsection
@section('css')
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/responsive.css') }}">
@endsection
@section('new-content')
    <main>
        <!--? slider Area Start-->
        <section class="slider-area slider-area2" style="height: 350px;">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Courses</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">Course</a></li>
                                            <li class="breadcrumb-item"><a href="#">Course-Content</a></li>
                                        </ol>
                                    </nav>
                                    <!-- breadcrumb End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--? top subjects Area Start -->
        <div class="topic-area section-padding40" id="mycourse">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">

                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($lesson->book1 != null)

                        <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-down"
                        data-aos-easing="linear"
                        data-aos-duration="1000">

                                <div class="topic-img">
                                <a href="@if ($lesson->type_file1== '0')
                                    {{$lesson->book1}}
                                    @else
                                    {{ asset('storage/'.$lesson->book1) }}
                                    @endif" target="_blank"><img src="{{ asset('student-UI/assets/img/blog/icons8-export-pdf-100.png') }}" alt=""></a>
                                    <div class="topic-content-box">
                                        <div class="topic-content">
                                            <!--h3><a href="courses.html">Programing</a></h3-->
                                        </div>
                                    </div>
                                </div>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i> {{ $lesson->name_book1_ar }}</a></li>
                                    <!--li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li-->
                                </ul>

                        </div>
                        @endif
                    @if ($lesson->book2 != null)

                        <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-down"
                        data-aos-easing="linear"
                        data-aos-duration="1000">

                                <div class="topic-img">
                                <a href="@if ($lesson->type_file1== '0')
                                    {{$lesson->book2}}
                                    @else
                                    {{ asset('storage/'.$lesson->book2) }}
                                    @endif" target="_blank"><img src="{{ asset('student-UI/assets/img/blog/icons8-export-pdf-100.png') }}" alt=""></a>
                                    <div class="topic-content-box">
                                        <div class="topic-content">
                                            <!--h3><a href="courses.html">Programing</a></h3-->
                                        </div>
                                    </div>
                                </div>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i> {{ $lesson->name_book2_ar }}</a></li>
                                    <!--li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li-->
                                </ul>

                        </div>
                        @endif
                    @if ($lesson->book3 != null)

                        <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-down"
                        data-aos-easing="linear"
                        data-aos-duration="1000">

                                <div class="topic-img">
                                <a href="@if ($lesson->type_file1== '0')
                                    {{$lesson->book3}}
                                    @else
                                    {{ asset('storage/'.$lesson->book3) }}
                                    @endif" target="_blank"><img src="{{ asset('student-UI/assets/img/blog/icons8-export-pdf-100.png') }}" alt=""></a>
                                    <div class="topic-content-box">
                                        <div class="topic-content">
                                            <!--h3><a href="courses.html">Programing</a></h3-->
                                        </div>
                                    </div>
                                </div>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i> {{ $lesson->name_book3_ar }}</a></li>
                                    <!--li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li-->
                                </ul>

                        </div>
                        @endif
                        @if ($lesson->book4 != null)

                        <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-down"
                        data-aos-easing="linear"
                        data-aos-duration="1000">

                                <div class="topic-img">
                                <a href="@if ($lesson->type_file4== '0')
                                    {{$lesson->book4}}
                                    @else
                                    {{ asset('storage/'.$lesson->book4) }}
                                    @endif" target="_blank"><img src="{{ asset('student-UI/assets/img/blog/icons8-export-pdf-100.png') }}" alt=""></a>
                                    <div class="topic-content-box">
                                        <div class="topic-content">
                                            <!--h3><a href="courses.html">Programing</a></h3-->
                                        </div>
                                    </div>
                                </div>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i> {{ $lesson->name_book4_ar }}</a></li>
                                    <!--li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li-->
                                </ul>

                        </div>
                        @endif


                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>



                </div>

            </div>
        </div>
        <!-- top subjects End -->
        <!-- Blog Area End -->
    </main>

      <!-- Scroll Up -->
      <div id="back-top" >
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
    @endsection
    <!-- JS here -->
    @section('js-scripts')
        <script src="{{ asset('student-UI/./assets/js/jquery.form.js') }}"></script>
    @endsection


