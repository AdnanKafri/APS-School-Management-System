<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('students/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('students/css/font-awesome.min.css') }}">

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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
</head>
<body>


    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <h3 class="text-center">تعديل المهام</h3>
            </div>


            <div class="col-md-12">
                <form action="{{ route('supervisor.update_supervisor_set_task') }}" method="post"  enctype="multipart/form-data" >


                @csrf
                <input type="hidden" name="supervisor_id" value="{{$supervisor->id}}">

                    @if(isset($lessons))
                    @foreach ($lessons as $item)

                    <div style="border:1px solid #aaa; padding:10px; text-align:right">
<div class="deldiv" style=" text-align:right;color:red">
<i class="fa fa-window-close fa-3x " style="cursor:pointer" title="الغاء" aria-hidden="true"></i>
</div>
                            <label>الصف</label>

                        <div class="form-group">
                            <input type="hidden" value="{{ $item->id }}" class="lesson_old">
                            <select name="class_id[]" id="classes" class="form-control classes one"
                                style="min-height: 36px;direction: rtl">
                                <option value="">اختر الصف الدراسي</option>

                            @foreach ($classes as $class)
                            @if ($class->id == $item->classes2[0]->id)
                            <option value="{{ $class->id }}" selected>{{ $class->name }}</option>

                            @endif
                            @endforeach

                            </select>

                        </div>
                        <div class="form-group class_lessons" id="" style="text-align:right">
                            <label>المادة الدراسية</label>

                            <select name="lesson_id[]" id="" class="form-control lessons two"
                                style="min-height: 36px;direction:rtl"  required>
                                <option value="">اختر المواد الدراسية</option>

                                @foreach (App\Lesson::where('class_id',$item->class_id)->get() as $item2)
                                @if ( $item2->id ==  $item->id )
                                <option value="{{ $item2->id }}" selected>{{ $item2->name }}</option>
                                @else
                                <option value="" >{{ $item2->name }}</option>

                                @endif

                                @endforeach
                            </select>

                                </div>
                                <div class="form-group class_rooms" id="">

                                </div>

                                <div></div>

                                <div class="form-group mydiv" id="mydiv">



                                </div>



                    </div>



                    @endforeach
                     @endif

                <span style="cursor: pointer" class="hvr-sweep-to-top btn btn-primary btn-block  add_new_work_experiences hover" href="">اضافة مهمة جديدة </span>



<br><br><br>

<button id="confirm1" hidden>حفظ</button>

<div class="text-center">
    <!-- Button HTML (to Trigger Modal) -->
    <a href="#myModal" class="trigger-btn btn btn-success"data-toggle="modal">حفظ</a>
</div>





                </form>

            </div>

        </div>
    </div>


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
                        <p>هل حقاً تريد حفظ هذه التغييرات .</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="button" id="ok" class="btn btn-success">تأكيد</button>
                    </div>
                </div>
            </div>
        </div>



    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script src="{{ asset('students/js/bootstrap.min.js') }}"></script>
    <script>




$(document).ready(function () {


        $(document).on('click' , '.deldiv' , function () {

            $(this).parent().remove();
                       var lesson_id = $(this).parent().find('.lesson_old').val();

           var class_id = $(this).parent().find('.one').val();
           var room_id = $(this).parent().find('.two').val();
           console.log(room_id);
        });


    $('#ok').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    $('#confirm1').click();
});




    $(document).on('click' , '.add_new_work_experiences' , function () {

var type=`

    <div style="border:1px solid #aaa; padding:10px;text-align:right">
        <div class="deldiv" style=" text-align:right;color:red">
    <i class="fa fa-window-close fa-3x " style="cursor:pointer" title="الغاء" aria-hidden="true"></i>
</div>
        <h1>صف جديد</h1>

                             <div class="form-group">
                                <label>الصف</label>

                                <select name="class_id[]" id="classes" class="form-control classes dep"
                                    style="min-height: 36px;direction: rtl">
                                    <option value="">اختر الصف الدراسي</option>

                                @foreach ($classes as $class)

                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach

                                </select>

                            </div>
                            <div class="form-group class_lessons" id="" style="text-align:right">



                                    </div>
                                    <div>



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
                    var type = `
                    <label>المادة الدراسية</label>

                    <select name="lesson_id[]" id="" class="form-control lessons dep"
                        style="min-height: 36px;direction:rtl"  required>
                        <option value="">اختر المواد الدراسية</option>

                        `;

                    $.each(data, function (key, value) {


                        type += `
    <option value="${value.id}">${value.name}</option>

                          `;

                    });

                type+=`
                        </select>
                              `;
                              $('.x').parent().nextAll('.class_lessons').empty();

                              $('.x').parent().nextAll('.class_lessons').append(type);
                              $('.x').removeClass('x');


                },
                error: function (xhr) {

                }

            });
        });






$(document).on('change', '.lessons', function () {

var lesson_id = $(this).val();
var a="room_id"+"["+lesson_id+"]"+"[]";
$(this).parent().next().find('.rooms').attr('name',a);
$(this).parent().next().find('.lesson_arr').val(lesson_id);

});

});
    </script>
</body>

</html>
