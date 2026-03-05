@extends('students.layouts.app2')
@section('css')
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('student-UI/./table-03/css/style.css') }}">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Marks</h1>
                                    <!-- breadcrumb Start-->
                                    <!--nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">Lesson</a></li>
                                        </ol>
                                    </nav-->
                                    <!-- breadcrumb End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section"  data-aos="zoom-in"  data-aos-delay="500"data-aos-duration="1000">
		<div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Marks of homework</h2>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">

					<div class="table-wrap">
						<table class="table">
					    <thead class="thead-primary">
					      <tr>
					        <th>Name tests</th>
					        <th>Time </th>
					        <th>Mark</th>
                            <th>show soluation</th>

					      </tr>
					    </thead>
					    <tbody>
					      <tr>


					        <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
					      <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary" style="width: 12px;">Sign Up</a></td-->
					      </tr>
					      <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>

					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	<br>
    <br>
    <br>
    <br>

		<div class="container" data-aos="zoom-in"  data-aos-delay="500"data-aos-duration="1000">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Marks of Exams</h2>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">

					<div class="table-wrap">
						<table class="table">
					    <thead class="thead-primary">
					      <tr>
					        <th>Name tests</th>
					        <th>Time </th>
					        <th>Mark</th>
                            <th>State</th>
                            <th>show soluation</th>

					      </tr>
					    </thead>
					    <tbody>
					      <tr>


					        <td>maths</td>
					        <td>maths</td>
                            <td>30</td>
                            <td>Fail</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
					      <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary" style="width: 12px;">Sign Up</a></td-->
					      </tr>
					      <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
                          <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
                          <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
                          <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>
                          <tr>

                            <td>maths</td>
					        <td>maths</td>
                            <td>80</td>
                            <td>Success</td>
                            <td class="button-group-area mt-40">

                                <a href="#" class="genric-btn info circle">show</a>

                            </td>
					        <!--td><a href="#" class="btn btn-primary">Sign Up</a></td-->
					      </tr>

					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	</section>


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
    <!--table -->
    <script src="{{ asset('student-UI/./table-03/js/jquery.min.js') }}"></script>
    <script src="{{ asset('student-UI/./table-03/popper.js') }}"></script>
    <script src="{{ asset('student-UI/./table-03/bootstrap.min.js') }}"></script>
    <script src="{{ asset('student-UI/./table-03/main.js') }}"></script>
  <!--table-->
@endsection
