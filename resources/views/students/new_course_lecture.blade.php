@extends('students.layouts.app2')
@section('title')
School
@endsection
@section('css')

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/progressbar_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/animated-headline.css') }}">
    <!--====== AOS ======-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @section('new-content')
    <main>
        <!--? slider Area Start-->
        <section class="slider-area slider-area2" style="height: 200px;">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <!--h2 data-animation="bounceIn" data-delay="0.2s">My Lessons</h2-->
                                    <!-- breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#">Course</a></li>
                                            <li class="breadcrumb-item"><a href="#">Lectures</a></li>
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

        <!-- Courses area start -->
        <div class="courses-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <h2>قائمة الدروس</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center"  >

                    @foreach ($lectures as $lecture)
                    <div class="col-lg-4" data-aos="fade-up"  data-aos-delay="500"data-aos-duration="1000">
                        <div class="properties properties2 mb-30">
                            <div class="properties__card">
                                <div class="properties__img overlay1">
                                    <a href="#"><img src="{{ asset('student-UI/assets/img/gallery/featured1.png') }}" alt=""></a>
                                </div>
                                <div class="properties__caption" style="direction:rtl;text-align:right">
                                    {{-- <p>اسم المادة</p> --}}
                                    <h3><a href="#">{{ $lecture->name }}</a></h3><br>
                                    <div class="row" data-aos="fade-up"  data-aos-delay="500"data-aos-duration="1000">
                                        <a href="{{ route('dashboard.student.course.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id]) }}" style="margin-right: 0px"><img src="{{ asset('student-UI/icoo/icons8-content-38.png') }}" alt="" style="margin-right: 13px"><h4> المحتوى العلمي</h4></a>&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.extra_files', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-lessons-38.png') }} " alt=""><h4>ملفات أخرى</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.video', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-video-38.png') }}" alt=""><h4>فيديوهات</h4></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.audio', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-audio-38.png') }}" alt=""><h4>صوتيات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.homework', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}" style="margin-right:10px"><img src="{{ asset('student-UI/icoo/icons8-homework-38.png') }}" alt="" ><h4>وظائف</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.quize', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-quiz-38.png') }}" alt=""><h4>مذاكرات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.exam', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-exam-38.png') }}" alt=""><h4>امتحانات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.marks', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id]) }}"><img src="{{ asset('student-UI/icoo/icons8-test-passed-38.png') }}" alt=""><h4>العلامات</h4></a>
                                    </div>
                                    {{-- <div class="row" data-aos="fade-up"  data-aos-delay="500"data-aos-duration="1000">
                                        <a href="{{ route('dashboard.student.course.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id]) }}" style="margin-right: 0px"><img src="{{ asset('student-UI/icoo/icons8-content-38.png') }}" alt="" style="margin-right: 13px"><h4> المحتوى العلمي</h4></a>&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,0]) }}"><img src="{{ asset('student-UI/icoo/icons8-lessons-38.png') }} " alt=""><h4>ملفات أخرى</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,1]) }}"><img src="{{ asset('student-UI/icoo/icons8-video-38.png') }}" alt=""><h4>فيديوهات</h4></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,2]) }}"><img src="{{ asset('student-UI/icoo/icons8-audio-38.png') }}" alt=""><h4>صوتيات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,3]) }}" style="margin-right:10px"><img src="{{ asset('student-UI/icoo/icons8-homework-38.png') }}" alt="" ><h4>وظائف</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,4]) }}"><img src="{{ asset('student-UI/icoo/icons8-quiz-38.png') }}" alt=""><h4>مذاكرات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('dashboard.student.lesson.lecture.content', ['lesson_id' => $lesson->id,'student_id' =>$student->id,'lecture_id' => $lecture->id,5]) }}"><img src="{{ asset('student-UI/icoo/icons8-exam-38.png') }}" alt=""><h4>امتحانات</h4></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#"><img src="{{ asset('student-UI/icoo/icons8-test-passed-38.png') }}" alt=""><h4>العلامات</h4></a>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                </div>
            </div>
        </div>

    </main>

      <!-- Scroll Up -->
      <div id="back-top" >
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>
@endsection
@section('js-scripts')
    <!-- JS here -->
    <!-- Jquery Mobile Menu -->

    <!-- Progress -->
    <script src="{{ asset('student-UI/./assets/js/jquery.barfiller.js') }}"></script>

    <!-- contact js -->
    <script src="{{ asset('student-UI/./assets/js/jquery.form.js') }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('student-UI/./assets/js/plugins.js') }}"></script>
    <script src="{{ asset('student-UI/./assets/js/main.js') }}"></script>
    <!--====== AOS js ======-->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init();
   </script>
@endsection


