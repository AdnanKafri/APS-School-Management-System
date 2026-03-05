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


    <title> {{$exam->name }}   </title>
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
/* watch */
@import url("https://fonts.googleapis.com/css?family=Quicksand&display=swap");



/* body, html {
  height: 100%;
  margin: 0;
  font-family: "Quicksand", sans-serif;
 background-image: linear-gradient(to right bottom, #f0669c, #e75c97, #de5293, #d4488e, #cb3d8a, #c14da5, #b25dbd, #9c6dd1, #6293f5, #00b4ff, #00cefc, #28e5eb);
} */

.bg-img {
  position : absolute;
  background: url("//unsplash.it/600/800") no-repeat;
  height: 100%;
  background-position: center;
  background-size: cover;
  filter: blur(4rem);
  opacity:0.3;
  z-index: -2;
}

.circle-bg{
  position:relative;
  width: 100%;
  height: 100%;
}

.circle{
  position: absolute;
  border-radius : 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index:2;
}

.circle-front {
  width : 8rem;
  height : 8rem;
  z-index: 2;
  box-shadow :  -10px 12px 19px 0 rgba(0,0,0,0.5) inset;
  background-image: linear-gradient(to right bottom, #f0669c,  #d4488e,  #9c6dd1, #6293f5, #00b4ff, #00cefc, #28e5eb);
  display: flex;
  align-items: center;
  justify-content: center;
  color : #BBEDE8;
  font-size: 1.6rem;
  font-weight: 100;
}

.circle-back{
  width : 10rem;
  height : 10rem;
  background:#32E5D3;
  z-index: 1;
  filter: blur(60px);
  opacity: 0.8;
}
p{
  color: #154178;
    font-weight: bold;
}
/*end watch */
    </style>

</head>

<body style="background-color: #4972a84a;
  background-size: cover;">

    <div class="content" style="direction: rtl; text-align: right;">

        <div class="container">
            <div class="row align-items-stretch no-gutters contact-wrap"style="border-radius: 10px;">
                <div class="col-md-12">
                    <div class="form h-100 row" style="border-radius: 15px;">


                            <div class="col-md-4">



                                    <h3 style="color: #094e89;">     {{$school_data->name}}  </h3>
                                    <h4 style="color: #094e89;"> مديرية التربية في  دمشق </h4>

                                    <br>
                                    <br>
                                    <h3>اسم الطالب : {{ $student->first_name }} {{ $student->last_name }}</h3>
                                    <h3> {{ $exam->name }} </h3>

                                    {{-- <h4 style="float: left; color: #f38639;"> علامة الطالب <button class="btn btn-primary" >_ _ _  </button> </h4> --}}
                                    <h4 style="color: #f38639;"> العلامة الكلية  <button class="btn btn-primary" >{{ $exam->mark }} </button> </h4>

                                    <br>
                                    <br>
                            </div>
                            <div  class="col-md-5" >
                                <div class="row">
                                    <img src="{{ asset('teachers/photo/shaar3.png')}}" style="width:110px ;height:110px;margin:auto">
                                </div>
                                <div class="row" style="margin-top: 100px">
                                    <div class="circle-bg" style="margin: 0 auto;text-align:center">
                                        <div class="circle circle-front">
                                            00:00
                                        </div>
                                        <div class="circle circle-back">
                                           00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" >
                                <p style="margin-bottom:0">المادة : {{$lesson_name}}</p>
                                <p style="margin-bottom:0"> الصف : {{$class_name}}</p>
                                <p style="margin-bottom:0"> الشعبة : {{$room_name}}</p>
                                <p style="margin-bottom:0">  الفصل : {{ $term_name }}</p>
                                <p style="margin-bottom:0">  العام الدراسي : {{ $year }}</p>
                                <p style="margin-bottom:0">المدة الزمينة:   {{ $exam->period }} دقيقة  </p>
                                {{-- <div class="">
                                <label style="padding-top:5px">  المادة :</label>
                                <input style="width: 190px; text-align: center;margin-top: 10px;"
                                class=" form-control" type="text" value="{{$lesson_name}}" readonly>
                                </div>

                                <div class="">
                                <label style="padding-top:5px">  الصف:</label>
                                <input
                                style="width: 190px; text-align: center;margin-top: 10px;  height : 20px !important;"
                                class="common-input mb-20 form-control" type="text"
                                value="{{$class_name}}" readonly>
                                </div>

                                <div class="">
                                <h6 style="padding-top:5px">  الشعبة :</h6>
                                <input style="width: 190px; text-align: center;margin-top: 10px;  height : 20px !important;"
                                class="common-input mb-20 form-control" type="text"
                                value="{{$room_name}}" readonly>
                                </div>

                                <div class="">
                                <h6 style="padding-top:5px">  الفصل:</h6>
                                <input style="width: 190px; text-align: center;margin-top: 10px;   height : 20px !important;"
                                class="common-input mb-20 form-control" type="text"
                                value="{{ $term_name }}" readonly>
                                </div>

                                <div class="">
                                <h6 style="padding-top:5px">  العام الدراسي :</h6>
                                <input style="width: 150px; text-align: center;margin-top: 10px;   height : 20px !important;"
                                class="common-input mb-20 form-control" type="text"
                                value="{{ $year }}" readonly>
                                </div>

                                <div class="">
                                <h6 style="padding-top:5px">  زمن الاجابة :</h6>
                                <input style="width: 150px; text-align: center;margin-top: 10px;   height : 20px !important;"
                                class="common-input mb-20 form-control" type="text"
                                value="{{ 60  .' دقيقة '}}" readonly>
                                </div> --}}
                            </div>

                        <div class="form-questions col-md-12" style="margin-top:25px ">

                                <form class="mb-5"  action="{{ route('dashboard.student.save_main_exam') }}" method="post" id="this_exam">

                                @csrf
                                @php
                                    $i=1;
                                    $same_section=0;
                                @endphp
                                    <input type="hidden" name="content_id" value="{{$content_id}}">
                                    <h1 style="margin-bottom:35px;font-size:24px;font-weight:bold">أجب عن الأسئلة التالية:</h1>
                                  @foreach ($with_section_questions as $question)
                                    @if ( $same_section != $question->section->id )

                                        @php
                                            $same_section=$question->section->id
                                        @endphp

                                        @if ($question->section->type=='0')
                                        <hr>
                                        <hr>
                                            <h2 style="font-weight:bold;font-size:22px">please reade the text then answer the questions</h2>
                                            <br><br>
                                            <p style="direction: ltr; text-align:center">

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

                                        <h2>  <span style="font-size: 14px;">
                                        {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i> </span>
                                            {{ $question->question_form }}
                                        </h2>

                                        @if ($question->ques_type=='1')



                                        <br>
                                        <div class="group"
                                            style="direction: rtl; text-align: right; color:green ;display: inline-block;">
                                            @foreach (json_decode($question->option->myOptions,true) as $key => $item)

                                            <input type="checkbox"  id="rb{{ $item.$key.$question->id }}"  name="answer[{{ $question->id }}][]" value="{{ $item }}">
                                            <label for="rb{{ $item.$key.$question->id }}">{{ $item }}</label>

                                            @endforeach
                                        </div>

                                        @else



                                        <textarea name="answer[{{ $question->id }}][]" value="" class="form-control"
                                            style="direction:rtl; text-align: right;" cols="3" rows="2">
                                        </textarea>
                                        <input type="hidden" name="traditional" value="true">

                                        <br>

                                        <br>




                                <!-- end question-->

                                    @endif
                            @endforeach
                            @foreach ($normal_questions as $question)

                                <h2>  <span style="font-size: 14px;">
                                {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i> </span>
                                    {{ $question->question_form }}
                            </h2>

                                @if ($question->ques_type=='1')



                                <br>
                                <div class="group"
                                    style="direction: rtl; text-align: right; color:green ;display: inline-block;">
                                    @foreach (json_decode($question->option->myOptions,true) as $key => $item)

                                    <input type="checkbox"  id="rb{{ $item.$key.$question->id }}"  name="answer[{{ $question->id }}][]" value="{{ $item }}">
                                    <label for="rb{{  $item.$key.$question->id }}">{{ $item }}</label>

                                    @endforeach
                                </div>

                                @else



                                <textarea name="answer[{{ $question->id }}][]" value="" class="form-control"
                                    style="direction:rtl; text-align: right;" cols="3" rows="2">
                                </textarea>
                                <input type="hidden" name="traditional" value="true">

                                <br>

                                <br>




                        <!-- end question-->

                            @endif
                            @endforeach
                            <input type="submit" name="" value="حفظ">
                            <br>
                            <hr>
                            <hr style="width:75%">
                            <hr style="width:50%">
                            <p>النهاية مع الأمنيات بالتوفيق لجميع الطلاب ..  </p>
                            </form>
                        </div>
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

    <script>
    $( document ).ready(function(){
    let exam_id = 'proj{{ $content_id }}' ;

        function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        let x =     setInterval(function () {

                --timer
                var seconds = timer % 60; // Seconds that cannot be written in minutes
                var secondsInMinutes = (timer - seconds) / 60; // Gives the seconds that COULD be given in minutes
                var minutes = secondsInMinutes % 60; // Minutes that cannot be written in hours
                var hours = (secondsInMinutes - minutes) / 60;

                seconds = seconds < 10 ? "0" + seconds : seconds;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                hours = hours < 10 ? "0" + hours : hours;
                // days = days < 10 ? "0" + days : days;

                display.text( hours + ":" + minutes + ":" + seconds);

                if (timer == 0) {
                    clearInterval(x);
                    //submit the exam
                    $('#this_exam').submit();
                }
            }, 1000);
        }


var period = {{ $content->period }} * 60,
display = $('.circle-front');
startTimer(period, display);

$('#this_exam').on('submit',function() {
window.localStorage.clear();
});



// $('textarea,input[type="checkbox"]').on('input',function(){

//     let element_num = $(this).data('input_num')
//     var a=[];
//     var one = $('textarea,input[type="checkbox"]').each(function(index,input ) {
//         if(input.getAttribute('type')=='checkbox'){
//             a[index]=
//                 {
//                     'type':input.getAttribute('type'),
//                     'status':input.checked,
//                     'value':input.getAttribute('value'),
//                 };
//         }
//         else {
//             a[index]=
//                 {
//                     'type':'textarea',

//                     'value':$(this).val(),
//                 };
//         }

//     });

//     window.localStorage.setItem(`${exam_id}`, JSON.stringify(a));
//     var records = window.localStorage.getItem('proj');
//     console.log(records);

// });




// window.onload =function(){

//     var a=localStorage.getItem(`${exam_id}`);
//     a=JSON.parse(a);
//     var one = document.querySelectorAll("input[type='checkbox'],textarea").forEach( (input,index) => {

//         if (input.getAttribute('type')=='checkbox') {

//             if (a[index].status==true){
//                 input.setAttribute('checked',true);
//             }

//         } else {
//             // if (input.getAttribute('type')=='text') {
//             input.value = a[index].value;

//         }

//     });


// }


// save answers in local storage

$('input[type="text"],input[type="checkbox"]').on('input',function(){
    var a=[];
    var one = $('input[type="text"],input[type="checkbox"]').each(function(index,input ) {
        if (input.getAttribute('type')=='text') {
            a[index] =
                        {
                            'type':input.getAttribute('type'),
                            'value':input.value
                        };
        }
        else if(input.getAttribute('type')=='checkbox'){
            a[index]=
                {
                    'type':input.getAttribute('type'),
                    'status':input.checked,
                    'value':input.getAttribute('value'),
                };
        }

    });

    window.localStorage.setItem('proj', JSON.stringify(a));
    var records = window.localStorage.getItem('proj');
    console.log(records);

});




window.onload =function(){

    var a=localStorage.getItem('proj');
    a=JSON.parse(a);
    var one = document.querySelectorAll("input[type='checkbox'],input[type='text']").forEach( (input,index) => {
        if (input.getAttribute('type')=='text') {
            input.value = a[index].value;
        }
        else if (input.getAttribute('type')=='checkbox') {

            if (a[index].status==true){
                input.setAttribute('checked',true);
            }

        }

    });


}



});
</script>

</body>

</html>
