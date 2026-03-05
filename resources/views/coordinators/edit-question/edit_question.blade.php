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

    <title>Question</title>
    <style>
            @import "compass/css3";
.checkbox {
  user-select: none !important;
}
.checkbox input {
  display: none;
}
.checkbox span {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  min-height: 20px;
  min-width: 20px;
  line-height: 22px;
  padding-right: 30px;
  cursor: pointer;
}
.checkbox span:empty {
  padding-right: 0;
}
.checkbox span:before {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  float: left;
  width: 20px;
  height: 20px;
  background: rgba(255, 255, 255, 0);
  box-shadow: inset 0 0 0 1px #bdc6cf;
  border-radius: 2px;
  transition: all 0.1s cubic-bezier(0.64, 0.57, 0.67, 1.53);
}
.checkbox span:after {
  content: '';
  display: block;
  width: 13px;
  height: 6px;
  position: absolute;
  top: 5px;
  right: 10px;
  border: 1px solid;
  border-color: transparent transparent #383838 #383838;
  transform: scale(5) rotate(-45deg);
  opacity: 0;
  pointer-events: none;
  transition: all 0.1s cubic-bezier(0.64, 0.57, 0.67, 1.53);
}
.checkbox input:checked + span:after {
  opacity: 1;
  border-color: transparent transparent #383838 #383838;
  box-shadow: inset 1px -1px 0 #383838;
  transform: scale(1) rotate(-45deg);
}
.checkbox input:checked + span:before {
  box-shadow: inset 0 0 0 1px rgba(189, 198, 207, 0);
  background: white;
}
/* END CHECKBOX STYLE */
.myDiv{
	display:none;
    padding:10px;
    margin-top:20px;
}
.form-control  {
    height: 45px;}

    </style>

</head>

