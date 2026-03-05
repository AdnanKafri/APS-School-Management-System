<!DOCTYPE html>
<html lang="en">
<head>
	<title>الاسئلة</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset('table-exams/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/vendor/animate/animate.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('table-exams/css/main.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<!--===============================================================================================-->
<style>
	/*@import url("https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Sen:wght@400;700;800&display=swap");
body {
  background-color: #e8e8e8;
  color: #454545;
  display: grid;
  font-family: Sen, sans-serif;
  justify-items: center;
  padding: 0.75rem;
}
*, *:before, *:after {
  box-sizing: border-box;
}*/
h1 {
  max-width: 20ch;
  text-align: center;
  font-weight: 800;
  font-size: 2.5rem;
  margin: 3rem 0;
  color: #3b3b3b;
  letter-spacing: -0.02em;
}
ul {
  list-style: none;
  margin: 0 auto;
  background: #ffffff;
  padding: 0;
  margin-top: 50%;
}
@media (min-width: 36em) {
  ul {
    width: 1060px;
    margin-top: 5%;
  }
}
ul li {
  position: relative;

}
input {
  -webkit-appearance: none;
  width: 1.25rem;
  height: 1.25rem;
  border: 1px solid #d9d9d9;
  border-radius: 1px;
  vertical-align: sub;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 1rem;
  outline: none;
}
.s123:checked {
  background-color: #f38639;
  border-color: #666;
}
.s11:checked {
  background-color: #61414100;
  border-color: #666;
}
input:checked + label {
  text-decoration: line-through;
  color: #b3b3b3;
  font-weight: 600;
  background-color: #f7f7f7;
}
.s123:checked:focus, .s123:checked:hover {
  box-shadow: 0 0 0 3px #d9d9d9;
  border-color: #f38639;
}
.s123:after {
  content: "";
  width: 100%;
  height: 100%;
  position: absolute;
  right: 0;
  top: 0;
  background-image: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9JzMwMHB4JyB3aWR0aD0nMzAwcHgnICBmaWxsPSIjZmZmZmZmIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgdmVyc2lvbj0iMS4xIiB4PSIwcHgiIHk9IjBweCI+PHRpdGxlPmljb25fYnlfUG9zaGx5YWtvdjEwPC90aXRsZT48ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz48ZyBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48ZyBmaWxsPSIjZmZmZmZmIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNi4wMDAwMDAsIDI2LjAwMDAwMCkiPjxwYXRoIGQ9Ik0xNy45OTk5ODc4LDMyLjQgTDEwLjk5OTk4NzgsMjUuNCBDMTAuMjI2Nzg5MSwyNC42MjY4MDE0IDguOTczMTg2NDQsMjQuNjI2ODAxNCA4LjE5OTk4Nzc5LDI1LjQgTDguMTk5OTg3NzksMjUuNCBDNy40MjY3ODkxNCwyNi4xNzMxOTg2IDcuNDI2Nzg5MTQsMjcuNDI2ODAxNCA4LjE5OTk4Nzc5LDI4LjIgTDE2LjU4NTc3NDIsMzYuNTg1Nzg2NCBDMTcuMzY2ODIyOCwzNy4zNjY4MzUgMTguNjMzMTUyOCwzNy4zNjY4MzUgMTkuNDE0MjAxNCwzNi41ODU3ODY0IEw0MC41OTk5ODc4LDE1LjQgQzQxLjM3MzE4NjQsMTQuNjI2ODAxNCA0MS4zNzMxODY0LDEzLjM3MzE5ODYgNDAuNTk5OTg3OCwxMi42IEw0MC41OTk5ODc4LDEyLjYgQzM5LjgyNjc4OTEsMTEuODI2ODAxNCAzOC41NzMxODY0LDExLjgyNjgwMTQgMzcuNzk5OTg3OCwxMi42IEwxNy45OTk5ODc4LDMyLjQgWiI+PC9wYXRoPjwvZz48L2c+PC9nPjwvc3ZnPg==");
  background-size: 40px;
  background-repeat: no-repeat;
  background-position: center;
}
.s123:focus, .s123:hover {
  box-shadow: 0 0 0 3px #ebebeb;
  border-color: #8c8c8c;
}
label {
  padding: 0.90rem 4rem 0.90rem calc(1.2rem * 2.25);
  display: inline-block;
  font-size: 17px;
  width: 100%;
  user-select: none;
  border-bottom: 2px solid #ededed;
  cursor: pointer;
  text-align: right;
}
label:hover {
  border-bottom-color: #f38639;
}

/* start select*/
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #4972a8;
  --darkgray: #4972a8;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
  text-align: center;
direction: rtl;


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 15em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;



}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #4972a8;
  transition: .25s all ease;
  pointer-events: none;


}
/* Transition */
.select:hover::after {
  color: #f38639;



}

