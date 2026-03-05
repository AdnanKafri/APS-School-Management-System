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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Style -->
    <link rel="stylesheet" href=" {{ asset('edit-question/css/style.css')}}">
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <title>Question</title>
    <style>
    .breadcrumbs {
 
  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
  direction: rtl !important;
}

.breadcrumbs__item {
 
  color: #f38639;
  outline: none;
  padding: 0.75em 0.75em 0.75em 1.25em;
  position: relative;
  text-decoration: none;
  transition: background 0.2s linear;
}

.breadcrumbs__item:hover:after,
.breadcrumbs__item:hover {
  background: #edf1f5;
  color: black !important;
}

.breadcrumbs__item:focus:after,
.breadcrumbs__item:focus,
.breadcrumbs__item.is-active:focus {
  background: #e2e9e708;
  color: #fff;
}

.breadcrumbs__item:after,
.breadcrumbs__item:before {
  background: #fff;
  bottom: 0;
  clip-path: polygon(50% 50%, -50% -50%, 0 100%);
  content: "";
  left: 100%;
  position: absolute;
  top: 0;
  transition: background 0.2s linear;
  width: 1.5em;
  z-index: 1;
}

.breadcrumbs__item:before {
  background: #3971a0;
  margin-left: 1px;
}

.breadcrumbs__item:last-child {
  border-right: none;
}

.breadcrumbs__item.is-active {
    background: #e2e9e708;
    font-weight: bold;
    color: #3971a0;
}
   /*cards*/

   .data-card {
  display: flex;
  flex-direction: column;
  width: 15.95em;
  min-height: auto;
  overflow: hidden;
  border-radius: 0.5em;
  text-decoration: none;
  background: white;
  margin: 1em;
  padding: 2.75em 2.5em;
  box-shadow: 0 1.8em 2.7em -0.7em rgba(0, 0, 0, 0.3);
  transition: transform 0.45s ease, background 0.45s ease;
}
.data-card h3 {
  color: #2E3C40;
  font-size: 3.5em;
  font-weight: 600;
  line-height: 1;
  padding-bottom: 0.5em;
  margin: 0 0 0.142857143em;
  border-bottom: 2px solid #f38639;
  transition: color 0.45s ease, border 0.45s ease;
}
.data-card h4 {
  color: #627084;
  text-transform: uppercase;
  font-size: 1.125em;
  font-weight: 700;
  line-height: 1;
  letter-spacing: 0.1em;
  margin: 0 0 1.777777778em;
  transition: color 0.45s ease;
}
.data-card p {
  opacity: 0;
  color: #FFFFFF;
  font-weight: 600;
  line-height: 1.8;
  margin: 0 0 1.25em;
  transform: translateY(-1em);
  transition: opacity 0.45s ease, transform 0.5s ease;
}
.data-card .link-text {
  display: block;
  color: #753BBD;
  font-size: 1.125em;
  font-weight: 600;
  line-height: 1.2;
  margin: auto 0 0;
  transition: color 0.45s ease;
}
.data-card .link-text svg {
  margin-left: 0.5em;
  transition: transform 0.6s ease;
}
.data-card .link-text svg path {
  transition: fill 0.45s ease;
}
.data-card:hover {
  background: #FFFFFF;
  transform: scale(1.02);
}
.data-card:hover h3 {
  color: #FFFFFF;
  border-bottom-color: #f38639;
}
.data-card:hover h4 {
  color: #FFFFFF;
}
.data-card:hover p {
  opacity: 1;
  transform: none;
}
.data-card:hover .link-text {
  color: #FFFFFF;
}
.data-card:hover .link-text svg {
  animation: point 1.25s infinite alternate;
}
.data-card:hover .link-text svg path {
  fill: #FFFFFF;
}
@keyframes point {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(0.125em);
  }
}

/*checkbox*/



