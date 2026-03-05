<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('edit-question/fonts/icomoon/style.css')}}">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('edit-question/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href=" {{ asset('edit-question/css/style.css')}}">
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <title> اسم الامتحان </title>
    <style>
    .form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}

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
  <body  style="background-image: url( {{  asset('teachers/images/new2.jpg') }}); background-repeat: no-repeat;
  background-size: cover;">

   <div class="content" style="  direction: rtl; border-radius: 15px;">

    <div class="container" style="justify-content: center;border-radius: 15px; ">
      <div class="row align-items-stretch no-gutters contact-wrap" style="border-radius: 15px;" >
        <div class="col-md-12" style="border-radius: 15px;">
          <div class="form h-100" style="border-radius: 15px;">
           
                <a href=" {{ route('dashboard.coordinator_show',[$lesson->id,$exam->teacher_id,$room->id ,$exam->lecture_id]) }}">  <button
                        class="btn btn-primary rounded-0 py-2 px-4" style="float: left;">عودة</button></a>
                    

              <div style="float: left;">
                            <div class="row">
                             <h7>  المادة :</h7>
                              <input disabled  style="width: 198px;
    text-align: center;

    height: 34px;"
                              class=" form-control" type="text"  value="{{$lesson->name}}" >
                            </div>

                            <div class="row">
                              <h7>  الصف:</h7>
                               <input disabled  value="{{$class1}}"    style="width: 198px;
    text-align: center;

    height: 34px;"  class="common-input mb-20 form-control" type="text">
                             </div>

                             <div class="row">
                              <h7>  الشعبة :</h7>
                               <input disabled style="width: 198px;
    text-align: center;

    height: 34px;"  value="{{$room->name}}" class="common-input mb-20 form-control" type="text">
                             </div>

                             <div class="row">
                              <h7>  الفصل:</h7>
                               <input disabled   style="width: 198px;
    text-align: center;

    height: 34px;"  value="{{$term}}" class="common-input mb-20 form-control" type="text">
                             </div>

                             <div class="row">
                              <h7>  العام الدراسي :</h7>
                               <input disabled style="width: 198px;
    text-align: center;

    height: 34px;"  value="{{$year}}" class="common-input mb-20 form-control" type="text">
                             </div>

                             <div class="row">
                              <h7>  زمن الاجابة :</h7>
                               <input style="width: 198px;
    text-align: center;

    height: 34px;"     class="common-input mb-20 form-control" type="text">
                             </div>
                            </div>
                          <div  class="row" style="margin-right: 460px;">
                            <img src="{{ asset('edit-question/logo.png')}}" style="width:110px ;height:110px;">
                          </div>

                               <h3 style="margin-top: -100px;color: #094e89;"> مدارس البيان النموذجية </h3>
                                <h4 style="color: #094e89;"> مديرية التربية في حماه </h4>

             
            <h3 style="color:#094e89;"> {{ $exam->name_quize1 }} </h3>
          
            <form class="mb-5" method="post" id="contactForm" name="contactForm"
            style="border-radius: 15px;">
            @php

                                            $i = 1;
            $kk=0;
            @endphp
                                                    {{-- @isset($selected_ques) --}}
                                                             @foreach ($selected_ques1  as $question1)
 @foreach ($question1  as $question)

                                                    @if ($question->section)
                                                    @if ($kk!=$question->section->id )


            @php

            $kk=$question->section->id

            @endphp

@if ($question->section->type=='0')
<h4 style="color:#094e89;">يرجى     قراءة النص   ثم الاجابة </h4>

    <p style="justify-content:center; margin: 0 auto ; direction:rtl ">

        {{ $question->section->content }}
    </p>
@endif
 @if ($question->section->type=='3')
 <h4 style="color:#094e89" >    يرجى التأمل بالصورة ثم الإجابة على الأسئلة  </h4>

<img  style="margin:0 auto; "  src="{{ asset('storage/'.$question->section->content) }}"  >
<br><br>

@endif

 @if($question->section->type=='2')
 <h4 style="color: #094e89"  > يرجى الاستماع للصوت ثم الإجابة على الأسئلة  </h4>
      <div class="row " style="justify-content: center;margin:0 auto " >
     <audio   src="{{ asset('storage/'.$question->section->content) }}" controls  >
    </audio>
      </div>
     <br>
     <br>
     @endif


     @endif
     @endif

     @if ($question->ques_type== '1')
     
 <h2 style="justify-content: center; " class="strong myquestion{{ $i - 1 }}" data-mark="{{ $question->mark }}" data-answer="{{ $question->answer }}" data-ques_num="ques{{ $k =$i - 1 }}"> <span style="
    font-size: 14px;
"> {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i> </span> {{ $question->question_form}}</h2>
                    <div class="group">

                        @foreach (json_decode($question->option->myOptions,true) as $item)

                      <input type="checkbox" name="rb" id="rb{{ $item }}"

 @if (($question->answer) != "null" )
                      @foreach (json_decode($question->answer) as $itemq)

                      @if (($item == $itemq))
                                checked
                                @endif
                                @endforeach
                                @endif
                                disabled >

                      <label for="rb{{ $item }}">{{ $item }}</label>


                      @endforeach

                    </div>
                    <input type="hidden" class="form-control user_answers" name="user_answers"  placeholder="" value="">
                    <input type="hidden" class="form-control selected_ques" name="selected_ques"  placeholder="" value="{{ $exam->selected_ques }}">
                    <input type="hidden" class="form-control exam_id" name="exam_id"  placeholder="" value="{{ $exam->id }}">
                    <input type="hidden" class="form-control result" name="result"  placeholder="" value="">
                    @elseif ($question->ques_type=='2')

                    <h2 style="justify-content: center; font-size: 21px;"><span style="
                        font-size: 14px;
                    "> {{ $i++ .'_' }}  <i class=" fa fa-file-text-o " style="margin-left: 10px;"></i> </span> {{ $question->question_form}}</h2>


                    <br>
                    <textarea name="content" class="form-control" style="direction:rtl; text-align: right;" cols="3" rows="2">
            {{ $question->answer }}
                    </textarea>
                    <br>
                    <!--input type="submit" class="btn btn-primary" style="width: 100px;" value="حفظ"-->



                  @endif

@endforeach
@endforeach




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

  </div>


  <script src="{{ asset('edit-question/index.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/popper.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/main.js')}}"></script>

  </body>
</html>