<body style="background-image: url( {{  asset('teachers/images/new2.jpg') }}); background-repeat: no-repeat;
  background-size: cover;">

    <div class="content" style="direction: rtl; text-align: right;">
        @if (session()->has('Add'))
        <script>
             window.onload = function () {
        notif({
            msg: "تمت اضافة السؤال بنجاح ",
            type: "success"
        })
    }
        </script>
        @endif
        <div class="container" style="border-radius: 15px;">
            <div class="row align-items-stretch no-gutters contact-wrap" style="border-radius: 15px;">
              <div class="col-md-12">
                <div class="form h-100" style="border-radius: 15px;">
                  <a href="{{ route('coordinator_add_auto',[$class->id ,$lesson_id]) }}">  <button
                    class="btn btn-primary rounded-0 py-2 px-4" style="float: left;">عودة</button></a>
                  <h3 style="color: #094e89;">تفاصيل السؤال </h3>

                        <form action="{{ route('question_store') }}" method="post"
                            class="mb-5" >
                            @csrf

                            <input type="hidden" id="class_id" name="back" value="{{ $back }}">
                            <input type="hidden" id="class_id" name="class_id" value="{{ $class->id }}">
                            <input type="hidden" id="class_id" name="lesson_id" value="{{ $lesson_id }}">


                            <div class="row">


                            </div>

                            <div class="row">

                                <div class="col-md-12 form-group mb-3">
                                    <label for="budget" class="col-form-label"> نوع السؤال</label>
                                    <select class="custom-select myselection" id="myselection" name='ques_type'>
                                        {{-- <option value="@if(old('ques_type')){{ old('ques_type') }} @endif"  @if (!old('ques_type')) selected disabled> --حدد نوع السؤال--
                                            @elseif (old('ques_type') == 1) > تقليدي
                                            @elseif (old('ques_type') == 2) > اختيار من متعدد
                                            @endif</option> --}}
                                        <option selected>اختر النوع </option>

                                        <option  value="1">مؤتمت </option>
                                        <option  value="2">تقليدي</option>
                                    </select>

                                    <br>
                                    <br>
                                    <div id="show2" class="myDiv">
                                        <div class="row">
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="message" class="col-form-label">ادخل نص السؤال </label>
                                                <textarea class="form-control"     name="question_form1"    cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="message" class="col-form-label">ادخل الجواب </label>
                                                <textarea class="form-control"   id="question_form22" name="answer" cols="10" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="budget" class="col-form-label">الفقرة </label>
                                    <select class="custom-select" id="budget"  name="section_id">
                                        <option selected value="0">اختر الفقرة...</option>
                                        @foreach ( $sections as $item)
                                        <option value="{{ $item->id }} "> {{ $item->title }} </option>

                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <br>

                            </div>

                            <div id="show1" class="myDiv">
                                <!-- start my div-->
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="message" class="col-form-label">ادخل نص السؤال </label>
                                        <textarea class="form-control" name="question_form" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <button type="button" id="btn" style=" border: none; float:left ; background-color: #fff; ">
                                    <img src="{{ asset('edit-question/icons8-plus.gif')}}"
                                        style="height: 20px; width:20px;border-color: #fff; " title="اضافة خيار جديد">
                                </button>


                                <button  type="button" id="remove" style="border: none; background-color: #fff;float: left; ">
                                    <img src="{{ asset('edit-question/icons8-minus-30.png')}}"
                                        style="height: 20px; width:20px; " title="حذف خيار ">
                                </button>
                                <br>
                                <br>

                                <div id="add">
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3" style="background-color:#fff;">
                                            <label for="" class="col-form-label"> الخيار الأول*</label>
                                            <input type="text" name="option[]" class="form-control input "
                                                placeholder="ادخل الخيار الأول " value="">
                                        </div>
                                    </div>
                                    <br>

                                    <!-- js for add choice -->
                                    <script>
                                        $(document).on('click', '#btn', function () {
                                            $('#add').append(
                                                '<div class="row register" ><div class="col-md-12 form-group mb-3"><label for="" class="col-form-label"> </label> <input type="text" class="form-control input" name="option[]" placeholder="ادخل الخيار التالي "></div></div>'
                                            );


                                        });
                                    </script>
                                    <!-- End js for add choice -->

                                    <!-- start js for remove choice -->

                                    <script>
                                        $(document).ready(function () {
                                            $('#remove').click(function () {

                                               $(".register").last().remove();


                                            })
                                        });
                                    </script>
                                    <!-- End js for remobtn3removeve choice-->

                                </div>

                                <br>
                                <br>
                                <!-- start checkbox -->

                                <button id="show"  type="button" class="btn btn-primary show " style="float: left;">اظهار الخيارات
                                </button> &nbsp;&nbsp; &nbsp;&nbsp;
                                <button id="btn3" type="button" style="border: none; background-color: #fff;float: left; ">
                                    <img src="{{ asset('edit-question/icons8-minus-30.png')}}"
                                        style="height: 20px; width:20px; " title="حذف خيار ">
                                </button>
                                <h5> اختيار الاجابات </h5>
                                <div id="hi">

                                </div>



                                <script>
                                    var inputt = [];
                                 $("#show").click(function () {
                                        $("#hi").empty();

                                        inputt = $('.input').map((_, el) => el.value).get();
                                            if(inputt.length<=1){
                                                alert('يجب وضع خيارين على الاقل')
                                                
                                            }
                                            else{
                                                   for (let index = 0; index < inputt.length; index++) {
                                                       if(inputt[0]=="" || inputt[1]==""){
                                                           alert('يجب وضع خيارين على الاقل')
                                                           break; 
                                                       }    
                                                       else{
                                                             $("#hi").append(`<div id="hi1"><label class="checkbox">
                                            <input type="checkbox" class="answer"  name="answer[]" value="${inputt[index]}" > <span>${inputt[index]}</span>
                                                </label> <br></div>`) 
                                                       }
                                         
                                                
                                        }
                                            }
                                     


                                    })
                                    $("#btn3").click(function () {

                                        for (let index = 0; index < inputt.length; index++) {
                                            $("#hi1").remove()
                                        }
                                    });
                                </script>


                            </div>
                            <script>
                                $(document).ready(function () {
                                    $('#myselection').on('change', function () {
                                        var demovalue = $(this).val();
                                        $("div.myDiv").hide();
                                        $("#show" + demovalue).show();
                                    });
                                });
                            </script>


                            <br>
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="" class="col-form-label"> العلامة </label>
                                    <input type="text" class="form-control" name="mark" id="mark"
                                        placeholder="ادخل علامة السؤال">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="message"  class="col-form-label">ملاحظات *</label>
                                    <textarea class="form-control" name="note" cols="30" rows="3"
                                        placeholder="ادخل الملاحظات "></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input type="button" id="submit1"  value="حفظ التعديل "
                                        class="btn btn-primary rounded-0 py-2 px-4">
                                    <input hidden id="submit" type="submit" value="حفظ التعديل "
                                        class="btn btn-primary rounded-0 py-2 px-4">
                                    <!--span class="submitting"></span-->
                                </div>
                            </div>
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


    <script src=" {{ asset('edit-question/index.js')}} "></script>
    <script src=" {{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/popper.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery.validate.min.js')}} "></script>
    <script src="{{ asset('edit-question/js/main.js')}} "></script>
 <script >
           $(document).on('click', '#submit1', function () {
               if($('.myselection').val()==1){
                   count=0;
                   $.each($('.answer'), function (key, value) {
                       if($(this).is(':checked')){
                       count=count+1;
                       
                       
                   }})
               
               if(count>0){
                   
                   $('#submit').click();
               }
               else{
                   alert('يرجى اختيار الاجابة الصحيحة ')
               }  
               }
               else if($('.myselection').val()==2){
                   if($('#question_form22').val()==""){
                          alert('يرجى وضع الاجابة   ')
                   }
                   else{
                          $('#submit').click();
                   }
                   
                   
               }
             
               
           })
           
         
     </script>
</body>

</html>