/* Other styles*/


/*end select */


/* end select*/
 /**/


.tb {
  display: table;
  width: 100%;
}

.td {
  display: table-cell;
  vertical-align: middle;
  background-color: transparent;

}

input,
button {
  /*color: #fff;*/
  font-family: Nunito;
  padding: 0;
  margin: 0;
  border: 0;


}

#cover {
  position: absolute;
  top: 20%;
  right: 150px;

  width: 450px;
  height: 99px;
  padding: 35px;
  margin: -73px auto 0 auto;
  background-color: #f38639;
  border-radius: 20px;
  box-shadow: 0 10px 40px #f38639, 0 0 0 20px #ffffffeb;
  transform: scale(0.6);


}

form {
  height: 90px;
}

input[type="text"] {
  width: 450px;
  height: 100px;
  font-size: 40px;

  line-height: 1;
  left: 26px;
  background-color: transparent;
  border-color: transparent;




}

input[type="text"]::placeholder {
  color: white;
  text-align: left;
  background-color: transparent;
  border-color: transparent;



}

#s-cover {
  width: 1px;
  padding-left: 20px;
}

button {
  position: relative;
  display: block;
  width: 84px;
  height: 96px;
  cursor: pointer;
}

#s-circle {
  position: relative;
  top: -36px;
  left: 0;
  width: 43px;
  height: 43px;
  margin-top: 0;
  border-width: 15px;
  border: 15px solid #fff;
  background-color: transparent;
  border-radius: 50%;
  transition: 0.5s ease all;
}

button span {
  position: absolute;
  top: 27px;
  left: 20px;
  display: block;
  width: 45px;
  height: 15px;
  background-color: transparent;
  border-radius: 10px;
  transform: rotateZ(52deg);
  transition: 0.5s ease all;
}

button span:before,
button span:after {
  content: "";
  position: absolute;
  bottom: 0;
  right: 0;
  width: 45px;
  height: 15px;
  background-color: #fff;
  border-radius: 10px;
  transform: rotateZ(0);
  transition: 0.5s ease all;
}

#s-cover:hover #s-circle {
  top: -30px;
  width: 67px;
  height: 15px;
  border-width: 0;
  background-color: #fff;
  border-radius: 20px;
}

#s-cover:hover span {
  top: 19%;
  left: 56px;
  width: 25px;
  margin-top: -9px;
  transform: rotateZ(0);
}

#s-cover:hover button span:before {
  bottom: 11px;
  transform: rotateZ(52deg);
}

#s-cover:hover button span:after {
  bottom: -11px;
  transform: rotateZ(-52deg);
}
#s-cover:hover button span:before,
#s-cover:hover button span:after {
  right: -6px;
  width: 40px;
  background-color: #fff;
}
.tab1cards {
  display: flex;
  flex-direction: row;
  justify-content: center;
}

</style>
</head>
<body>


   <div class="tab1cards">
    <div id="cover"   >

       <div class="tb">
         <div class="td">
           <input type="text" placeholder=" البحث عن  سؤال " name="search"   id="search"  style="border-color: none;">
           <input hidden id="exam" name="exam" value="{{ $exam->id }}">
        </div>
         <div class="td" id="s-cover">
           <button  id="search1">
             <div id="s-circle"></div>
             <span></span>
           </button>
         </div>
       </div>

   </div>
 </div>



  <form action="{{ route('exams_myquestions') }}"  class="limiter"  method="post" autocomplete="off">
    @csrf
    @if (session()->has('success'))
        <script>
             window.onload = function () {
        notif({
            msg: "تمت اضافة الاسئلة بنجاح ",
            type: "success"
        })
    }
        </script>
        @endif
        @if (session()->has('error'))
        <script>
             window.onload = function () {
        notif({
            msg: "   لم يتم اضافة اي سؤال ",
            type: "error"
        })
    }

    </script>
