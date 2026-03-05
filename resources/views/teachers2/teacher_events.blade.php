@extends('teachers2.layouts.app')
@section('css')
<style>
    .modal-title{
        left:6px;
    }
</style>



@endsection
@section('content')
  <!--link cards-->
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <style>
.card11 {
  --font-color: #ffff;
 /* --bg-color: #e0e0e0;*/
  width: auto;
  height: 100%;
  border-radius: 20px;
  /*background: var(--bg-color);*/
  background: linear-gradient(222deg, #a5c9ff  60%, #a5c9ff  88%,
     rgb(255, 211, 195) 10%, #4382E0 88%);

  box-shadow: -9px 9px 18px #5a5a5a,
              9px -9px 18px #ffffff;
  display: flex;
  flex-direction: column;
  transition: .4s;
  position: relative;
  direction: rtl;
  text-align: right;
}

.card11:hover {
  transform: scale(1.02);
  box-shadow: 0px 0px 10px 2px #5a5a5a;
}

.card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 20px 20px 0 0;
  background-color: blueviolet;
}

.card__descr-wrapper {
  padding: 15px;
  display: grid;
}

.card__title {
  color: var(--font-color);
  text-align: center;
  margin-bottom: 13px;
  font-size: 20px;
  font-weight: 900;
  font-size: 16px;
}

.card__descr {
  color: var(--font-color);
  height: 100px;
  margin-bottom: 20px;
  /*overflow: scroll;*/
}

.svg {
  width: 25px;
  height: 25px;
  transform: translateY(25%);
  fill: var(--font-color);
}

.card__links {
  margin-top: 10px;
  display: flex;
  justify-content: space-between;
  align-self: flex-end;
}

.card__links .link {
  color: var(--font-color);
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
}

.card__links .link:hover {
  text-decoration: underline;
}
/*add event*/
 a:hover{
  color: #fff ;
  text-decoration: none;
}
.addevent {
  outline: none;
  color: #fff ;
  padding: 1em;
  padding-left: 1em;
  padding-right: 1em;
  border: 2px dashed #14315C ;
  border-radius: 15px;
  background-color: #4382E0 ;
  box-shadow: 0 0 0 4px #4382E0, 2px 2px 4px 2px rgba(0, 0, 0, 0.5);
  transition: .1s ease-in-out, .4s color;
}

.addevent:active {
color: #fff ;
  transform: translateX(0.1em) translateY(0.1em);
  box-shadow: 0 0 0 4px #EADDCA, 1.5px 1.5px 2.5px 1.5px rgba(0, 0, 0, 0.5);
}
/*add event*/
.col-md-4{
  margin-bottom: 20px;
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5;

    /* margin: 0 auto; */
    margin: auto;

    font-size: 30px;
    color: #152C4F;
}
.modal-header .close {
    padding: 0rem 0rem;
    margin: 0px 0px 0px ;

}
.form-group label{
  font-size: 0.875rem;
  line-height: 1;
  vertical-align: top;
  margin-bottom: 0.5rem;
  float: right;
}
@media(min-width:200px) and (max-width:330px){
  .newadd{
    padding-left: 139px !important;
  }
}
@media(min-width:330px) and (max-width:400px){
  .newadd{
    padding-left: 170px !important;
  }
}

