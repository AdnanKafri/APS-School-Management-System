@extends('school_controller.layouts.app')
@section('content')

 <style>
 @media(min-width:200px) and (max-width:900px){
     .showstate{
         width:100px !important;
     }
 }
 .addquestion::before {
            content: "";
            background-color: #14315C !important;
            width: 0;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            transition: width 700ms ease-in-out;
            display: inline-block;
        }

        .addquestion {
            box-shadow: #14315C 0px 4px 0px 0px;
        }



        @media(min-width:200px) and (max-width:900px) {
            .showstate {
                width: 100px !important;
            }
        }

        .card .card-body {
            padding: 0px 0px;
            padding-bottom: 20px;
        }

        table {
            border: 1px solid #ccc;
            border-collapse: collapse !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;

        }

        table caption {
            font-size: 1.5em !important;
            margin: .25em 0 .75em !important;
        }

        table tr {
            background: #f8f8f8 !important;
            border: 1px solid #ddd;
            padding: .35em !important;
        }

        table th,
        table td {
            padding: .625em !important;
            text-align: center !important;
        }

        table th {
            font-size: 20px !important;

        }

        table td img {
            text-align: center;
        }

        @media screen and (max-width: 900px) {

            table {
                border: none !important;
            }


            table thead {
                display: none !important;
            }

            table tr {
                /*border-bottom: 3px solid #ddd!important ;*/
                border-bottom: none !important;
                border-top: none !important;
                border-left: none !important;
                border-right: none !important;
                display: block !important;
                margin-bottom: .625em !important;
            }

            table td {
                padding: 10px !important;
                border-top: 1px solid #ddd !important;
                border-bottom: none !important;
                display: block !important;
                font-size: .8em !important;
                text-align: right !important;
            }

            table td:before {
                content: attr(data-label) !important;
                float: left !important;
                font-weight: bold !important;

            }

            table td:last-child {
                border-bottom: 1px solid #ddd !important;
                border-right: 1px solid #ddd;
            }


        }

        /*حالة الامتحان*/
        .showstate {
            width: 106px;
            background: transparent;
            position: relative;
            /*padding: 5px 15px;*/
            padding-right: 18px;
            padding-top: 5px;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
            font-size: 16px;

            text-decoration: none;
            cursor: pointer;
            border: 1px solid #152C4F;
            border-radius: 25px;
            outline: none;
            overflow: hidden;
            color: #152C4F;
            transition: color 0.3s 0.1s ease-out;
            text-align: center;
        }

        .showstate span {
            margin: 6px;
        }

        .showstate::before {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            content: '';
            border-radius: 50%;
            display: block;
            width: 20em;
            height: 20em;
            left: -5em;
            text-align: center;
            transition: box-shadow 0.5s ease-out;
            z-index: -1;
        }

        .showstate:hover {
            color: #152C4F;
            border: 1px solid #152C4F;
        }

        .showstate:hover::before {
            box-shadow: inset 0 0 0 10em #152C4F;
        }

        .nav-tabs {
            border: 0 !important;
            padding: 40px 0.7rem !important;
        }

        div .card .card-header {
            background: transparent !important;
            border-bottom: 0 !important;
            border-radius: 0 !important;
            padding: 0 !important;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background-color: #152c4fc7 !important;
            border-radius: 30px !important;
            color: #FFFFFF !important;
        }

        form div span {
            position: absolute;
            z-index: 5;
            display: block;
            height: 46px;
            width: 50px;
            text-align: center;
            line-height: 50px;
            color: gray;
            background-color: transparent;
            font-size: 20px;
        }

        .bu{
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: transparent;
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #cdcdcd;
  background: white;
  /*box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);*/
  cursor: pointer;
  transition-duration: .3s;
  overflow: hidden;
  position: relative;
}

.svgIcon {
  width: 12px;
  transition-duration: .3s;
}

.svgIcon path {
  fill: white;
}

.bu:hover {
  width: 100px;
  border-radius: 50px;
  transition-duration: .3s;
  background: white;
  align-items: center;
}

.bu:hover .svgIcon {
  width: 50px;
  transition-duration: .3s;
  transform: translateY(60%);
}

.bu::before {
  position: absolute;
  top: -14px;
  content: "";
  color: rgb(194, 188, 188);
  transition-duration: .3s;
  font-size: 2px;
}