@endif
    <input type="hidden" name= "selected_ques2" data-selected_ques="{{ $exam->selected_ques }}" id="selected_questions">

    <input type="hidden" value="{{ $exam->id }}"  id="exam" name="exam_id">
        <input type="hidden" value="{{ $exam->mark }}"  id="success_mark" name="success_mark">
         <div class="r"></div>
    <div class="container-login100"  style=" background-image:url('{{  asset('teachers/images/new2.jpg') }}');
    background-repeat: no-repeat;background-size: cover;">

        <div class="wrap-login100">
            <div class="tab1cards">
                @foreach ($exams as $item )
                @if($item->id==$exam->id)
                <input type="checkbox" name="room_id[]" class="s11"  id="roo{{ $item->id }}"  value="{{ $item->id }}" checked>
                <label for="roo{{ $item->id }}">{{ $item->room->name }}</label>

                @else
                <input type="checkbox" name="room_id[]" class="s11"   id="roo{{ $item->id }}"  value="{{ $item->id }}" >
                <label for="roo{{ $item->id }}">{{ $item->room->name }}</label>
                @endif




                <br>
                
                @endforeach
<p style="display: flex;
    padding-left: 9px;
    align-items: center;">{{ $exam->mark }}/<span id="mark22"></span></p>
             </div>
             <!-- div for seach button -->

            <ul class="lecq">

                @foreach (  $questions as  $item )
                @if(json_decode($exam->selected_ques))

                <li>



                     @foreach( json_decode($exam->selected_ques)  as $item1 )
                @if($item1 == $item->id)
                    @php
                        $i23=$item->id
                    @endphp
                    <input type="text" hidden  value="{{ $item->id }}"  class="y s123" id="cb{{ $item->id  }}" >

                @endif
                @endforeach
                <input type="checkbox" value="{{ $item->id }}"    data-id="{{ $item->id }}"  data-mark="{{ $item->mark }}"  class="x s123" id="cb{{ $item->id  }}"  name="selected_ques[]" >
                <label for="cb{{ $item->id  }}">{{ $item->question_form }} ({{ $item->mark }})  </label>
                </li>
@else
            <li>
<input type="checkbox" value="{{ $item->id }}"  data-id="{{ $item->id }}" class="x s123"  data-mark="{{ $item->mark }}" id="cb{{ $item->id  }}"  name="selected_ques[]" >
<label for="cb{{ $item->id  }}">{{ $item->question_form }} ({{ $item->mark }})  </label>
</li>


                @endif


                @endforeach







            </ul>
            @if($exam->type=="2")
            <a href="
            {{ route('coordinator_show_quize',[$class_id ,$lesson_id,$exam->room_id]) }}" style=" float: left;
                height: 37px;
                width: 72px;">
          عودة </a>
            @else 
              <a href="
            {{ route('coordinator_show_exam',[$class_id ,$lesson_id,$exam->room_id]) }}" style=" float: left;
                height: 37px;
                width: 72px;">
          عودة </a>
            @endif
             
            <br>
            <br>

           <button type="submit" class="btn btn-primary "
           style="margin:0 auto; width: 200px; height:40px;background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ </button>
        </div>

    </div>
</form>







<!--===============================================================================================-->
	<script src="{{ asset('table-exams/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('table-exams/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('table-exams/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('table-exams/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('table-exams/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('table-exams/js/main.js') }}"></script>