@media(min-width:401px) and (max-width:600px){
  .newadd{
    padding-left: 224px !important;
  }
}
@media(min-width:601px) and (max-width:1031px){
  .newadd{
    padding-left: 204px !important;
  }
}


  </style>


        <div class="main-panel" >
            <!--content-wrapper -->
          <div class="content-wrapper pb-0">
             <div class="container">
              <div class="row newadd animated fadeInDown" style="padding-top: 20px;justify-content: right;padding-left: 350px;">
                 <div class="col-md-4">
                  <a href="#" class="addevent"  data-toggle="modal" data-target="#basicModal">
                    اضافة حدث
                  </a>

                 </div>

              </div>
             <div class="row" style="padding-top: 20px;">

              @foreach ($teacher_events as $item)
              <div class="col-md-4">
                <div class="card11">
                  <!--div class="card__img"></div-->
                  <div class="card__descr-wrapper">
                    <p class="card__title" style="font-size: 20px !important;">
                      {{$item->title}}
                  </p>
                  <p style="font-size: small; color:#fff"> {{$item->classes->name}} / {{$item->rooms->name}}  </p>
                  <p class="card__descr">
                     {{$item->content}}
                  </p>
                  <div class="card__links">
                    <p style="color:white">
                      {{$item->date->format('d/m/Y') }}
                   </p>
                   
                    <div>
                      <a class="link edit11" title="تعديل"  data-toggle="modal" data-target="#basicModal4"
                      data-name="{{ $item->title }}"
                    data-id="{{ $item->id }}" data-date="{{ $item->date }}"
                    data-content="{{ $item->content }}"
                    data-classes="{{ $item->classes->name}}"
                    data-rooms="{{$item->rooms->name}}">
                        <i class="fa fa-pencil" style="font-size: 18px;"></i>
                    </a>
                    <span class="link" data-lec_id="{{ $item->id }}"
                        data-toggle="modal" data-target="#delete_question"  >  <i class="fa fa-trash"></i>  </span>




                    </div>
                  </div>
                  </div>
                </div>
               </div><!--end col-->
              @endforeach
             </div>

    <!--modal for add event-->
    <!-- basic modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">اضافة حدث</h4>
          </div>
          <div class="modal-body" style="direction: rtl;">
            <form action="{{ route('dashboard.event.store') }}" method="post" autocomplete="off">
                @csrf
              <div class="form-group">
                <label for="exampleInputUsername1">عنوان الحدث</label>
                <input type="text" name="title" class="form-control"   id="name" placeholder=" عنوان الحدث  " />
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">تحديد الصف</label>
                <input type="hidden" name="teacher_id" id="" value="{{ $teacher->id }}">
                <select class="form-control form-control-lg" id="classes2" name="class_id">
                    <option value="" style="text-align: center;">اختر الصف </option>
                    @foreach ($classes as $item )
                    <option value="{{ $item->id }}" style="text-align: center;">
                        {{ $item->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">تحديد الشعبة</label>
                <select id="room3"  name="room_id" class="form-control form-control-lg">

                </select>

            </div>
            <div class="form-group">
                <label for="exampleInputUsername1">تاريخ الحدث</label>
                <input type="date" class="form-control" name="date" placeholder="ادخل  تاريخ "
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'date'" placeholder="تاريخ الحدث" />

            </div>

            <div class="form-group">
                <label for="exampleInputUsername1">المحتوى</label>
                <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button  type="submit" class="button" style="width:130px">
                    حفظ
                </button>
            </div>
            </form>
          </div>

      </div>
    </div>
<!--end modal for add event-->



          </div><!--content-wrapper-->
          <!--end content-->
                   <!--modal for edit event-->
    <!-- basic modal -->
    <div class="modal fade" id="basicModal4" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">تعديل الحدث</h4>
            </div>
            <div class="modal-body" style="direction: rtl;">

                <form action="{{ route('teacher_events.edit') }}" method="post" id="confirm4">
                    @csrf
                <div class="form-group">
                    <input type="text"  name="event_id" id="event_id"  hidden >

                  <label for="exampleInputUsername1">عنوان الحدث</label>
                  <input type="text" class="form-control"  id="title" name="title" placeholder="عنوان الحدث" />
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">تحديد الصف</label>
                  <input style="text-align: right;" readonly type="text"  id="classes_name" class="form-control" >
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">تحديد الشعبة</label>
                  <input style="text-align: right;" readonly type="text"  id="room_name" class="form-control" >
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">تاريخ الحدث</label>
                  <input style="text-align: right;" name="date" id="date" placeholder="ادخل  تاريخ "
                  onfocus="this.placeholder = ''"
                  onblur="this.placeholder = 'date'"
                  class="common-input mb-20 form-control"  type="date">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">المحتوى</label>


                  <textarea name="content" id="content" class="form-control" cols="3"
                  rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="button">حفظ</button>
                  </div>
            </form>
         </div>
          </div>
        </div>
      </div>
  <!--end modal for edit event-->

  <div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">حذف حدث</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<form action="{{ route('dashboard.event.delete') }}" method="post">
@csrf
</div>
<div class="modal-body" style="justify-content: center; text-align:center">
هل انت متاكد من عملية الحذف ؟
<input type="hidden" name="question_id" id="question_id" value="">
</div>
<div class="modal-footer">
<button type="button" class="button" data-dismiss="modal">الغاء</button>
<button type="submit" class="button">تاكيد</button>
</div>
</form>
</div>
</div>
</div>
<!-- end event -->

      </div><!--main-panel-->
      @endsection
      @section('js')
      <script>
    $(document).ready(function () {
    $(document).on('change', '#classes2', function () {
        var teacher_id = $('#teacher_id').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" + teacher_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
                $('#room3').empty();
                $('#room3').append(
                    `<option value="" style="text-align: center;">اختر الشعبة  </option>`
                    )

                $.each(data, function (key, value) {
                    $('#room3').append(
                        `<option style="text-align: center;" value="${value.id}">${value.name}</option>`
                        )
                });
            },
            error: function (xhr) {}
        });
    })
})

$('#delete_question').on('show.bs.modal', function(event) {
var button = $(event.relatedTarget)
var question_id = button.data('lec_id')
var modal = $(this)
modal.find('.modal-body #question_id').val(question_id);
})
   $(".edit11").on("click", function (e) {
        var id =$(this).data('id');
        var date =$(this).data('date');
        var content =$(this).data('content');
         var classes =$(this).data('classes');
          var rooms =$(this).data('rooms');
        var title =$(this).data('name');
          $('#event_id').val(id);

        $('#title').val(title);
        $('#classes_name').val(classes);
         $('#room_name').val(rooms);
          $('#content').val(content);
             $('#date').val(date);



})
      </script>
      @endsection
