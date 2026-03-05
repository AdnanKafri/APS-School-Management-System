@extends('acadsupervisors.master')
@section('css')
<style>
    /*
	/*table */
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
  margin-top: -170px;
  margin-bottom: 100px;
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم مذاكرة ";
  }
  table tbody tr td:nth-child(2):before {
    content: "وقت البداية ";
  }
  table tbody tr td:nth-child(3):before {
    content: "وقت النهاية ";
  }
  table tbody tr td:nth-child(4):before {
    content: "نوع مذاكرة ";
  }
  table tbody tr td:nth-child(5):before {
    content: "الاسئلة ";
  }
  table tbody tr td:nth-child(5):before {
    content: "عمليات التعديل ";
  }
}


/* end table */
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #2c71ad;
  --darkgray: #2c71ad;
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


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;
  float: right;
  text-align: center;


}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #f38639;
  transition: .25s all ease;
  pointer-events: none;
  float: right;
  text-align: center;

}
/* Transition */
.select:hover::after {
  color: #f38639;
  text-align: center;
  float: right;


}
</style>

@endsection
@section('content')

@if (session()->has('Add'))
<script>
    window.onload = function () {
        notif({
            msg: "تم تعديل اختبار بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('update'))
<script>
    window.onload = function () {
        notif({
            msg: "تم اضافة اختبار  بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('success'))
<script>
    window.onload = function () {
        notif({
            msg: "تم حذف اختبار  بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: "يرجى تعديل الوقت .. الوقت غير صحيح ",
            type: "error"
        })
    }
</script>
@endif

<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread"> مذاكرات </h1>
            </div>
        </div>
    </div>
</section>
<!-- start new-->
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> اضافة  اختبار </a>
    <a  href="{{ route('coordinator_add_auto',[$class->id ,$lesson->id]) }}" class="breadcrumbs__item">اضافة محتوى مؤتمت  </a>
      <a  href="{{ route('coordinator_quize',[$class->id,$lesson->id]) }}" class="breadcrumbs__item">اضافة مذاكرة  </a>
      <a  href="{{ route('coordinator_lesson',[$class->id,$lesson->id]) }}" class="breadcrumbs__item ">{{ $lesson->name }} </a>
    <a  href="{{ route('dashboard.coordinator_subject',$class->id ) }}" class="breadcrumbs__item ">{{ $class->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<br>
  <br>
  <br>
  <br>

<!-- start add section-->
<div class="col-md-12 heading-section text-center ">
    <button style=" width:120px" type="button" class="btn btn-primary launch" data-toggle="modal"
        data-target="#staticBackdrop5">
        اضافة اختبار &nbsp; <i class="fa fa-plus"></i> </button>
    <!-- start  model-->
    <div class="modal fade" id="staticBackdrop5" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-right">
                        <i style="color:#495057" class="fa fa-close close" data-dismiss="modal">
                        </i>
                        <br>
                    </div>
                    <div class="tabs mt-3">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">

                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="visa" role="tabpanel" aria-labelledby="visa-tab">
                                <div class="mt-4 mx-4">
                                    <form action="{{ route('exam_store') }}" method="post" autocomplete="off">

                                        @csrf
                                        <input type="hidden" name="class_id" id="class_id" value="{{ $class->id }}">

                                        <input type="hidden" name="lesson_id" id="class_id" value="{{ $lesson_id }}">


                                    <div class="text-center" style="height: auto;">
                                        <h5> اضافة المذاكرة</h5>
                                        <br>
                                        <!-- start select option-->
                                        <span style="float: right;">اسم المذاكرة</span>
                                        <br>
                                        <input style="text-align: right;" type="text" class="form-control" name="name_exam"
                                            id="name" placeholder="ادخل اسم المذاكرة ">
                                        <br>
                                        <br>

                                        <span style="float:right">نوع المذاكرة</span>
                                        <br>
                                        <br>

                                        <select id="myselection" name="type"
                                            style="width: 300px;  height:50px; text-align: center;">
                                            <option style="text-align: center;" value="3">مذاكرة</option>
                                            {{-- <option style="text-align: center;"> اختيار النوع </option>
                                            <option style="text-align: center;" value="1">مذاكرة</option>
                                            <option style="text-align: center;" value="2">امتحان </option> --}}
                                        </select>
                                        <br>
                                        <br>

                                        <span style="float:right">اختر الشعبة </span>
                                        <br>
                                        <br>

                                        @foreach ($class->room as $item )

                                        <input type="checkbox" name="room_id[]"  id="roo{{ $item->id }}"  value="{{ $item->id }}">
                                        <label for="roo{{ $item->id }}">{{ $item->name }}</label>
                                        <br>
                                        @endforeach
                                        <br>
                                        <br>


                                        <span style="float: right;">علامة المذاكرة</span>
                                        <br>
                                        <input style="text-align: right;" type="number" class="form-control" name="success_mark"
                                            id="name" placeholder="ادخل علامة مذاكرة">
                                        <br>
                                        <br>

                                        <span style="float: right;"> بداية الوقت </span>
                                        <br>
                                        <input style="text-align: right;" name="start_time" placeholder="ادخل بداية الوقت "
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Enter start quize time'"
                                            class="common-input mb-20 form-control" required="" type="datetime-local">
                                        <br>
                                        <br>

                                        <span style="float: right;"> نهاية الوقت</span>
                                        <br>
                                        <input style="text-align: right;" name="end_time" placeholder="ادخل نهاية الوقت"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Enter start quize time'"
                                            class="common-input mb-20 form-control" required="" type="datetime-local">
                                        <br>
                                        <br>

                                        <span style="float: right;">الفترة الزمنية</span>
                                        <br>
                                        <input style="text-align: right;" type="number" class="form-control" name="period"
                                            id="name" placeholder="ادخل الفترة الزمنية ">
                                        <br>
                                        <br>

                                        <span style="float: right;">ملاحظات</span>
                                        <br>
                                        <textarea name="note" class="form-control" style="direction:rtl" cols="3"
                                            rows="2"></textarea>
                                        <br>
                                        <br>






                                        <div class="px-5 pay" style="text-align: center;">
                                            <button  type="submit" class="btn btn-primary" style="width: 200px;">
                                                حفظ
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end model-->

        <!--- end add section -->
    </div>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="modal fade" id="delete_exam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">حذف الامتحان</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form   action="{{ route('exam_delete') }}" method="post">
 @csrf

</div>
<div class="modal-body">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="exam_id" id="exam_id" value="">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
<button type="submit" class="btn btn-danger">تاكيد</button>
</div>
</form>
</div>
</div>
</div>

    <!-- marks of homework -->
    <table  >
        <thead>
            <tr>
                <th>
                   اسم المذاكرة
                </th>
                <th>
                    وقت البداية
                </th>
                <th>
                   وقت النهاية
                </th>
                <th>
                   الشعبة
                </th>
                <th>
                   الاسئلة
                </th>
                <th>
                    عمليات التعديل
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach (  $exams as  $item )
            <tr id="exam1">
                @if ($item ->name_exam !=null)
                <td>{{ $item->name_exam }}  </td>
                @else
                <td>{{ $item->name_quize }}</td>
                @endif

                <td> {{ $item ->start_time }} </td>
                <td> {{ $item ->end_time }} </td>
                {{-- @if ($item->name_exam !=null)
                <td>امتحان </td>
                @elseif($item->name_quize !=null)
                <td>مذاكرة </td>
                @else --}}
                <td>{{ $item->room->name }}   </td>
                {{-- @endif --}}

                <td>
                    <a href="{{ route('exams_addquestion',[$item->id,$item->room->id,$class->id,$lesson_id]) }}" type="button" class="btn" style="background-color: white; color: rgb(117, 115, 115);">اضافة سؤال </a></td>
                <td> <a  type="button" class="btn" style="background-color: white; color: rgb(117, 115, 115);"  data-exam_id="{{ $item->id }}" data-exam_title="{{ $item->exam_title }}"
                    data-toggle="modal" data-target="#delete_exam">حذف </a>&nbsp;
                    @if ($item->name_exam !=null)
                    <button  data-name="{{ $item ->name_exam  }}"  data-mark="{{ $item ->success_mark }}"  data-note="{{  $item->note }}" data-peroid="{{ $item ->period }}"  data-id="{{  $item ->id }}" data-endtime="{{  $item ->end_time }}"  data-starttime="{{  $item ->start_time }}" type="button" class="btn edit"  style="background-color: white; color: rgb(117, 115, 115);"data-toggle="modal"
                        data-target="#staticBackdrop{{ $item ->id }}">تعديل</button>
                        @else
                        <button  data-name_quize="{{ $item ->name_quize  }}"  data-mark="{{ $item ->success_mark }}"  data-note="{{  $item->note }}" data-peroid="{{ $item ->period }}"  data-id="{{  $item ->id }}" data-endtime="{{  $item ->end_time }}"  data-starttime="{{  $item ->start_time }}" type="button" class="btn  edit"  style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal"
                            data-target="#staticBackdrop{{ $item ->id }}">تعديل</button>
                        @endif
                    <!-- start  model-->
                    <div class="modal fade" id="staticBackdrop{{ $item ->id }}" data-backdrop="static" data-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-right">
                                        <i style="color:#495057" class="fa fa-close close" data-dismiss="modal">
                                        </i>
                                        <br>
                                    </div>
                                    <div class="tabs mt-3">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">

                                            </li>

                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="visa" role="tabpanel"
                                                aria-labelledby="visa-tab">
                                                <div class="mt-4 mx-4">
                                                    <form action="{{ route('exam_update') }}" method="post" autocomplete="off">

                                                        @csrf
                                                    <div class="text-center">
                                                        <h5> تعديل مذاكرة </h5>
                                                        <br>
                                                        <!-- start select option-->

                                                        <input hidden  type="text"  name="exam_id" class="exam_id">


                                                        <span style="float: right;    color: #010a46;">اسم مذاكرة</span>
                                                        <br>
                                                        <input style="text-align: right;" type="text"
                                                            class="form-control name1" name="name"

                                                            placeholder="ادخل اسم مذاكرة ">
                                                        <br>
                                                        <br>

                                                        <span style="float:right ; color: #010a46;">نوع مذاكرة</span>
                                                        <br>
                                                        <br>

                                                        <select id="myselection" name="type"
                                                            style="width: 300px;  height:50px; text-align: center;" class="type">



                                                        </select>
                                                        <br>
                                                        <br>

                                                        <span style="float: right;    color: #010a46;">علامة مذاكرة</span>
                                                        <br>
                                                        <input style="text-align: right;" type="number"
                                                            class="form-control mark" name="success_mark"
                                                            placeholder="ادخل علامة مذاكرة">
                                                        <br>
                                                        <br>

                                                        <span style="float: right;    color: #010a46;"> بداية الوقت </span>
                                                        <br>
                                                        <input   value="{{ $item ->start_time }}"   style="text-align: right;" name="start_time"
                                                            placeholder="ادخل بداية الوقت "
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter start quize time'"
                                                            class="common-input mb-20 form-control strat" required=""
                                                            type="datetime-local">
                                                        <br>
                                                        <br>

                                                        <span style="float: right;    color: #010a46;"> نهاية الوقت</span>
                                                        <br>
                                                        <input style="text-align: right;" name="end_time"
                                                            placeholder="ادخل نهاية الوقت"
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = 'Enter start quize time'"
                                                            class="common-input mb-20 form-control end" required=""
                                                            type="datetime-local">
                                                        <br>
                                                        <br>

                                                        <span style="float: right;    color: #010a46;">الفترة الزمنية</span>
                                                        <br>
                                                        <input style="text-align: right;"  name="period"  type="number"
                                                            class="form-control peroid"
                                                            placeholder="ادخل الفترة الزمنية ">
                                                        <br>
                                                        <br>

                                                        <span style="float: right;    color: #010a46;">ملاحظات</span>
                                                        <br>
                                                        <textarea name="note"  id="note" class="form-control note"
                                                            style="direction:rtl" cols="3" rows="2"></textarea>
                                                        <br>
                                                        <br>






                                                        <div class="px-5 pay" style="text-align: center;">
                                                            <button type="submit" class="btn btn-primary"
                                                                style="width: 200px;">
                                                                حفظ
                                                            </button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end model-->

                </td>
            </tr>


            @endforeach








        </tbody>
    </table>

    <!-- end marks of homework-->
    <br>
    <br>
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

        $(".edit").on("click", function (e) {
            $('.type').empty();
            var id= $(this).data('id');
            var name_exam= $(this).data('name');
            var name_quize= $(this).data('name_quize');
            var mark= $(this).data('mark');
            var peroid= $(this).data('peroid');
            var endtime= $(this).data('endtime');
            var starttime = $(this).data('starttime');
           var note = $(this).data('note');
            if(name_exam!=null){
                $('.name1').val(name_exam)
                $('.type').append(`<option style="text-align: center;" value="1">امتحان</option>`)

            }
            else{
                $('.name1').val(name_quize)
                $('.type').append(`<option style="text-align: center;" value="2">مذاكرة </option>`)
            }

            $('.mark').val(0)
            $('.peroid').val()
            $('.end').val()
            $('.start').val()
            $('.name').val()
            $('.mark').val(mark)
            $('.peroid').val(peroid)
            $('.end').val(endtime)
            $('.note').val(note)
            $('.start').val(starttime)
            $('.exam_id').val(id)


        })
$('#delete_exam').on('show.bs.modal', function(event) {
var button = $(event.relatedTarget);
var exam_id = button.data('exam_id');
var modal = $(this);

modal.find('.modal-body #exam_id').val(exam_id);
});
        var btnUpload = $("#upload_file"),
            btnOuter = $(".button_outer");
        btnUpload.on("change", function (e) {
            var ext = btnUpload.val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(".error_msg").text("Not an Image...");
            } else {
                $(".error_msg").text("");
                btnOuter.addClass("file_uploading");
                setTimeout(function () {
                    btnOuter.addClass("file_uploaded");
                }, 3000);
                var uploadedFile = URL.createObjectURL(e.target.files[0]);
                setTimeout(function () {
                    $("#uploaded_view").append('<img src="' + uploadedFile + '" />').addClass("show");
                }, 3500);
            }
        });
        $(".file_remove").on("click", function (e) {
            $("#uploaded_view").removeClass("show");
            $("#uploaded_view").find("img").remove();
            btnOuter.removeClass("file_uploading");
            btnOuter.removeClass("file_uploaded");
        });
        /* start upload audio */
        var btnUpload2 = $("#upload_file2"),
            btnOuter2 = $(".button_outer2");
        btnUpload2.on("change", function (e) {
            var ext = btnUpload2.val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['mp3']) == -1) {
                $(".error_msg2").text("Not an audio...");
            } else {
                $(".error_msg2").text("");
                btnOuter2.addClass("file_uploading2");
                setTimeout(function () {
                    btnOuter2.addClass("file_uploaded2");
                }, 3000);
                var uploadedFile2 = URL.createObjectURL(e.target.files[0]);
                setTimeout(function () {
                    $("#uploaded_view2").append('<img src="' + uploadedFile2 + '" />').addClass("show");
                }, 3500);
            }
        });
        $(".file_remove2").on("click", function (e) {
            $("#uploaded_view2").removeClass("show");
            $("#uploaded_view2").find("img").remove();
            btnOuter2.removeClass("file_uploading2");
            btnOuter2.removeClass("file_uploaded2");
        });
    </script>

    @endsection