.bu:hover::before {
  font-size: 13px;
  opacity: 1;
  transform: translateY(30px);
  transition-duration: .3s;
}
.modal-title {
  margin-bottom: 0;
    line-height: 1.5;
    text-align: center;
    justify-content: center;
    /* margin: 0 auto; */
    margin: auto;
    padding-left: 0px;
    font-size: 30px;
    text-align: center;
    margin: auto;
    color: #152C4F;
}

/*css for checkbox*/
.checkbox-wrapper-33 {
  --s-xsmall: 0.625em;
  --s-small: 1.2em;
  --border-width: 1px;
  --c-primary: #5F11E8;
  --c-primary-20-percent-opacity: rgb(95 17 232 / 20%);
  --c-primary-10-percent-opacity: rgb(95 17 232 / 10%);
  --t-base: 0.4s;
  --t-fast: 0.2s;
  --e-in: ease-in;
  --e-out: cubic-bezier(.11,.29,.18,.98);
}

.checkbox-wrapper-33 .visuallyhidden {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}

.checkbox-wrapper-33 .checkbox {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.checkbox-wrapper-33 .checkbox + .checkbox {
  margin-top: var(--s-small);
}

.checkbox-wrapper-33 .checkbox__symbol {
  display: inline-block;
  display: flex;
  margin-right: calc(var(--s-small) * 0.7);
  border: var(--border-width) solid var(--c-primary);
  position: relative;
  border-radius: 0.1em;
  width: 1.5em;
  height: 1.5em;
  transition: box-shadow var(--t-base) var(--e-out), background-color var(--t-base);
  box-shadow: 0 0 0 0 var(--c-primary-10-percent-opacity);
}

.checkbox-wrapper-33 .checkbox__symbol:after {
  content: "";
  position: absolute;
  top: 0.5em;
  left: 0.5em;
  width: 0.25em;
  height: 0.25em;
  background-color: var(--c-primary-20-percent-opacity);
  opacity: 0;
  border-radius: 3em;
  transform: scale(1);
  transform-origin: 50% 50%;
}

.checkbox-wrapper-33 .checkbox .icon-checkbox {
  width: 1em;
  height: 1em;
  margin: auto;
  fill: none;
  stroke-width: 3;
  stroke: currentColor;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-miterlimit: 10;
  color: var(--c-primary);
  display: inline-block;
}

.checkbox-wrapper-33 .checkbox .icon-checkbox path {
  transition: stroke-dashoffset var(--t-fast) var(--e-in);
  stroke-dasharray: 30px, 31px;
  stroke-dashoffset: 31px;
}

.checkbox-wrapper-33 .checkbox__textwrapper {
  margin: 0;
  position: relative;
  right: 5px;
}

.checkbox-wrapper-33 .checkbox__trigger:checked + .checkbox__symbol:after {
  -webkit-animation: ripple-33 1.5s var(--e-out);
  animation: ripple-33 1.5s var(--e-out);
}

.checkbox-wrapper-33 .checkbox__trigger:checked + .checkbox__symbol .icon-checkbox path {
  transition: stroke-dashoffset var(--t-base) var(--e-out);
  stroke-dashoffset: 0px;
}

.checkbox-wrapper-33 .checkbox__trigger:focus + .checkbox__symbol {
  box-shadow: 0 0 0 0.25em var(--c-primary-20-percent-opacity);
}

@-webkit-keyframes ripple-33 {
  from {
    transform: scale(0);
    opacity: 1;
  }

  to {
    opacity: 0;
    transform: scale(20);
  }
}

@keyframes ripple-33 {
  from {
    transform: scale(0);
    opacity: 1;
  }

  to {
    opacity: 0;
    transform: scale(20);
  }
}
/*end css for checkbox*/
.form{
  width:100%
}
.showstate {
    background: transparent;
    position: relative;
    padding: 5px 15px;}
    /**/

table {
  border: 1px solid #ccc ;
  border-collapse: collapse !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;

}

table caption {
  font-size: 1.5em !important;
  margin: .25em 0 .75em !important;
}

table tr {
  background: #f8f8f8 !important;
  border: 1px solid #ddd ;
  padding: .35em !important;
}

table th, table td {
  padding: .625em !important;
  text-align: center !important;
}

table th {
  font-size: 20px !important;

}

table td img { text-align: center; }
@media screen and (max-width: 600px) {

table { border: none !important; }


table thead { display: none !important; }

table tr {
  /*border-bottom: 3px solid #ddd!important ;*/
  border-bottom: none !important;
  border-top: none !important;
  border-left: none !important;
  border-right: none !important;
  display: block!important;
  margin-bottom: .625em !important;
}

table td {
  padding: 10px !important;
  border-top: 1px solid #ddd !important;
  border-bottom: none !important;
  display: block !important;
  font-size: .8em !important;
  text-align: right !important;
}

table td:before {
  content: attr(data-label) !important;
  float: left !important;
  font-weight: bold !important;

}

table td:last-child {
border-bottom: 1px solid #ddd !important;
border-right: 1px solid #ddd;
 }


}

@media (min-width: 1200px){
  .container, .container-sm, .container-md, .container-lg, .container-xl {
    max-width: 1000px;
}
}
/* add question */
.Btn {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border-radius: calc(45px/2);
  border: none;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background: linear-gradient(144deg,#7aaaf1,#4382e0 50%,#ffffff);
}

/* plus sign */
.sign {
  width: 100%;
  font-size: 2.2em;
  color: white;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}
/* text */
.text {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: white;
  font-size: 1.4em;
  font-weight: 500;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 45px;
  transition-duration: .3s;
}

.Btn:hover .sign {

  transition-duration: .3s;
  padding-left: 1px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;

  transition-duration: .3s;
  padding-right: 1px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}
.nav-tabs .nav-item .nav-link {
            border: 0 !important;
            color: #485a76 !important;
            font-weight: 900;
        }
    </style>
    @if (session()->has('success'))
<script>
    window.onload = function () {
        notif({
            msg: "تم   اضافة الطلاب   بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: " يجب تحديد الشعبة اولا ",
            type: "error"
        })
    }
</script>
@endif
@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: "   تم التعديل بنجاح  ",
            type: "success"
        })
    }
