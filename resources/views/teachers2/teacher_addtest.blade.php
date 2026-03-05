@extends('teachers2.layouts.app')
@section('css')
<style>
    /*responsive table*/
/**/

table {
border: 1px solid #ccc ;
border-collapse: collapse !important;
margin: 0 !important;
padding: 0 !important;
width: 100% !important;
margin-top:10px !important;
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
@media screen and (max-width: 900px) {

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
@media(min-width:200px) and (max-width:600px){}
.showstate {
    width: 91px;
    padding: 9px !important;
}
/*end responsiave table*/
.home {
    position: relative;
    /* margin: 0; */
    width: 120px;
    padding: 0.8em 1em;
    outline: none;
    text-decoration: none;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border: none;
    text-transform: uppercase;
    background-color: #152c4f;
    border-radius: 10px;
    color: #fff;
    font-weight: 300;
    font-size: 18px;
    font-family: inherit;
    z-index: 0;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
}
.home:hover{
    color: #fff
}
label{
    text-align: right
}
.btn-donate {
--clr-font-main: hsla(0 0% 20% / 100);
--btn-bg-1: hsl(216.12deg 92.45% 79.22%);
--btn-bg-2: hsl(215.92deg 71.69% 57.06%);
--btn-bg-color: hsla(360 100% 100% / 1);
--radii: 0.5em;
cursor: pointer;
padding: 0.9em 1.4em;
min-width: 60px;
min-height: 44px;
font-size: var(--size, 1rem);
font-weight: 500;
transition: 0.8s;
background-size: 280% auto;
background-image: linear-gradient(325deg, var(--btn-bg-2) 0%, var(--btn-bg-1) 55%, var(--btn-bg-2) 90%);
border: none;
border-radius: var(--radii);
color: var(--btn-bg-color);
box-shadow: 0px 0px 20px rgba(71, 184, 255, 0.5), 0px 5px 5px -1px rgba(58, 125, 233, 0.25), inset 4px 4px 8px rgba(175, 230, 255, 0.5), inset -4px -4px 8px rgba(19, 95, 216, 0.35);
}

.btn-donate:hover {
  background-position: right top;
}

.btn-donate:is(:focus, :focus-visible, :active) {
  outline: none;
  box-shadow: 0 0 0 3px var(--btn-bg-color), 0 0 0 6px var(--btn-bg-2);
}

@media (prefers-reduced-motion: reduce) {
  .btn-donate {
    transition: linear;
  }
}
.modal-title {
    line-height: 1.5;
    left: 0%;
    text-align: center;
    margin-bottom: 19px;
}
@media(min-width:100px) and (max-width:800px){
    .btn-donate{
        padding: 0px !important;
        position: relative;
        top: 10px !important;
        bottom: 5px !important
    }
}
/*حالة الامتحان*/
.showstate {
background: transparent;
position: relative;
/*padding: 5px 15px;*/
padding-right: 18px;
padding-top: 5px;
padding-bottom: 5px;
display: flex;
align-items: center;
font-size: 17px;
font-weight: 600;
text-decoration: none;
cursor: pointer;
border: 1px solid #152C4F;
border-radius: 25px;
outline: none;
overflow: hidden;
color: #152C4F ;
transition: color 0.3s 0.1s ease-out;
text-align: center;
}

.showstate span {
margin: 10px;
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
color: #152C4F ;
border: 1px solid #152C4F;
}

.showstate:hover::before {
box-shadow: inset 0 0 0 10em #152C4F;
}
</style>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"></script>
@section('content')

<div class="main-panel" style="background: #f8f9fb;">
    @if (session()->has('error'))
    <script>
        window.onload = function () {
            notif({
                msg: "يرجى تعديل الوقت ",
                type: "error"
            })
        }
    </script>
    @endif
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
    <li class="li"><a href="{{ route('dashboard.teacher') }}"> الصفحة الرئيسية</a></li>
    <li class="li"><a href="{{ route('dashboard.teacher.questions',[$class->id ,$room_id,$lecture_id,$lecture_id->lesson->id ]) }}">الاسئلة</a></li>
    <li class="li"><a href="#">الاختبارات</a></li>
   </ul>

    <div class="content-wrapper pb-0">
       <!--start content-->
        <div class="container" style="direction: rtl;">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                <!--select students-->
                <div class="container addexam1" style="position: relative;top: -8px;padding-right: 200px;">
                    <div class="row" style="padding-top: 30px;padding-bottom: 20px;">
                    <div class="col-md-5 " style="right: 45px;">
                        <a href="#" class="home"  data-toggle="modal" data-target="#demoModal1">
                        <span>اضافة اختبار</span>
                        </a>
                    </div>
                    </div>
                </div>

                <div class="modal fade auto-off"id="demoModal1" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
                <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                <div class="modal-content" style="padding-top: 50px !important;">
                    <div class="container-fluid">

                        <form action="{{ route('dashboard.exam.store') }}" method="post" autocomplete="off" style="text-align: initial;
                        direction: rtl;">
                        @csrf
                        <h5 class="modal-title" id="exampleModalLabel">اضافة الاختبار</h5>
                        <input type="hidden" name="class_id" id="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="room_id" id="class_id" value="{{ $room_id}}">
                        <input type="hidden" name="lecture_id" id="class_id" value="{{ $lecture_id->id }}">
                        <input type="hidden" name="lesson_id" id="class_id" value="{{ $lecture_id->lesson->id }}">
                        <input type="hidden" name="teacher_id" id="teacher_id" value="{{ auth()->user()->teacher_id }}">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="row" style="direction: rtl;">
                                <div class="col-md-12">

                                <div class="video-wrapper">
                                    <div class="form-group">
                                        <label style="color: #094e89; float: right;">عنوان الاختبار</label>
                                        <input type="text" name="name_exam"
                                        id="name"  required  class="form-control" id="exampleInputUsername1" placeholder="ادخل عنوان الاختبار" />
                                    </div>

                                    <div class="form-group">
                                        <select id="myselection" name="type" class="form-control form-control-lg" >
                                        <option style="text-align: center;" value="3">اختبار</option>
                                        </select>
                                    </div>

                                       <label  style="color: #094e89; float: right;">بداية الوقت </label>
                                       <input style="text-align: right;" type="datetime-local" class="form-control"   id="name"  name="start_time"  required placeholder="ادخل بداية الوقت ">
                                       <br>
                                       <br>
                                       <label  style="color: #094e89; float: right;">نهاية الوقت </label>
                                       <input style="text-align: right;" type="datetime-local" class="form-control"  id="name" name="end_time" required placeholder="ادخل نهاية الوقت">
                                       <br>
                                       <br>
                                       <label  style="color: #094e89; float: right;">علامة الاختبار</label>
                                       <input style="text-align: right;" required class="form-control" type="number" min="1"  class="form-control" name="success_mark"
                                             id="name" placeholder="ادخل علامة الاختبار">
                                       <br>
                                       <br>
                                       <label  style="color: #094e89; float: right;">الفترة الزمنية</label>
                                       <input style="text-align: right;" type="number" class="form-control" name="period"
                                       id="name" placeholder="ادخل الفترة الزمنية ">
                                       <br>
                                       <br>
                                       <label  style="color: #094e89; float: right;">الملاحظات</label>
                                       <textarea name="note" id="" cols="30" rows="5" class="form-control"></textarea>


                                 </div>
                                   {{-- <form>
                                       <button type="submit" class="btn " data-dismiss="modal" aria-label="Close">
                                         </button>
                                   </form> --}}
                               </div>
                           </div><!--end row-->
                           <div class="row" style="text-align: center;">
                              <div class="col-md-12">
                               <button class="newbtn2 home" type="submit"  style="margin: 0;width: 70px;">حفظ </button>
                               <button type="button" class="home" data-dismiss="modal" style="margin: 0;
                               width: 70px;">اغلاق</button>

                              </div>
                           </div>
                           <br>

                        </form>

                       </div>
                   </div>
                </div>
                </div>
<!--end modal for add student-->

                  <!--end select students-->
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>اسم الامتحان</th>
                          <th>وقت البداية</th>
                          <th>وقت النهاية</th>
                          <th>نوع الامتحان</th>
                          <th>الاسئلة</th>
                          <th>عمليات التعديل</th>


                        </tr>
                      </thead>
                      <tbody class="table-hover">
                        @foreach (  $exams as  $item )
                        <tr id="exam1">
                            @if ($item ->name_exam !=null)
                            <td data-label="الاسم">{{ $item->name_exam }}  </td>
                            @else
                            <td data-label="الاسم">{{ $item->name_quize1 }}</td>
                            @endif

                            <td data-label="وقت البداية" > {{ $item ->start_time }} </td>
                            <td data-label="وقت النهاية"> {{ $item ->end_time }} </td>

                            <td data-label="">اختبار  </td>


                            <td data-label="الاسئلة">
                                <a class="showstate" href="{{ route('dashboard.exams_addquestion',[$item->id,$lecture_id->id,$room_id]) }}" type="button" >اضافة سؤال </a></td>
                                <td data-label="عمليات التعديل">
                                    <button   class="newbtn btn-donate"  data-exam_id="{{ $item->id }}" data-exam_title="{{ $item->exam_title }}"
                                data-toggle="modal" data-target="#delete_exam">حذف </button> &nbsp;
                                @if ($item->name_exam !=null)
                                <button class="btn-donate edit"  style="border:none"
                                data-name="{{ $item ->name_exam  }}"
                                data-mark="{{ $item ->success_mark }}"
                                  data-note="{{  $item->note }}"
                                  data-peroid="{{ $item ->period }}"
                                   data-id="{{  $item ->id }}"
                                   data-endtime="{{  $item ->end_time }}"
                                   data-starttime="{{  $item ->start_time }}"
                                        data-toggle="modal"
                                        data-target="#staticBackdrop{{ $item ->id }}">تعديل</button>
                                    @else
                                    <button class="btn-donate edit"  style="border:none"
                                    data-name_quize="{{ $item ->name_quize1  }}"
                                    data-mark="{{ $item ->success_mark }}"
                                    data-note="{{  $item->note }}"
                                     data-peroid="{{ $item ->period }}"
                                      data-id="{{  $item ->id }}"
                                      data-endtime="{{  $item ->end_time }}"
                                        data-starttime="{{  $item ->start_time }}"
                                         data-toggle="modal"
                                        data-target="#staticBackdrop{{ $item ->id }}">تعديل</button>
                                    @endif
<!-- start  model-->
<div class="modal fade auto-off"id="staticBackdrop{{ $item ->id }}"
     tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
        <div class="modal-content" style="padding-top: 50px !important;">
            <div class="container-fluid">
                <div class="text-right">
                    <i style="color:#495057" class="fa fa-close close" data-dismiss="modal">
                    </i>
                    <br>
                </div>
                <form action="{{ route('dashboard.exam.update') }}" method="post" autocomplete="off">
                @csrf
                <input hidden  type="text"  name="exam_id" class="exam_id"  value="exam_id">

                <h5 class="modal-title" id="exampleModalLabel">تعديل الاختبار</h5>
                <div class="text-right">
                    <br>
                    <!-- start select option-->

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">عنوان الاختبار</label>
                        <input style="text-align: right;" type="text"  class="form-control name1" name="name" value=""
                         placeholder="ادخل اسم الاختبار ">
                    </div>
                    <div class="form-group">
                        <label style="color: #094e89; float: right;">نوع الاختبار</label>
                        <select id="myselection" name="type" class="form-control form-control-lg" >
                            <option style="text-align: center;" value="3">اختبار</option>
                            </select>
                    </div>

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">علامة الاختبار</label>
                        <input style="text-align: right;" type="number" 

                                class="form-control mark" name="success_mark"
                                placeholder="ادخل علامة الاختبار">
                    </div>

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">بداية الوقت</label>
                        <input   value="{{ $item->start_time }}"
                        style="text-align: right;" name="start_time"
                                        placeholder="ادخل بداية الوقت "
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter start quize time'"
                                        class="common-input mb-20 form-control strat" required=""
                                        type="datetime-local">
                    </div>

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">نهاية الوقت</label>
                        <input style="text-align: right;" name="end_time"
                        value="{{ $item->end_time}}"
                        placeholder="ادخل نهاية الوقت"
                        onfocus="this.placeholder = ''"
                        onblur="this.placeholder = 'Enter start quize time'"
                        class="common-input mb-20 form-control end" required=""
                        type="datetime-local">
                    </div>

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">الفترة الزمنية</label>
                        <input style="text-align: right;"
                        name="period"  type="number"
                        class="form-control peroid"
                        placeholder="ادخل الفترة الزمنية ">
                    </div>

                    <div class="form-group">
                        <label style="color: #094e89; float: right;">ملاحظات</label>
                        <textarea name="note"
                         class="form-control note"
                        style="direction:rtl" cols="3" rows="2"></textarea>
                    </div>

                    <div class="row" style="text-align: center;">
                        <div class="col-md-12">
                         <button class="home" type="submit"  style="margin: 0;width: 70px;">حفظ </button>
                         <button type="button" class="home" data-dismiss="modal" style="margin: 0;
                         width: 70px;">اغلاق</button>

                        </div>
                     </div>
                    </div>
                </form>

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
                  </div>
                </div>
              </div>
            </div>

           </div>

        </div>
       <!--end content-->
    </div><!--end content-wrapper pb-0-->
  </div><!--end main panels-->


  {{-- حذف اختبار --}}
  <div class="modal fade" id="delete_exam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header" style="direction: rtl;">
  <h5 class="modal-title" id="exampleModalLabel">حذف الاختبار</h5>

  <form   action="{{ route('dashboard.exam.delete') }}" method="post">
   @csrf

  </div>
  <div class="modal-body" style="text-align:center">
  هل انت متاكد من عملية الحذف ؟
  <input type="hidden" name="exam_id" id="exam_id" value="">
  </div>
  <div class="modal-footer">
    <div class="row" style="text-align: center;">
        <div class="col-md-12">
         <button class="home" type="submit"  style="margin: 0;width: 70px;">حذف</button>
         <button type="button" class="home" data-dismiss="modal" style="margin: 0;
         width: 70px;">اغلاق</button>

        </div>
     </div>
  </div>
  </form>
  </div>
  </div>
  </div>
  {{-- نهاي حذف اختبار --}}
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
            $('.type').append(`<option style="text-align: center;" value="1">اختبار</option>`)

        }
        else{
            $('.name1').val(name_quize)
          $('.type').append(`<option style="text-align: center;" value="1">اختبار</option>`)
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

    
</script>
@endsection
