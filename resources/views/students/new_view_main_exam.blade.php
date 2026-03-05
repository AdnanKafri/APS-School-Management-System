<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('edit-question/fonts/icomoon/style.css')}}">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('edit-question/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href=" {{ asset('edit-question/css/style.css')}}">
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <title> {{ $exam->name }}  </title>
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

<body style="background-color: #4972a84a;
  background-size: cover;">

    <div class="content" style="direction: rtl; text-align: right;">

        <div class="container">
            <div class="row align-items-stretch no-gutters contact-wrap"style="border-radius: 10px;">
                <div class="col-md-12">
                    <div class="form h-100" style="border-radius: 15px;">
                        <div style="float: left;">
                            <div class="row">
                             <h7 style="padding-top:5px">  المادة :</h7>
                              <input style="width: 190px; text-align: center;margin-top: 10px; height : 20px !important;"
                              class=" form-control" type="text" value="{{$lesson_name}}" readonly>
                            </div>

                            <div class="row">
                              <h7 style="padding-top:5px">  الصف:</h7>
                               <input
                               style="width: 190px; text-align: center;margin-top: 10px;  height : 20px !important;"
                               class="common-input mb-20 form-control" type="text"
                               value="{{$class_name}}" readonly>
                             </div>

                             <div class="row">
                              <h7 style="padding-top:5px">  الشعبة :</h7>
                               <input style="width: 190px; text-align: center;margin-top: 10px;  height : 20px !important;"
                               class="common-input mb-20 form-control" type="text"
                               value="{{$room_name}}" readonly>
                             </div>

                             <div class="row">
                              <h7 style="padding-top:5px">  الفصل:</h7>
                               <input style="width: 190px; text-align: center;margin-top: 10px;   height : 20px !important;"
                               class="common-input mb-20 form-control" type="text"
                               value="{{ $term_name }}" readonly>
                             </div>

                             <div class="row">
                              <h7 style="padding-top:5px">  العام الدراسي :</h7>
                               <input style="width: 150px; text-align: center;margin-top: 10px;   height : 20px !important;"
                               class="common-input mb-20 form-control" type="text"
                               value="{{ $year }}" readonly>
                             </div>

                             <div class="row">
                              <h7 style="padding-top:5px">  زمن الاجابة :</h7>
                               <input style="width: 150px; text-align: center;margin-top: 10px;   height : 20px !important;"
                               class="common-input mb-20 form-control" type="text"
                               value="{{ 60  .' دقيقة '}}" readonly>
                             </div>
                            </div>
                          <div  class="row" style="margin-right: 460px;">
                            <img src="{{ asset('teachers/photo/shaar3.png')}}" style="width:110px ;height:110px;">
                          </div>

                               <h3 style="margin-top: -100px;color: #094e89;">   {{$school_data->name}}     </h3>
                                <h4 style="color: #094e89;"> مديرية التربية في  دمشق </h4>





                              <br>
                              <br>
                        <h3>اسم الطالب : {{ $student->first_name }} {{ $student->last_name }}</h3>
                        <h3>عنوان الامتحان: {{ $exam->name }} </h3>
                        <h4 style="float: left; color: #f38639;"> علامة الطالب <button
                                class="btn btn-primary">{{ $exam_result->result }} </button> </h4>
                        <h4 style="color: #f38639;" > العلامة الكلية <button class="btn btn-primary">{{ $exam->mark }} </button> </h4>
                        <span style="width:100%;color:#ccc;border:1 px solid black;"> </span>
                        <br>
                        <br>
                        <h4 style="float: left;">العلامة </h4>
                           <input type="hidden" name="exam_result_id" value="{{ $exam_result->id }}">
                           @php
                            $i=1;
                            @endphp

                            @foreach ($with_section_questions as $question)

                            @php
                            $count=0;

                            $same_section=0;
                            @endphp

                            @if ( $same_section != $question->section->id )

                                @php
                                    $same_section=$question->section->id
                                @endphp
                               <hr>
                                @if ($question->section->type=='0')
                                    <h2 style="font-weight:bold;font-size:22px">please reade the text then answer the questions</h2>

                                    <p style="direction: ltr; text-align:left">

                                        {{ $question->section->content }}
                                    </p>
                                @endif
                                @if ($question->section->type=='3')
                                     <h2 style="font-weight:bold;font-size:22px"> please look at the image below then answer the questions </h2>

                                    <img src="{{ asset('storage/'.$question->section->content) }}"  >
                                    <br>
                                    <br>
                                @endif

                                @if($question->section->type=='2')
                                    <h2 style="font-weight:bold;font-size:22px">  please listen to the audio then answer the questions </h2>

                                         <audio src="{{ asset('storage/'.$question->section->content) }}" controls  ></audio>
                                         <br>
                                         <br>
                                @endif
                            @endif
                            <div style></div>
                            <h2>
                                  <span style="font-size: 14px;">
                                    {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i>
                                  </span>
                                {{ $question->question_form }}</h2>

                                @if ($question->ques_type=='1')


                                <br>
                                <div class="group"
                                    style="direction: rtl; text-align: right; color:green ;display: inline-block;">
                                    @foreach (json_decode($question->option->myOptions,true) as $item)

                                        <input type="checkbox" name="rb" id="rb{{ $item }}"

                                            @if($exam_result->user_answers )
                                                @foreach (json_decode($exam_result->user_answers,true) as $key=>$value)

                                                    @if ($key == $question->id)

                                                        @if ( in_array($item,$value ))
                                                            checked
                                                        @endif

                                                    @endif

                                                @endforeach

                                            @endif
                                        disabled >

                                        @if (in_array($item, json_decode($question->answer,true)))

                                            <label for="rb{{ $item }}" style="color: green">{{ $item }}</label>

                                        @else
                                             @if($exam_result->user_answers)
                                            @php
                                             $user_answers =   json_decode($exam_result->user_answers,true);
                                            @endphp
                                                @foreach ($user_answers as $key=>$value)


                                                    @if ($key == $question->id)

                                                        @if (isset($value[0]) && in_array($item, $value))

                                                            <label for="rb{{ $item }}" style="color: red">{{ $item }}</label>

                                                         @else

                                                             <label for="rb{{ $item }}">{{ $item }}</label>

                                                        @endif

                                                    @break
                                                    @else


                                                        @if ($key === array_key_last($user_answers ))
                                                             <label for="rb{{ $item }}">{{ $item }}</label>
                                                        @endif


                                                    @endif



                                                @endforeach

                                            @else

                                            <label for="rb{{ $item }}">{{ $item }}</label>

                                            @endif
                                        @endif

                                        @if (in_array($item, json_decode($question->answer,true)))
                                            @php
                                            $a=0;
                                            @endphp

                                            @if($exam_result->user_answers )

                                                @foreach (json_decode($exam_result->user_answers,true) as $key=>$value)

                                                    @if ($key == $question->id)

                                                        @php
                                                        $a=0;
                                                            if (json_decode($question->answer,true)==$value) {

                                                            $a=1;
                                                            }

                                                        $diff=array_diff(json_decode($question->answer,true),$value);
                                                        $diff2=array_diff($value,json_decode($question->answer,true));

                                                        @endphp

                                                        @foreach ( $value as $item2)

                                                            @if ($item2==$item)

                                                                @if (! in_array($item2, json_decode($question->answer,true)))
                                                                <label for="rb{{ $item }}" style="color: red">{{ $item }}</label>

                                                                @endif
                                                            @endif

                                                        @endforeach



                                                    @endif


                                                @endforeach


                                            @endif


                                        @endif

                                        @endforeach
                                </div>
                                <div style="float: left;" style="display: inline-block;">
                                    <input style="height: 50px; width:60px ;text-align: center; " class="deservedMark1"
                                        name="mark[]" readonly="" type="text" @if ($a==0) value="0" @else
                                        value="{{ $question->mark }}" @endif>
                                        <input hidden   name="mark0"   type="text" value="{{ $question->mark }}" >
                                    <button class="btn btn-primary "
                                        style="height: 50px; width:60px ;">{{ $question->mark }}</button>
                                </div>
                                @else
                                @if($exam_result->user_answers)

                                    @foreach (json_decode($exam_result->user_answers,true) as $key=>$user_answer)

                                            @if ($key == $question->id)

                                                <div style="float: left;">
                                                    <input style="height: 50px; width:60px ;text-align: center; "
                                                        name="traditional_result[{{ $question->id }}]" placeholder="" type="text" readonly
                                                    @if ($exam_result->traditional_result!=null)

                                                        @foreach (json_decode($exam_result->traditional_result,true) as $key=>$value)

                                                            @if ($key == $question->id)

                                                            value="{{ $value }}"

                                                            @endif


                                                        @endforeach

                                                    @endif>

                                                    <button class="btn btn-primary" style="height: 50px; width:60px ;">{{$question->mark}}</button>
                                                </div>

                                                <br>

                                                <p name="content"

                                                    class=""
                                                        style="direction:rtl; text-align: right;" >



                                                                {{ $user_answer[0] }}



                                                </p>




                                            @endif
                                    @endforeach
                                @else


                                    <div style="float: left;">
                                        <input style="height: 50px; width:60px ;text-align: center; "
                                            name="traditional_result[{{ $question->id }}]" placeholder="" type="text"
                                            >

                                            <input hidden   name="mark0"   type="text" value="{{ $question->mark }}" >
                                        <button class="btn btn-primary" style="height: 50px; width:60px ;">{{ $question->mark }}</button>
                                    </div>

                                    <br>


                                    <textarea name="content" value="" class="form-control"
                                        style="direction:rtl; text-align: right;" cols="3" rows="2">
                                    </textarea>
                                    <br>
                                @endif



                        <!-- end question-->

                        @endif
                                                            <br><br>
                    @endforeach
                    @foreach ($normal_questions as $question)

                            @php
                            $count=0;

                            @endphp
                            <div style></div>
                            <h2>
                                  <span style="font-size: 14px;">
                                    {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i>
                                  </span>
                                {{ $question->question_form }}</h2>

                                @if ($question->ques_type=='1')


                                <br>
                                <div class="group"
                                    style="direction: rtl; text-align: right; color:green ;display: inline-block;">
                                    @foreach (json_decode($question->option->myOptions,true) as $item)

                                        <input type="checkbox" name="rb" id="rb{{ $item }}"

                                            @if($exam_result->user_answers )
                                                @foreach (json_decode($exam_result->user_answers,true) as $key=>$value)

                                                    @if ($key == $question->id)

                                                        @if ( in_array($item,$value ))
                                                            checked
                                                        @endif

                                                    @endif

                                                @endforeach

                                            @endif
                                        disabled >

                                        @if (in_array($item, json_decode($question->answer,true)))

                                            <label for="rb{{ $item }}" style="color: green">{{ $item }}</label>

                                        @else
                                             @if($exam_result->user_answers)
                                            @php
                                             $user_answers =   json_decode($exam_result->user_answers,true);
                                            @endphp
                                                @foreach ($user_answers as $key=>$value)


                                                    @if ($key == $question->id)

                                                        @if (isset($value[0]) && in_array($item, $value))

                                                            <label for="rb{{ $item }}" style="color: red">{{ $item }}</label>

                                                         @else

                                                             <label for="rb{{ $item }}">{{ $item }}</label>

                                                        @endif

                                                    @break
                                                    @else


                                                        @if ($key === array_key_last($user_answers ))
                                                             <label for="rb{{ $item }}">{{ $item }}</label>
                                                        @endif


                                                    @endif



                                                @endforeach

                                            @else

                                            <label for="rb{{ $item }}">{{ $item }}</label>

                                            @endif
                                        @endif

                                        @if (in_array($item, json_decode($question->answer,true)))
                                            @php
                                            $a=0;
                                            @endphp

                                            @if($exam_result->user_answers )

                                                @foreach (json_decode($exam_result->user_answers,true) as $key=>$value)

                                                    @if ($key == $question->id)

                                                        @php
                                                        $a=0;
                                                            if (json_decode($question->answer,true)==$value) {

                                                            $a=1;
                                                            }

                                                        $diff=array_diff(json_decode($question->answer,true),$value);
                                                        $diff2=array_diff($value,json_decode($question->answer,true));

                                                        @endphp

                                                        @foreach ( $value as $item2)

                                                            @if ($item2==$item)

                                                                @if (! in_array($item2, json_decode($question->answer,true)))
                                                                <label for="rb{{ $item }}" style="color: red">{{ $item }}</label>

                                                                @endif
                                                            @endif

                                                        @endforeach



                                                    @endif


                                                @endforeach


                                            @endif


                                        @endif

                                        @endforeach
                                </div>
                                <div style="float: left;" style="display: inline-block;">
                                    <input style="height: 50px; width:60px ;text-align: center; " class="deservedMark1"
                                        name="mark[]" readonly="" type="text" @if ($a==0) value="0" @else
                                        value="{{ $question->mark }}" @endif>
                                        <input hidden   name="mark0"   type="text" value="{{ $question->mark }}" >
                                    <button class="btn btn-primary "
                                        style="height: 50px; width:60px ;">{{ $question->mark }}</button>
                                </div>
                                @else
                                @if($exam_result->user_answers)

                                    @foreach (json_decode($exam_result->user_answers,true) as $key=>$user_answer)

                                            @if ($key == $question->id)

                                                <div style="float: left;">
                                                    <input style="height: 50px; width:60px ;text-align: center; "
                                                        name="traditional_result[{{ $question->id }}]" placeholder="" type="text" readonly
                                                    @if ($exam_result->traditional_result!=null)

                                                        @foreach (json_decode($exam_result->traditional_result,true) as $key=>$value)

                                                            @if ($key == $question->id)

                                                            value="{{ $value }}"

                                                            @endif


                                                        @endforeach

                                                    @endif>

                                                    <button class="btn btn-primary" style="height: 50px; width:60px ;">{{$question->mark}}</button>
                                                </div>

                                                <br>

                                                <p name="content"

                                                    class=""
                                                        style="direction:rtl; text-align: right;" >



                                                                {{ $user_answer[0] }}



                                                </p>




                                            @endif
                                    @endforeach
                                @else


                                    <div style="float: left;">
                                        <input style="height: 50px; width:60px ;text-align: center; "
                                            name="traditional_result[{{ $question->id }}]" placeholder="" type="text" readonly
                                            >

                                            <input hidden   name="mark0"   type="text" value="{{ $question->mark }}" >
                                        <button class="btn btn-primary" style="height: 50px; width:60px ;">{{ $question->mark }}</button>
                                    </div>

                                    <br>


                                    <textarea name="content" value="" class="form-control"
                                        style="direction:rtl; text-align: right;" cols="3" rows="2">
                                    </textarea>
                                    <br>
                                @endif



                        <!-- end question-->

                        @endif
                                                            <br><br>
                    @endforeach

                     <hr>
                    <hr style="width:75%">
                    <hr style="width:50%">
                    <p> النهاية .. مع تمنياتنا بالتوفيق لجميع الطلاب. </p>

            </div>
                    <!--div id="form-message-warning mt-4"></div>
            <div id="form-message-success">
              Your message was sent, thank you!
            </div-->

                </div>
            </div>
        </div>
    </div>

    </div>
    <script src=" {{ asset('edit-question/index.js')}} "></script>
    <script src=" {{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/popper.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery.validate.min.js')}} "></script>
    <script src="{{ asset('edit-question/js/main.js')}} "></script>

</body>

</html>