</script>
@endif

      <div class="main-panel" style="background: #f8f9fb;">
         <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
          <li class="li"><a href="{{ route('dashboard.coordinator.exams_quizes') }}">الصفحة الرئيسية</a></li>
          {{-- <li class="li"><a href="{{ route('dashboard.coordinator.marks.subjects',['room_id' => $room_id, 'coordinator_id' => $coordinator->id]) }}">المذاكرات والامتحانات</a></li> --}}
            <li class="li"><a href="#">جميع المذاكرات </a></li>
        </ul>
          <input hidden value="{{$room_id}}" id="room_id">
          <div class="content-wrapper pb-0">
             <!--start content-->
              <div class="container" style="direction: rtl;position: relative;">

                <!--nav tablist-->
                <div class="row">
                <div class="col-md-12  mr-auto">
                  <!-- Nav tabs -->
                  <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs justify-content-center" role="tablist">

                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">
                            <!--i class="now-ui-icons shopping_cart-simple"></i--> المذاكرات تقليدية
                          </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#auto_1" role="tab">
                               <!--i class="now-ui-icons objects_umbrella-13"></i-->
                               مذاكرات مؤتمتة
                           </a>
                           </li>


                      </ul>
                    </div>
                    <div class="card-body">
                      <!-- Tab panes -->
                      <div class="tab-content text-center ">
                        <div class="tab-pane active" id="profile" role="tabpanel">
                         <div class="container animated bounceInLeft">
                          <div class="row" style="justify-content: center;padding-bottom: 20px;padding-right: 66px;">
                            <div class="col-md-3">
                               <!--start add question-->
                               <!--<a  href="#modal" class="addquestion">-->
                               <!--  انشاء سؤال-->
                               <!--</a>-->
                               <!--end add question-->
                            </div>
                          </div>
                          <div>
                            <table>
                              <thead>
                                <tr>
                                  <th>الاسم</th>
                                  <th>وقت البداية</th>
                                  <th>وقت النهاية </th>
                                  <th>الحالة</th>
                                  <th>مشاهدة</th>
                                  <th>الفترة</th>
                                  <th>العلامة</th>
                                  <th>عرض العلامات </th>
                                  <th>رفع ملف</th>
                                  {{-- <th>اضافة طلاب</th> --}}

                                </tr>
                              </thead>

                              <tbody>
                                    @foreach (  $quizes as $item  )
                                <tr>
                                  <td class="py-1" data-label="الاسم">
                                  {{ $item->name }}
                                  </td>
                                  <td class="py-1" data-label="وقت البداية">{{ $item->start_date }}</td>
                                  <td class="py-1" data-label="وقت النهاية">
                                    {{ $item->end_date  }}
                                  </td>
                                  <td class="py-1" data-label="الحالة"> @if ($now < $item->start_date && $now < $item->end_date)
                              بالانتظار
                              @elseif($now > $item->start_date && $now < $item->end_date)
                          جاري
                          @elseif($now > $item->start_date && $now > $item->end_date)
                          انتهى
                          @endif</td>
                              <td data-label="مشاهدة">
                                   @if($item->file)
                          <a href="{{ asset('storage/'.$item->file) }}" type="button"  target="_blank" >
                          <span>     مشاهدة
                          </span></a>

                          @endif
                                 </td>
                              <td data-label="الفترة">{{ $item->period }} </td>
                              <td data-label="العلامة">{{ $item->mark }} </td>
                              <td data-label="عرض العلامات"><a href="{{ route('coor_quize_students',[$room_id ,$coordinator->id,$lesson_id,$item->id]) }}" class="showstate"><span>عرض العلامات</span></a></td>
                              <td data-label="رفع ملف">

                                    @if($item->question_picker == "1")
                                      @if ($now < $item->start_date && $now < $item->end_date)
                                      <a data-name_quize="{{ $item ->name  }}"  data-type="{{ $item ->type }}" data-lesson_id="{{$lesson_id}}"  data-groupe="{{ $item ->groupe }}"  data-quize="{{ $item ->quize }}" data-id="{{  $item ->id }}" data-endtime="{{  $item ->end_time }}"  data-start_time="{{  $item ->start_time }}" href="#" data-toggle="modal" data-target="#basicModal" class="bu edit">
                                  <i class="fa fa-plus" style="color: #14315C ; font-size: 20px;"></i>
                                  </svg>
                                </a>
                              @elseif($now > $item->start_date && $now < $item->end_date)
                          <a data-name_quize="{{ $item ->name  }}"  data-type="{{ $item ->type }}" data-lesson_id="{{$lesson_id}}"  data-groupe="{{ $item ->groupe }}"  data-quize="{{ $item ->quize }}" data-id="{{  $item ->id }}" data-endtime="{{  $item ->end_time }}"  data-start_time="{{  $item ->start_time }}" href="#" data-toggle="modal" data-target="#basicModal" class="bu edit">
                                  <i class="fa fa-plus" style="color: #14315C ; font-size: 20px;"></i>
                                  </svg>
                                </a>
                          @elseif($now > $item->start_date && $now > $item->end_date)
                      x
                          @endif
                                <!--add file-->

                                @endif
                                <!--end add file-->

                              </td>
                              {{-- <td data-label="اضافة طلاب">

                            @if ($now < $item->start_date && $now < $item->end_date)
                             <a href="#"  data-id="{{$item ->id}}"    data-room="{{$room_id}}" class="addstudent showstate" data-toggle="modal" data-target="#basicModal2"><span>اضافة طلاب</span></a>
                              @elseif($now > $item->start_date && $now < $item->end_date)
                          <a href="#"  data-id="{{$item ->id}}"    data-room="{{$room_id}}" class="addstudent showstate" data-toggle="modal" data-target="#basicModal2"><span>اضافة طلاب</span></a>
                          @elseif($now > $item->start_date && $now > $item->end_date)
                         غير متاح
                          @endif
                                </td> --}}

                                </tr>
                                 @endforeach


                              </tbody>
                            </table>
                          </div>
                         </div>

                        </div>
                        <div class="tab-pane" id="auto_1" role="tabpanel">
                            <!-- جدول الامتحانات المؤتمتة -->
                            <div class="container animated bounceInLeft">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>الاسم</th>
                                                        <th>وقت البداية</th>
                                                        <th>وقت النهاية </th>
                                                        <th>الحالة</th>
                                                        <th>مشاهدة</th>
                                                        <th>الفترة</th>
                                                        <th>العلامة</th>
                                                        <th>عرض العلامات </th>
                                                        <th>اضافة سؤال</th>
                                                        {{-- <th>اضافة طلاب</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (  $quize1 as $item  )
                                                    <tr>
                                                        <td>{{ $item->name }}  </td>
                                                        <td>{{ $item->start_date }}</td>
                                                        <td>{{ $item->end_date }}</td>

                                                        <td class="py-1">  @if ($now < $item->start_date && $now < $item->end_date)
                                                            بالانتظار
                                                            @elseif($now > $item->start_date && $now < $item->end_date)
                                                            جاري
                                                            @elseif($now > $item->start_date && $now > $item->end_date)
                                                            انتهى
                                                            @endif
                                                        </td>

                                                        <td> <a href="{{ route('coordinator.quest_exam1',[ $item->id,$class_id->id,$lesson_id]) }}" class="showstate"><span>مشاهدة</span></a> </td>

                                                        <td>{{ $item->period }} </td>
                                                        <td>{{ $item->mark }}</td>
                                                        <td><a  href="{{ route('coor_quize_students',[$room_id ,$coordinator->id,$lesson_id,$item->id]) }}"
                                                                class="showstate"><span>عرض العلامات</span></a>
                                                        </td>
                                                        <td class="py-1">
                                                            @if($item->question_picker == "1")
                                                            <a class="Btn" href="{{ route('coordinator_exams1_addquestion',[$item->id,$item->room->id,$class_id->id,$lesson_id]) }}"
                                                                style="margin: auto;">
                                                                <div class="sign">+</div>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        {{-- <td><a href="#" class="addstudent1 showstate"
                                                                data-toggle="modal"
                                                                data-target="#basicModal2" data-id="{{$item ->id}}" data-room="{{$room_id}}"><span>اضافة
                                                                    طلاب</span></a></td> --}}

                                                    </tr>
                                                    @endforeach



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- نهاية الامتحانات المؤتمتة -->
                        </div>


                      </div>
                    </div>
                  </div><!--end-->

                </div><!--end col-md-12-->
              </div><!--end row-->

    <!-- basic modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
          <form action="{{ route('coordinator.dashboard.exam.update123') }}" method="post"    enctype="multipart/form-data">

          @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">تحميل ملف</h4>
          </div>
          <div class="modal-body">
            <div class="">
                 <input hidden  type="text"  name="quize_id" class="quize_id">
                <div class="A"></div>

              <!--<span class="form-title" style="text-align: right;">تحميل ملف</span>-->

               <label for="file-input" class="drop-container">
              <span class="drop-title">
                 <br>
                 <br>
              </span>

              <input type="file" accept="image/*" name="quize" required="" id="file-input">
            </label>
          </div>
          </div>
          <div class="modal-footer" style="justify-content: center;">
            <button type="button" class="addquestion" data-dismiss="modal" style="width: 80px;
            height: 38px;">اغلاق</button>
            <button type="submit" class="addquestion"  style="width: 80px;
            height: 38px;">حفظ</button>
          </div>
        </div>
        </form>
      </div>
    </div>
<!--end modal for upload file-->

<!--modal for add student-->
    <!-- basic modal -->
    <div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
          <form action="{{ route('add_quize_student') }}" method="post"    enctype="multipart/form-data">

                                @csrf
                                <input hidden  type="text"  name="exam" class="exam">
                                <input hidden  type="text"  name="room_id" class="room_id">
                                 <input hidden  type="text"  name="lesson_id" value="{{$lesson->id}}" >
                                  <input hidden  type="text"  name="class_id" value="{{$class_id->id}}">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">اضافة طلاب</h4>
          </div>
          <div class="modal-body">
            <!--content of modal-->
            <div class="checkbox-wrapper-33">
              <!--start-->
               <div class="stud">

              </div>
              <!--end-->

               <!--start-->

              <!--end-->
            </div>
            <!--end content of modal-->
          </div>
          <div class="modal-footer">
            <button type="button" class="addquestion" data-dismiss="modal"  style="width: 80px;
            height: 38px;">اغلاق</button>
            <button type="submit" class="addquestion"  style="width: 80px;
            height: 38px;">حفظ</button>
          </div>
        </div>
      </div>
    </div>
<!--end modal for add student-->


              </div><!--end continer-->
             <!--end content-->
          </div><!--end content-wrapper pb-0-->
        </div><!--end main panels-->
            <!---modal popup-->
 <div id="modal" style="z-index: 9999;">
  <section>
    <form style="direction: rtl; text-align: right;">
      <div class="controls">
        <a href="#"><i class="fa fa-times"></i></a>
      </div>
      <h3 style="text-align: center;color: #152C4F ;">اختر الدرس</h3>
      <!--content of form-->
      <div class="container">
        <div class="row">
          <div class="col-md-4" style="height: 80px;">
            <div class="form-group newselect" style="width: 300px;">
              <select class="js-example-basic-single" style="width: 100%;direction: rtl;padding-bottom: 18px;">
                <option value="">اختر الدرس</option>
                <option value="">اسم الطالب الاول</option>
                <option value="">اسم الطالب الثاني</option>
                <option value="">اسم الطالب الثالث</option>
                <option value="">اسم الطالب الرابع</option>
                <option value="">اسم الطالب الرابع</option>
                <option value="">اسم الطالب الرابع</option>
                <option value="">اسم الطالب الرابع</option>
                <option value="">اسم الطالب الرابع</option>
                <option value="">اسم الطالب الرابع</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row" style="justify-content: center;top: 20px;">
          <div class="col-md-5">
           <!--submit button-->
           <button class="home" type="submit" style="width:150px;left: 20px;">حفظ</button>
           <!--end submit button-->
          </div>

        </div>

      </div><!--end container-->


      <!--end contetn of foem-->
    </form>
  </section>
</div>

@endsection


@section('js')
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
<script>

  $(".addstudent").on("click", function (e) {
      $('.stud').empty();
$('.stud').append(`
<label class="checkbox">
                <input type="checkbox" value="1" id="all" name="all" class="checkbox__trigger visuallyhidden">
                <span class="checkbox__symbol">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 28 28" height="28px" width="28px" class="icon-checkbox" aria-hidden="true">
                    <path d="M4 14l8 7L24 7"></path>
                  </svg>
                </span>
                <p class="checkbox__textwrapper">كل الطلاب  </p>
              </label>


                @foreach($students1 as $item )
                <label class="checkbox" for="{{$item->id}}">
                <input type="checkbox" name="student[]"   value="{{$item->id}}" id="{{$item->id}}"  class="checkbox__trigger visuallyhidden st">
                <span class="checkbox__symbol">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 28 28" height="28px" width="28px" class="icon-checkbox" aria-hidden="true">
                    <path d="M4 14l8 7L24 7"></path>
                  </svg>
                </span>
                <p class="checkbox__textwrapper">  {{$item->first_name}} {{$item->last_name}}  </p>
              </label>


                                @endforeach `);
      var exam =$(this).data('id');
       var room =$(this).data('room');
       $('.exam').val(exam);
        $('.room_id').val(room);
        var url = "{{ URL::to('SMARMANger/dashboard/coordinator/studentselect') }}/" + exam+"/"+room ;
        $.ajax({
url: url,

type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);

 $.each(data, function (key, value) {

      $.each($('.st'), function (key1, value1) {

          if(value1.value==value.id){
               $(this).attr( 'checked', true );
                 $("#all").prop('checked', false);
          }



      })




 })


},
error: function (xhr) {

}

});

  });


  $(".addstudent1").on("click", function (e) {
        $('.stud').empty();
    $('.stud').append(`

    <label class="checkbox">
                <input type="checkbox" value="1" id="all" name="all" class="checkbox__trigger visuallyhidden">
                <span class="checkbox__symbol">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 28 28" height="28px" width="28px" class="icon-checkbox" aria-hidden="true">
                    <path d="M4 14l8 7L24 7"></path>
                  </svg>
                </span>
                <p class="checkbox__textwrapper">كل الطلاب  </p>
              </label>


                @foreach ($students1 as $item)
                <label class="checkbox" for="{{ $item->id }}">
                <input type="checkbox" name="student[]"   value="{{ $item->id }}" id="{{ $item->id }}"  class="checkbox__trigger visuallyhidden st">
                <span class="checkbox__symbol">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 28 28" height="28px" width="28px" class="icon-checkbox" aria-hidden="true">
                    <path d="M4 14l8 7L24 7"></path>
                  </svg>
                </span>
                <p class="checkbox__textwrapper">  {{ $item->first_name }} {{ $item->last_name }}  </p>
              </label>


                                @endforeach`)
      var exam =$(this).data('id');
       var room =$(this).data('room');
       $('.exam').val(exam);
        $('.room_id').val(room);
          var url = "{{ URL::to('SMARMANger/dashboard/coordinator/studentselect') }}/" + exam+"/"+room ;
        $.ajax({
url: url,

type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);

 $.each(data, function (key, value) {

      $.each($('.st'), function (key1, value1) {

          if(value1.value==value.id){
               $(this).attr( 'checked', true );
                  $("#all").prop('checked', false);
          }




      })




 })

},
error: function (xhr) {

}

});

  })
      $(".edit").on("click", function (e) {
        var type= $(this).data('type');
        if(type=='5'){
            $('.auto').show();
            $('.normal').hide();
            var id= $(this).data('id');
            var name_quize= $(this).data('name_quize');
            var mark= $(this).data('mark');
            var peroid= $(this).data('peroid');
            var endtime= $(this).data('endtime');
            var starttime = $(this).data('start_time');

            $('.mark').val(mark)
            $('.peroid').val(peroid)
            $('.end').val(endtime)
            $('.note').val(note)
            $('.strat').val(starttime)
            $('.quize_id').val(id)
            $('.name1').val(name_quize)




        }
        else if(type=='2'){
 $('.A').empty();
            room_id= $('#room_id').val();

            $('.auto').hide();
            $('.normal').show();
            var id= $(this).data('id');
             var lesson_id= $(this).data('lesson_id');


            var name_quize= $(this).data('name_quize');

            var endtime= $(this).data('endtime');
            var starttime = $(this).data('start_time');
            var groupe = $(this).data('groupe');
            var quize_file = $(this).data('quize');

            $('.name1').val(name_quize)


            $('.strat').val(starttime)
            $('.end').val(endtime)

            $('.quize_id').val(id)


 var data={

                        "id":id,
                         "groupe":groupe,
                          "lesson_id":lesson_id,


                    }
var url = "{{ URL::to('SMARMANger/dashboard/coordinator/detexam') }}"  ;
$.ajax({
url: url,
data : data,
type: "get",
contentType: 'application/json',
success: function (data) {
      if(quize_file){
                $('.A').append(`
                                <a  href= "{{url('storage/') }}/${quize_file}"      id="quize_file"   target="_blank" style="margin:0 auto ">
                                <img src="{{  asset('teachers/photo/pdf1.png') }}"  style="height: 160px; width:160px; margin: 0 auto;">
                                </a>`);

            }
    console.log(data);
     $.each(data, function (key, value) {

    if(room_id== value.room.id){
         $('.A').append(` <label class="form__label"  for="${value.room.id}">${value.room.name}</label>
                             <input type="checkbox" name="room_id[]" value="${value.id}" id="${value.room.id}" checked >
                             <br>`);
    }
    else{
         $('.A').append(` <label class="form__label"  for="${value.room.id}">${value.room.name}</label>
                             <input type="checkbox" name="room_id[]" value="${value.id}" id="${value.room.id}" >
                             <br>`);
    }


     })


}})


        }







        })

          $(document).on('change', '.st', function (e) {
              if ($(this).is(':checked')) {
               $("#all").prop('checked', false);

              }


          })
           $(document).on('change', '#all', function (e) {
              if ($(this).is(':checked')) {
               $(".st").prop('checked', true);
              }
              else{
              $(".st").prop('checked', false);
              }

          })
        $(document).on('click', '.three', function (e) {




var id = $(this).data('id');

$('#s11').val($(this).data('id'));
$('.confirm3').data('id', id);



});

</script>
<script>

    var btnUpload = $("#upload_file"),
    btnOuter = $(".button_outer");
    btnUpload.on("change", function(e){
    var ext = btnUpload.val().split('.').pop().toLowerCase();


        $(".error_msg").text("");
        btnOuter.addClass("file_uploading");
        setTimeout(function(){
            btnOuter.addClass("file_uploaded");
        },3000);
        var uploadedFile = URL.createObjectURL(e.target.files[0]);
        setTimeout(function(){
            $("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
        },3500);

});
$(".file_remove").on("click", function(e){
    $("#uploaded_view").removeClass("show");
    $("#uploaded_view").find("img").remove();
    btnOuter.removeClass("file_uploading");
    btnOuter.removeClass("file_uploaded");
});

        </script>
    @endsection









