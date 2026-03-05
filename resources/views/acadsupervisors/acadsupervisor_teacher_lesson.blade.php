@extends('acadsupervisors.master')
@section('css')
<style>
	/* for add lesson */

    .launch2 {
        height: auto;
        margin-left: 180px;
        text-align: center;
        width: 170px;
    }

    .close2 {
        font-size: 30px;
        cursor: pointer;
        color: #495057;
    }

    .modal-body2 {
        height: 450px
    }

    .nav-tabs2 {
        border: none !important
    }

    .nav-tabs2 .nav-link.active2 {
        color: #495057;
        background-color: #fff;
        border-color: #ffffff #ffffff #fff;
        border-top: 3px solid rgb(224, 117, 224) !important
    }

    .nav-tabs2 .nav-link2 {
        margin-bottom: -1px;
        border: 1px solid transparent;
        border-top-left-radius: 0rem;
        border-top-right-radius: 0rem;
        border-top: 3px solid #eee;
        font-size: 20px
    }

    .nav-tabs2 .nav-link2:hover {
        border-color: #e9ecef #ffffff #ffffff
    }

    .nav-tabs2 {
        display: table !important;
        width: 100%
    }

    .nav-item2 {
        display: table-cell
    }

    .form-control2 {
        border-bottom: 1px solid #eee !important;
        border: none;
        font-weight: 600;
    }

    .form-control2:focus {
        color: #495057;
        background-color: #fff;
        border-color: #8bbafe;
        outline: 0;
        box-shadow: none
    }

    .inputbox2 {
        position: relative;
        margin-bottom: 20px;
        width: 100%
    }

    .inputbox2 span {
        position: absolute;
        top: 7px;
        left: 11px;
        transition: 0.5s
    }

    .inputbox2 i {
        position: absolute;
        top: 13px;
        right: 8px;
        /*transition: 0.5s;color: #3F51B5*/
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0
    }

    .inputbox2 input:focus~span {
        transform: translateX(-0px) translateY(-15px);
        font-size: 12px
    }

    .inputbox2 input:valid~span {
        transform: translateX(-0px) translateY(-15px);
        font-size: 12px
    }

    .pay2 button {
        height: 47px;
        border-radius: 37px
    }
    .fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.close {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
}
.close:not(:disabled):not(.disabled) {
    cursor: pointer;
}

    /*end add lesson */

    /**/

</style>
@endsection

@section('content')

<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread"> {{ $lesson->name }} / {{ $teacher->first_name }}  {{ $teacher->last_name }}</h1>
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  الدروس </a>
     <a  href="{{ route('dashboard.acadsupervisor_teacher',[$room->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.acadsupervisor_subject',$room->id ) }}" class="breadcrumbs__item ">{{ $classes->name }} / {{$room->name}}   </a>
     <a   href="{{ route('dashboard.acadsupervisor') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->
<!-- start section of content lesson -->
<section class="ftco-section bg-light">
    <div class="container">
       <div class="row justify-content-center pb-4">
           <div class="col-md-12 heading-section text-center ftco-animate">
               <span class="subheading"></span>
             <h2 style="color: #f38639; box-shadow: white 0px 48px 100px 0px;">الدروس  </h2>
         </div>
     </div>


     <!-- add lesson -->
 

          <button   style="float: left;"
            type="button" class="btn btn-primary launch"
            >
            <a href="{{ route('acadsupervisor.prepare',[$room->id,$classes->id,$lesson->id,$teacher->id]) }}" style="color:white">

           دفتر التحضير  <i class="fa fa-plus"></i></a> </button>




               <!-- end model-->

        <br>
        <br>
        <br>

     <!--- end add lesson -->


     <div class="row" style="text-align: right; direction:rtl">
        @foreach ($lectures as $item )
        <div class="col-md-4 ftco-animate">
           <div class="project-wrap">
              <a href="#" class="img" style="background-image:  url({{  asset('teachers/images/work-1.jpg') }} );">
                 <span class="price" style="text-align: right; direction:rtl">{{ $item->room->name }}  </span>
             </a>



             <div class="text p-4">
                 <h3 style="display: contents;"><a href="#" style="color: #094e89;"> {{ $item->name }}</a></h3>
              
                 <p class="advisor"> <span></span></p>
                 <ul class="d-flex justify-content-between">
              <li><span class="flaticon-shower"></span>
            <a href="{{ route('dashboard.acadsupervisor_show',[$lesson->id,$teacher->id,$item->room->id ,$item->id]) }}" style="color:#094e89" > محتوى الدرس </a> </li>
                    {{-- <li class="price"> <a href="{{ route('dashboard.teacher_rooms2',[$class->id,$teacher->id,$room->id ,$item->id]) }}" style="color:#f38639" >اضافة محتوى </a> </li> --}}
                </ul>

            </div>
        </div>
    </div>
@endforeach


 </div>
 </div>
 </section>


<!-- end section  of content lesson-->


<br>
<br>
<br>
<br>
<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg>
</div>
@endsection

@section('js')
<script>
      $(".key").on("click", function (e) {
        id=$(this).data('id');
        d=$(this).children();
        var data={
                    "id":id,

                }
            var url = "{{ URL::to('SMARMANger/dashboard/teacher/key') }}";
        $.ajax({
            url: url,
            data : data,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
                if(data.key==0){

                    d.css("color", "green");

        notif({
            msg: "تم عرض الدرس عند الطلاب",
            type: "success"
        })


                }
                else{
                    d.css("color", "red");

        notif({
            msg: "تم اخفاء الدرس عند الطلاب",
            type: "error"
        })

                }



            },
            error: function (xhr) {

            }

        })

      })

    $(".edit11").on("click", function (e) {
        var lec_id =$(this).data('id');
        var lec_name =$(this).data('name');
        $('#lec_id').val(lec_id);
        $('#name2').val(lec_name);


})
$(".delete11").on("click", function (e) {
        var lec_id =$(this).data('id');
        var lec_name =$(this).data('name');
        $('#lec_id').val(lec_id);
        $('#name2').val(lec_name);


})


</script>

@endsection
