    @extends('students.layouts.app3')
    @section('css')
        <link rel="stylesheet" href="{{ asset('student-UI/assets/css/responsive.css') }}">
    <style>
        div#ui_notifIt p{
            color: #fff !important;
        }
    </style>
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
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Exams</h1>
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">Exams</a></li>
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

        <!-- top subjects End -->
        <section class="team-area section-padding40 fix" id="event">
            <div class="container">
            @section('js-scripts')
                @if (session()->has('no_questions'))

                <script>
                    window.onload = function() {
                        notif({
                            msg: "  الامتحان لايحوي أسئلة ",
                            type: "error"
                        })
                    }

                </script>
            @endif
                @if (session()->has('success'))

                <script>
                    window.onload = function() {
                        notif({
                            msg: " تم تخزين  الامتحان بنجاح   ",
                            type: "success"
                        })
                    }

                </script>
            @endif
                @if (session()->has('warning'))

                <script>
                    window.onload = function() {
                        notif({
                            msg: "    عذراً, لا يمكن تقديم الامتحان مرتين    ",
                            type: "warning"
                        })
                    }

                </script>
            @endif
                @if (session()->has('file_error2'))

                <script>
                    window.onload = function() {
                        notif({
                            msg: "  قم بإضافة ملف للمحتوى   ",
                            type: "error"
                        })
                    }

                </script>
            @endif
            @if ($errors->any())

                    @foreach ($errors->all() as $error)
                    {{-- <li>{{ $error }}</li> --}}
                    <script>
                        window.onload = function() {
                            notif({
                                msg: `{{  $error }}`  ,
                                type: "error"
                            })
                        }

                    </script>
                    @endforeach

            @endif
            @endsection
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>Lesson's exams</h2>
                        </div>
                    </div>
                </div>

                <div class="team-active">
                    @if (isset($lesson_details))
                        @foreach ($lesson_details as $item)
                        @if ($item->type=='3')
                        <div class="single-cat text-center">
                            <div class="cat-icon">
                                <img src="{{ asset('student-UI/exam.JPG') }}" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="#">  {{ $item->exam_title }}</a></h5>
                                <h4><a href="#">  {{ $item->start_time }}</a></h4>
                                <div class="button-group-area mt-40">

                                    <a @if($item->type_file=='1')
                                                href="  {{ $item->exam }}"
                                        @elseif($item->type_file=='0')
                                                href="  {{ asset('storage/'.$item->video) }}"
                                        @else
                                        {{-- automated exam --}}
                                        href="{{ route('dashboard.student.exam.start_exam',$item->id) }}"
                                        @endif
                                        class="genric-btn info circle" target="_blank">
                                        @if ($now > $item->start_time && $now < $item->end_time)
                                           ابدأ الامتحان
                                        @elseif($now > $item->end_time)
                                         انتهى
                                        @else
                                        مخطط له
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                </div>
            </div>
        </section>
        <!-- Blog Area End -->
    </main>

      <!-- Scroll Up -->
      <div id="back-top" >
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
    @endsection
    <!-- JS here -->
    @section('js-scripts')
    <!-- contact js -->
    <script src="{{ asset('student-UI/./assets/js/jquery.form.js') }}"></script>
    <script>
    AOS.init();
   </script>
    @endsection

