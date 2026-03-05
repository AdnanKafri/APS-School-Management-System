@extends('admin.master')

@section('style')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   <style>
        body {
	font-family: 'Varela Round', sans-serif;
}
.modal-confirm {
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
	color: #999;
}
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
    </style>

@endsection
@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> تحديد مهام الموجه التربوي</a>
    <a  href="{{ route('supervisors') }}" class="breadcrumbs__item ">   قسم الموجهين التربويين  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')


    <div class="container" style="margin: 50px">
        <div class="row">

            <div class="col-md-12" >
                <h3 class="text-center">تحديد مهام الموجه التربوي</h3>
            </div>


            <div class="col-md-12">
                <form action="{{ route('supervisor.store_supervisor_set_task') }}" method="post"  enctype="multipart/form-data" >

                @csrf
                    <input type="hidden" name="supervisor_id" value="{{ $supervisor->id }}">

                <div style="">
                    <div class="form-group" style="text-align:right">
                        <label>الصف</label>

                        <select name="class_id[]" required id="classes" class="form-control classes dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر الصف الدراسي</option>

                        @foreach ($classes as $class)

                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach

                        </select>

                    </div>
                    <div class="form-group class_lessons" id="" style="text-align:right">

                    </div>
                    <div class="form-group class_rooms" id="" style="text-align:right">

                    </div>
                    <div class="" style="">



                    </div>


                    <div class="form-group mydiv" id="mydiv" style="text-align:right">



                    </div>



                </div>

                <span style="cursor: pointer" class="hvr-sweep-to-top btn btn-primary btn-block  add_new_work_experiences hover" href="">اضافة مهمة جديدة</span>



<br><br><br>

<button id="confirm1" type="submit" hidden>حفظ</button>

<div class="text-center">
    <!-- Button HTML (to Trigger Modal) -->
    <a href="#myModal" class="trigger-btn btn btn-success"data-toggle="modal">حفظ</a>
</div>

</form>
            </div>
        </div>
    </div>



classes

        <!-- Modal HTML -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog modal-confirm" style="">
                <div class="modal-content">
                    <div class="modal-header flex-column">
                        <div class="icon-box" style="border-color: green !important">
                            <div class="icon-preview col s6 m3"><i class="material-icons dp48" style="color: green">done</i><span></span></div>                        </div>
                        <h4 class="modal-title w-100">هل أنت متأكد ؟</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>هل حقاً تريد تحديد هذه المهام للمدرس</p>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="button" id="ok" class="btn btn-success">تأكيد</button>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('js')




<script>

    $(document).ready(function () {
        $('.lessons').select2();
        $('.rooms').select2();



$('#ok').click(function(){

     /* when the submit button in the modal is clicked, submit the form */


        $.each($('.classes'), function (key, value) {
            count=0;
        count1=0;
                v=$(this).val();
                   $.each($('.req'), function (key, value) {
                    if($(this).data('id')==v){
                        if($(this).is(':checked')){
                       count=count+1;
                    }

                   }})
                   $.each($('.req1'), function (key, value) {
                    if($(this).data('id')==v){
                        if($(this).is(':checked')){
                       count1=count1+1;
                    }}
})


            if(count  ==0 || count1 == 0){
                  count=0;
            count1=0;

                   alert('    يرجى اختيار   الشعبة والمادة')
                   return false
               }



})
if(count>0 && count1 >0){

$('#confirm1').click();
}



});




$(document).on('click' , '.deldiv' , function () {

    $(this).parent().remove();
});




$(document).on('click' , '.add_new_work_experiences' , function () {

var type=`
    <div style="border:1px solid #aaa; padding:10px; text-align:right">
        <div class="deldiv" style=" text-align:right;color:red">
    <i class="fa fa-window-close fa-3x " style="cursor:pointer" title="الغاء" aria-hidden="true"></i>
</div>
        <h1>صف جديد</h1>

                                <div class="form-group" style="text-align:right">
                                        <label>الصف</label>

                                        <select name="class_id[]"  required id="classes" class="form-control classes dep"
                                            style="min-height: 36px;direction: rtl">
                                            <option value="">اختر الصف الدراسي</option>

                                        @foreach ($classes as $class)

                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>
                                    <div class="form-group class_lessons" id=""  style="text-align:right">



                                    </div>
                                    <div class="form-group class_rooms" id="" style="text-align:right">

                                    </div>
                                    <div >



                                    </div>

                                </div>
        `;

        $(this).prev().append(type);





    });

$(document).on('change', '.classes', function () {
            var class_id = $(this).val();
            var url = "{{ URL::to('SMT/admin/classes/teacher_lessons') }}/" + class_id ;
            $(this).addClass('x');

            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    $('.x').parent().siblings('.class_lessons').empty();
                    $.each(data.lessons, function (key, value) {
                        $('.x').parent().siblings('.class_lessons').append(` <input  class="req" name="lesson_id[${class_id}][]" data-id="${class_id}"  type="checkbox" id="${value.name}${value.id}" value="${value.id}">
                         <label for="${value.name}${value.id}">&nbsp; ${value.name} &nbsp;</label>`);


                    });
                    $('.x').parent().siblings('.class_rooms').empty();

                    $.each(data.rooms, function (key, value) {
                        $('.x').parent().siblings('.class_rooms').append(` <input   class="req1" name="room_id[${class_id}][]"  data-id="${class_id}" type="checkbox" id="${value.name}${value.id}" value="${value.id}">
                             <label for="${value.name}${value.id}"> &nbsp; ${value.name} &nbsp;</label>`);


                    });
                    $('.x').removeClass('x');
                    $('.lessons').select2({
                        placeholder: "اختر مادة واحدة أو أكثر"
                    });
                     $('.rooms').select2({
                        placeholder: "اختر شعبة واحدة أو أكثر"
                     });
                     $('.select2-search__field').css('text-align','right');
                },
                error: function (xhr) {

                }

            });
});





        $(document).on('change', '.lessons', function () {

            // var lesson_id = $(this).val();
            // var a="room_id"+"["+lesson_id+"]"+"[]";
            // $(this).parent().next().find('.rooms').attr('name',a);
            // $(this).parent().next().find('.lesson_arr').val(lesson_id);

        });









    });
    </script>

@endsection