ul.ks-cboxtags {
    list-style: none;
    padding: 20px;
}
ul.ks-cboxtags li{
  display: inline;
}
ul.ks-cboxtags li label{
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #adadad;
    border-radius: 25px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

ul.ks-cboxtags li label {
    padding: 8px 12px;
    cursor: pointer;
}

ul.ks-cboxtags li label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 15px;
    padding: 2px 6px 2px 2px;
    /*content: " \f13b ";
    transition: transform .3s ease-in-out;*/


}

ul.ks-cboxtags li input[type="checkbox"]:checked + label::before {
   /* content: "\f00c";*/
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;

}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    border: 2px solid #f38639;
    background-color: #f38639;
    color: #fff;
    transition: all .2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
  display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}
ul.ks-cboxtags li input[type="checkbox"]:focus + label {
  border: 2px solid #e9a1ff;
}

/**/
.myDiv{
	display:none;
}
.tab1cards {
  display: flex;
  flex-direction: row;
}
/**/
.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #5c8eba;
    border-color: #5c8eba;}
    .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #5c8eba;
    background-color: #fff;
    border: 1px solid #dee2e6;}
    /*search design*/
    .search {
  box-shadow: 0 20px 10px -10px rgba(200, 200, 200, 0.5);
  display: inline-block;
}
.search__input {
  background-color: #84a7c4;
  border: 0;

  outline: 0;
  line-height: 50px;
  font-size: 14px;
  padding: 0 18px;
  float: right;
  color: white;
}
::placeholder {
  color: white;
  opacity: 1; /* Firefox */
}
.search__button {
  box-shadow: -10px 0 10px -5px rgba(90, 117, 238, 0.5);
  color: white;
  background-color: #094e89;
  width: 50px;
  line-height: 50px;
  text-align: center;
  border: 0;

  padding: 0;
  cursor: pointer;
  outline: 0;
  transition: box-shadow 0.3s ease-out;
}
.search__button:active {
  box-shadow: -10px 0 10px -10px rgba(90, 238, 209, 0.5);
}
    /*end search design*/

    /*design select*/
    /*select and option */
:root {
  --background-gradient: linear-gradient(to right top, #f38639  20%, rgb(132, 167, 196))
  --gray: #f38639 ;
  --darkgray: #2c71ad;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: #f38639;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
  text-align: center;



}
/* Remove IE arrow */
select::-ms-expand {
  display: none;

}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 12em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639 ;
}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #2c71ad ;
  transition: .25s all ease;
  pointer-events: none;

}
/* Transition */
.select:hover::after {
  color: #f38639;
}

    /*end design select */
    </style>

  </head>
  <body style="background-image: url( {{  asset('teachers/images/new2.jpg') }});
  background-size: cover; border-radius: 15px;">
  <nav class="breadcrumbs" style="float: left;">
   </a>
     <a  class="breadcrumbs__item is-active">دفتر التحضير  </a>
    <a   href="{{ route('dashboard.coordinator_teacher_lesson',[$classes->id,$teacher->id,$lesson->id]) }}" class="breadcrumbs__item ">الدروس  </a>
   
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
   <div class="content" style="direction: ltr;
   text-align: left; padding-bottom: 16px;">

    <div class="container" style="border-radius: 15px;">
      <div class="row align-items-stretch no-gutters contact-wrap" style="border-radius: 15px;">
        <div class="col-md-12 col-xs-12"  >
          <!-- start -->
          <div class="form h-100"  style="border-radius: 15px;">
          <!-- serach section-->
          <div class="search" style="
          float: right;
      ">
              <input class="search__input" id="search" placeholder="Search.."/>
                <input id="teacher_id"  hidden   value="{{$teacher->id}}" />
              <button class="fa fa-search search__button"></button>
            </div>
            <!-- end serach section-->

             <!-- select option-->
             <div class="select" style=" border-radius: 5px; float: left;width: 200px;" >
              <select class="download">
                <option value="1" > Download prepare Notebook</option>

                    <option value="3">Download page </option>
                    <option value="4">Download all pages</option>

              </select>
              </div>
            <br>
            <br>
             <!-- end select-->

            <h3 style="color: #094e89;float: left;">Daily Lesson Plan   </h3>
            <h3 style="color: #094e89;"> Academic Year  {{ $year->name }}  </h3>
            <div class="table_data">
            @include('coordinators.load_en')
            </div>
            <input hidden value="{{ $term->id }}" name="term_id" id="trem_id1" type="text">
            <input style="width: 200px; text-align: center;margin-top: -20px;height:40px !important;"  hidden  id="lesson_name"   class="common-input mb-20 form-control" disabled  value="{{ $lesson_id->name_en }}"  type="text">
            <input style="width: 200px; text-align: center;margin-top: -20px;"  id="lesson_id"  class="common-input mb-20 form-control" hidden  value="{{ $lesson_id->id }}"  type="text">
            <input   hidden  value="{{ $term->id }}"  id="trem_id" type="text">&nbsp;&nbsp;&nbsp;

            <input style="width: 100px; text-align: center;" hidden id="class_name"  value="{{ $class_id->name_en }}" disabled  class="common-input mb-20 form-control" type="text">&nbsp;&nbsp;&nbsp;

            <input id="class_id"  name="class_id" hidden  value="{{ $class_id->id }}"   type="text">

                <br>
                <br>



           </div>
          <!-- end -->



                </form>


          </div>
        </div>
      </div>
    </div>


  <div class="tab1cards" >
  
      <div class="btn"  style="float: left; padding-right: 700px;">
        {{ $prepare->links() }}

  </div>
 </div>
  <div id="test2">

