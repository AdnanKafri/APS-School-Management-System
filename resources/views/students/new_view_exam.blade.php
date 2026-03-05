<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    {{-- <link rel="stylesheet" href="fonts/icomoon/style.css"> --}}
    <link rel="stylesheet" href="{{ asset('student-UI/fonts/icomoon/style.css') }}">



    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/bootstrap.min.css') }}">


    <!-- Style -->
    {{-- <link rel="stylesheet" href="css/style.css"> --}}
    <link rel="stylesheet" href="{{ asset('student-UI/assets/css/style.css') }}">

    {{-- <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

    <title> الامتحان  </title>
    <style>

.group {
  display: flex;
  align-items: center;
  margin-bottom: 2em;
  direction: rtl;
  text-align: right;

}
input[type="checkbox"], input[type="radio"] {
  position: absolute;
  opacity: 0;
  z-index: -1;
  direction: rtl;
  text-align: right;
}

label {
  color: black;
  font-size: 16px;
  position: relative;
  margin-right: 1em;
  padding-left: 2em;
  padding-right: 1em;
  line-height: 2;
  cursor: pointer;
  direction: rtl;
  text-align: right;
}
label:before {
  box-sizing: border-box;
  content: " ";
  position: absolute;
  top: 0.3em;
  left: 0;
  display: block;
  width: 1.4em;
  height: 1.4em;
  border: 2px solid black;
  border-radius: 0.25em;
  z-index: -1;
}
input[type="radio"] + label::before {
  border-radius: 1em;
}
/* Checked */
input[type="checkbox"]:checked + label, input[type="radio"]:checked + label {
  padding-left: 1em;
  background-color: #94a3ec;
  border-radius: 0.75em;
  color: white;
}
input[type="checkbox"]:checked + label:before, input[type="radio"]:checked + label:before {
  top: 0;
  width: 100%;
  height: 2em;
  background: white;
}
/* Transition */
label, label::before {
  -webkit-transition: 0.25s all ease;
  -o-transition: 0.25s all ease;
  transition: 0.25s all ease;

}
input[type="submit"] {
  background-color: #212d63;
  border: none;
  border-color: #212d63;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
border-radius: 50px;
justify-content: center;
margin: auto;
  font-size: 16px;
  display: flex;


}

    </style>

  </head>
  <body >

  <div class="content" style="direction: rtl; text-align: right;">

    <div class="container">
      <div class="row align-items-stretch no-gutters contact-wrap">
        <div class="col-md-12">
          <div class="form h-100">

            <h3 class="text-center " > {{ $content_name }} </h3>

            <form class="mb-5"  method="post" id="contactForm" name="contactForm">

                @foreach ($questions  as $question )

                @if ($question->section)
                {{-- @dd($question->section) --}}
                    @if ($question->section->type=='0')

                         <h2 style="font-weight:bold;font-size:22px">please reade the text then answer the questions</h2>

                         <p style="direction: ltr; text-align:left">

                            {{ $question->section->content }}
                        </p>

                    @elseif ($question->section->type=='1')
                         <h2> please look at the image below then answer the questions </h2>

                        <img src="{{ asset('storage/'.$question->section->content) }}"  >
                        <br>
                        <br>


                    @elseif($question->section->type=='2')
                         <h2>  please listen to the audio then answer the questions </h2>

                        <audio src="{{ asset('storage/'.$question->section->content) }}" controls  ></audio>
                        <br>
                        <br>
                    @endif

                    @endif

                @if($question->question_type == 1)

                    <h2 style="font-weight:bold;font-size:22px">{{  $question->question_form }}</h2>

                    <textarea name="content" class="form-control" style="direction:rtl; text-align: right;" cols="3" rows="2">

                    </textarea>
                    <br>
                    <br>


                @elseif($question->question_type == 2)
                @php
                    $options = json_decode($question->options->my_options,true) ;
                @endphp
                    {{-- @dd($question) --}}
                <h2 style="font-weight:bold;font-size:22px">{{  $question->question_form }}</h2>
                    <br>
                    <div class="group" style="direction: rtl; text-align: right;">
                        @foreach ($options as $key => $option)


                            <input type="checkbox" name="rb{{ $question ->id }}{{ $key }}" id="rb{{ $question ->id }}{{ $key }}"   />
                            <label for="rb{{ $question ->id }}{{ $key }}">{{ $option }}</label>
                        @endforeach
                    </div>

                @endif
                @endforeach

                   <br>
                   {{-- <input type="submit" class="btn btn-primary" style="width: 100px;" value="حفظ"> --}}
                   <div class="row text-center">
                        <a class="btn btn-primary text-center" style="width: 100px;padding: 8px 2px; font-size:18px"
                        href="{{ url()->previous()  }}">عودة</a>
                    </div>
                </div>

                 <!-- end question-->



            </form>

            <!--div id="form-message-warning mt-4"></div>
            <div id="form-message-success">
              Your message was sent, thank you!
            </div-->

          </div>
        </div>
      </div>
    </div>

  </div>


    {{-- <script src="index.js"></script> --}}
    {{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
    <script src="{{ asset('student-UI/assets/exam-add-questions/vendor/jquery/jquery-3.2.1.min.js') }}"></script>

    {{-- <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('student-UI/assets/exam-add-questions/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('student-UI/assets/exam-add-questions/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    {{-- <script src="js/jquery.validate.min.js"></script> --}}
    {{-- <script src="js/main.js"></script> --}}
    <script src="{{ asset('student-UI/assets/exam-add-questions/js/main.js') }}"></script>


  </body>
</html>