<script>
let selected_ques ;
        let exam_id = $('#exam').val() ;
        let exam_questions = {};
        selected_ques = $('#selected_questions').data('selected_ques');
        if(selected_ques ==""){
            selected_ques = {}
        }
        selected_ques = selected_ques !== null ? selected_ques : {};
        console.log(typeof(selected_ques));
        console.log(selected_ques);

        exam_questions[exam_id] = selected_ques;
        localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
            $('.r').empty();
                // exam_questions=JSON.stringify(exam_questions)
   $.each(exam_questions, function (key, value) {
                   $.each(value, function (key, value1) {
                 
                    $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
              })
               })
        $(document).on('click','.x',function(){
              var x1=0;
        var x3=localStorage.getItem('x');
         if ($(this).is(':checked')) {
             
           $(this).addClass("x4"); }
           else{
                $(this).removeClass("x4");
               v= $(this).data('mark');
               x3=parseFloat(x3)-parseFloat(v);
                localStorage.setItem('x', x3);
           }
      
            if ($(this).is(':checked')) {

            x1= parseFloat(x1)+parseFloat($(this).data('mark') );
                
            
        }
        x1= parseFloat(x1)+parseFloat(x3 );
   mark= $('#success_mark').val();
   if(x1>mark){
       alert('لايمكن اضافة السؤال لانه تجاوز علامة الامتحان')
        $( this ).prop('checked',false);
        $(this).removeClass("x4");
        console.log(selected_ques);
        // doesExist(selected_ques,$(this).val(),true);
console.log(selected_ques);


console.log($(this).val());
return false ;
           
            
   }
   else{
           x1 = Number(x1);
 x1 = x1.toFixed(3);
      $('#mark22').text(x1);
       localStorage.setItem('x', x1);
   }
            // if(localStorage.getItem('exam_questions') === null) {
            //     selected_ques = [];
            // } else {
            //     selected_ques = JSON.parse(localStorage.getItem('selected_ques'));
            // }

                exam_questions = JSON.parse(localStorage.getItem('exam_questions'));
            selected_ques = exam_questions[exam_id];
            console.log(selected_ques);
             
            if($(this)[0].checked && !doesExist(selected_ques,$(this).val())){
console.log(Object.keys(selected_ques).length);
                    selected_ques[Object.keys(selected_ques).length+1] = $(this).val()
                exam_questions[exam_id] = selected_ques;
                localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
                console.log(selected_ques);
                   $('.r').empty();
                    // exam_questions=JSON.stringify(exam_questions)
              
                   $.each(exam_questions, function (key, value) {
                   $.each(value, function (key, value1) {
                 
                    $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
              })
               })
                // if (selected_ques[$(this).val()]){
                //     alert(5)length
                // }
                // localStorage.setItem('selected_ques', JSON.stringify(selected_ques));
            } else if (!$(this)[0].checked ) {
                doesExist(selected_ques,$(this).val(),true);
                exam_questions[exam_id] = selected_ques;
                localStorage.setItem('exam_questions', JSON.stringify(exam_questions));
                console.log(selected_ques);
                   $('.r').empty();
                    // exam_questions=JSON.stringify(exam_questions)
              
                   $.each(exam_questions, function (key, value) {
                   $.each(value, function (key, value1) {
                 
                    $('.r').append(` <input  hidden name="selected_ques1[]" value="${value1}">`)
              })
               })
            }


            


        });









   $.each($('.y'), function (key, value) {
    var c= $(this).val();
    $.each($('.x'), function (key, value) {
    if($(this).data('id') ==c){

        $( this ).attr( 'checked', true )
        $( this ).val($(this).data('id'));
    }})


   })
     var  x=0;
   $.each($('.x'), function (key, value) {
            if ($(this).is(':checked')) {

            x= parseFloat(x)+parseFloat($(this).data('mark') );
                
            }
            
        })
            x = Number(x)
 x = x.toFixed(3);
         localStorage.setItem('x', x);
   $('#mark22').text(x);
$(document).on('click', '#search1', function () {
    var lect=$('#search').val();
            var exam=$('#exam').val();
            var data={
                    "search":lect,
                    "exam":exam,

                }
            var url = "{{ URL::to('SMARMANger/dashboard/coordinator/search') }}";
        $.ajax({
            url: url,
            data : data,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                if(data==1){
                    $('.lecq').append(`  <li> not found</li>`)
                }
         console.log(data);

         $('.lecq').empty();
         let checked ;

                $.each(data, function (key, value) {
                    checked = doesExist(selected_ques,value.id) === true ? 'checked' : '' ;
                    $('.lecq').append(`  <li>
                    <input type="checkbox"  class="x s123" data-mark="${ value.mark }"  ${checked} value="${ value.id }" id="cb${ value.id }" name="selected_ques[]" >
                    <label for="cb${ value.id }">${ value.question_form } (${ value.mark }) </label>
                  </li>`)



                });




            },
            error: function (xhr) {

            }

        })

})
const doesExist = (selected_ques, ques_id,to_delete = false) => {
            for (let key in selected_ques) {
                if (selected_ques[key] == ques_id) {
                    // if(to_delete) delete selected_ques[key];
                    if(to_delete)  {
                        delete selected_ques[key];

                    }
                return true;
                }
            }
            return false
            }

$(document).on('change', '.choice', function () {

            var lect=$(this).val();
            var exam=$('#exam').val();

            $('.lecq').empty();
        var url = "{{ URL::to('SMARMANger/dashboard/teacher/lecquestion') }}/" + lect +"/"+exam;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
         console.log(data);

         $('.lecq').empty();
                let checked ;
                $.each(data, function (key, value) {
                    checked = doesExist(selected_ques,value.id) === true ? 'checked' : '' ;
                    $('.lecq').append(`<li>
                    <input type="checkbox" class="x s123" data-mark="${ value.mark }"   ${checked} value="${ value.id }" id="cb${ value.id }" name="selected_ques[]" >
                    <label for="cb${ value.id }">${ value.question_form } (${ value.mark }) </label>
                  </li>`)



                });




            },
            error: function (xhr) {

            }

        });




    })

</script>
</body>
</html>