</div>

  <script>

    $.each($('.y'), function (key, value) {
        var c = $(this).val();
        $.each($('.x'), function (key, value) {
            if ($(this).data('id') == c) {

                $(this).attr('checked', true)
                $(this).val($(this).data('id'));
            }
        })


    })
    $.each($('.y1'), function (key, value) {
        var c = $(this).val();
        $.each($('.x1'), function (key, value) {
            if ($(this).data('id') == c) {

                $(this).attr('checked', true)
                $(this).val($(this).data('id'));
            }
        })


    })
    $(document).on('keyup', '#search', function () {

    var lect=$('#search').val();
     var teacher_id=$('#teacher_id').val();
            var class_id=$('#class_id').val();
            var lesson_id=$('#lesson_id').val();
            var term=$('#trem_id1').val();

                    var data={
                          "teacher_id":teacher_id,
                            "search":lect,
                            "class_id":class_id,
                            "lesson_id":lesson_id,
                            "term":term,

                        }
                        $('.table1 tbody').empty();
                    var url = "{{ URL::to('SMARMANger/dashboard/coordinator/searchlect1') }}";
                $.ajax({
                    url: url,
                    data : data,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);

                        $('.table_data').empty().html(data);

 $.each($('.y'), function (key, value) {
            var c = $(this).val();
            $.each($('.x'), function (key, value) {
                if ($(this).data('id') == c) {

                    $(this).attr('checked', true)
                    $(this).val($(this).data('id'));
                }
            })


        })
      
        $.each($('.y1'), function (key, value) {
            var c = $(this).val();
            $.each($('.x1'), function (key, value) {
                if ($(this).data('id') == c) {

                    $(this).attr('checked', true)
                    $(this).val($(this).data('id'));
                }
            })


        })
     



                    }
                })


})
$(document).ready(function(){
    $(document).on('change', '.download', function () {
        if($(this).val()==3){
            $('#buttondown').show();
            $('#buttondown1').hide();

        }
    else{
        $('#buttondown1').show();
        $('#buttondown').hide();

    }

    })




})
</script>
<script src=" {{ asset('edit-question/index.js')}} "></script>
<script src=" {{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
<script src=" {{ asset('edit-question/js/popper.min.js')}}"></script>
<script src=" {{ asset('edit-question/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('edit-question/js/jquery.validate.min.js')}} "></script>
<script src="{{ asset('edit-question/js/main.js')}} "></script>

  </body>
</html>
