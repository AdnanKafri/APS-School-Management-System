@extends('teachers2.layouts.app')

@section('content')
  <style>
  @media(min-width:100px) and (max-width:900px){
      .login-html{
          padding: 40px 20px 50px 20px !important;
      }
  }
  .login-wrap{
	width:100%;
	margin:auto;
	max-width:525px;
	min-height:670px;
	position:relative;
	background:url(https://img.freepik.com/premium-vector/book-library-icon-comic-style-encyclopedia-cartoon-vector-illustration-white-isolated-background-dictionary-splash-effect-sign-business-concept_157943-12591.jpg?w=1000) no-repeat center;
	box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
  border-radius: 13px;
}
.login-html{
	width:100%;
	height:100%;
	position:absolute;
	padding:40px 70px 50px 70px;
	background:#4382e0c2;
  border-radius: 13px;
}
.login-html .sign-in-htm,
.login-html .sign-up-htm{
	top:0;
	left:0;
	right:0;
	bottom:0;
	position:absolute;
	transform:rotateY(180deg);
	backface-visibility:hidden;
	transition:all .4s linear;
  border-radius: 13px;
}
.login-html .sign-in,
.login-html .sign-up,
.login-form .group .check{
	display:none;
}
.login-html .tab,
.login-form .group .label,
.login-form .group .button{
	text-transform:uppercase;

}
.login-html .tab{
	font-size:22px;
	margin-right:15px;
	padding-bottom:5px;
  color: #14315C ;
	margin:0 15px 10px 0;
	display:inline-block;
	border-bottom:2px solid transparent;
  cursor: pointer;
}
.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab{
	color:#fff;
	border-color:#14315C  ;
}
.login-form{
	min-height:345px;
	position:relative;
	perspective:1000px;
	transform-style:preserve-3d;
}
.login-form .group{
	margin-bottom:15px;
}
.login-form .group .label,
.login-form .group .input,
.login-form .group .button{
	width:100%;
	/*color:#fff;*/
	display:block;
}
.login-form .group .input,
.login-form .group .button{
	border:none;
	/*padding:15px 20px;*/
	border-radius:25px;
	background:rgb(255 255 255 / 95%);
}
.login-form .group input[data-type="password"]{
	text-security:circle;
	-webkit-text-security:circle;
}
.login-form .group .label{
	color:#ffff ;
	font-size:20px;
  text-align: right;
}
.login-form .group .button{
	background:#152C4F ;
  width: 170px;
    margin: auto;
}
.login-form .group label .icon{
	width:15px;
	height:15px;
	border-radius:2px;
	position:relative;
	display:inline-block;
	background:rgba(255,255,255,.1);
}
.login-form .group label .icon:before,
.login-form .group label .icon:after{
	content:'';
	width:10px;
	height:2px;
	background:#fff;
	position:absolute;
	transition:all .2s ease-in-out 0s;
}
.login-form .group label .icon:before{
	left:3px;
	width:5px;
	bottom:6px;
	transform:scale(0) rotate(0);
}
.login-form .group label .icon:after{
	top:6px;
	right:0;
	transform:scale(0) rotate(0);
}
.login-form .group .check:checked + label{
	color:#fff;
}
.login-form .group .check:checked + label .icon{
	background:#152C4F ;
}
.login-form .group .check:checked + label .icon:before{
	transform:scale(1) rotate(45deg);
}
.login-form .group .check:checked + label .icon:after{
	transform:scale(1) rotate(-45deg);
}
.login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{
	transform:rotate(0);
}
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm{
	transform:rotate(0);
}

.hr{
	height:2px;
	margin:60px 0 50px 0;
	background:rgba(255,255,255,.2);
}
.foot-lnk{
	text-align:center;
}

form div span{
    background-color: #fff !important;

}

  </style>

        <div class="main-panel" >
            <ul class="breadcrumbs" style="padding-bottom: 7px;
                     padding-top: 11px;">
                    <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
                    <li class="li"><a href="{{route('get_message')}}">رسائل الطلاب</a></li>
                    <li class="li"><a href="#">ارسال رسالة</a></li>

                </ul>
          <div class="content-wrapper pb-0">
              <div class="container" style="padding-bottom: 150px;">
                <!--div class="form-group newselect">
                    <select class="js-example-basic-single" name="states[]" multiple="multiple" style="width: 100%;direction: rtl;">
                      <option value="">اختر الصف </option>
                      <option value="">الصف الأول</option>
                      <option value="">الصف الثاني</option>
                      <option value="">الصف الثالث</option>
                       <option value="">الرابع</option>
                       <option value="">الصف الخامس</option>
                       <option value="">الصف السادس</option>
                       <option value="">الصف السابع</option>
                    </select>
                  </div-->
                  <div class="row" style="direction: rtl;">
                    <div class="col-md-12">
                 <input type="hidden" name="" id="teacher_id" value="{{ $teacher->id }}">
                   <div class="login-wrap">
                    <div class="login-html">
                      {{-- <input id="tab-1" type="radio" name="tab" class="sign-in" ><label for="tab-1" class="tab">ارسال للطالب</label> --}}
                      <input id="tab-2" type="radio" name="tab" class="sign-up" checked><label for="tab-2" class="tab">ارسال للكل</label>

                      <div class="login-form">

                        <!--send student-->
                        <form action="{{ route('dashboard.send_message') }}" method="post">
                            @csrf
                        <!--send student-->
                        <div class="sign-in-htm">
                          <div class="group">
                            <input type="hidden" name="teacher_id" id="" value="{{ $teacher->id }}">
                            <label for="user" class="label">الصف</label>
                            <div class="form-group newselect">
                            <select  id="classes1" class="form-control">
                              <option value="">اختر الصف</option>
                              @foreach ($classes as $item )
                              <option value="{{ $item->id }}" style="text-align: center;">
                                  {{ $item->name }}</option>
                              @endforeach
                            </select>
                            </div>
                          </div>

                          <div class="group">
                            <label for="user" class="label">الشعبة</label>

                            <select  id="rooms1" class="form-control">
                                <option value="">اختر الشعبة</option>
                            </select>
                          </div>
                          <div class="group">
                            <label for="user" class="label">اختر الطالب</label>
                            <select  id="mydiv" class="form-control" name="student_id">
                                <option value="" >اختر الطالب </option>
                            </select>

                          </div>
                          <div class="group">
                            <label for="pass" class="label">الرسالة</label>
                             <textarea class="input"  name="message" id="message"  cols="30" rows="5" style="border-radius: 10px;"></textarea>
                          </div>

                          <div class="group">
                            <input type="submit" class="button" value="حفظ">
                          </div>

                        </div>
                        </form>
                        <!--end send student-->

                       <!--send all student-->
                       <form action="{{route('dashboard.send_group_message') }}" method="post">
                        @csrf
                        <div class="sign-up-htm">
                          <div class="group">
                            <input type="hidden" name="teacher_id" id="" value="{{ $teacher->id }}">
                            <label for="user" class="label">الصف</label>
                            <select  id="classes" class="form-control" required>
                                <option value="">اختر الصف</option>
                                @foreach ($classes as $item )
                                <option value="{{ $item->id }}" style="text-align: center;">
                                    {{ $item->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="group">
                            <label for="user" class="label">الشعبة</label>
                            <select id="rooms" name="room_id" class="form-control" >
                               <option value="">اختر الشعبة</option>
                            </select>
                          </div>
                          <div class="group">
                            <label for="pass" class="label">الرسالة</label>
                             <textarea  class="input"  name="message" id="message" cols="30" rows="5" style="border-radius: 10px;"></textarea>
                          </div>

                          <div class="group">
                            <input style="border-radius: 10px;"  type="submit" class="button" value="ارسال">
                          </div>

                        </div>
                       </form>
                        <!--end send all students-->


                      </div>
                    </div>
                  </div>
                </div>
             </div>
          </div>
        </div>
     </div><!--main-panel-->

@endsection


@section('js')
    <!-- End custom js for this page -->
    <script src="{{asset('teachers_2/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/select2.js')}}"></script>
    <script>
      $(document).ready(function () {
      $(document).on('change', '#classes2', function () {
                var teacher_id = $('#teacher_id').val();
                var class_id = $(this).val();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                    teacher_id;
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
                    error: function (xhr) {
                    }
                });
            })

            $(document).on('change', '#classes', function () {
                var teacher_id = $('#teacher_id').val();
                var class_id = $(this).val();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                    teacher_id;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
                        $('#rooms').empty();
                        $('#rooms').append(
                            `<option value="" style="text-align: center;">اختر الشعبة  </option>`
                            )
                        $.each(data, function (key, value) {
                            $('#rooms').append(
                                `<option style="text-align: center;"  value="${value.id}">${value.name}</option>`
                                )

                        });
                    },
                    error: function (xhr) {

                    }

                });
            })
            $(document).on('change', '#classes1', function () {
                var teacher_id = $('#teacher_id').val();
                var class_id = $(this).val();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms') }}/" + class_id + "/" +
                    teacher_id;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
                        $('#rooms1').empty();
                        $('#rooms1').append(
                            `<option value="">اختر الشعبة </option>`
                            )

                        $.each(data, function (key, value) {
                            $('#rooms1').append(
                                `<option style="text-align: center;" value="${value.id}">${value.name}</option>`
                                )
                        });
                    },
                    error: function (xhr) {
                    }
                });
            });
            $(document).on('change', '#rooms1', function () {
                var teacher_id = $('#teacher_id').val();
                var room_id = $(this).val();
                $('#group_message').attr('href',
                    "{{ URL::to('SMARMANger/dashboard/teacher/write_group_message') }}/" + room_id);
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/room/students/') }}/" + room_id;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
                        $('#mydiv').empty();
                        $.each(data, function (key, value) {
                            $('#mydiv').append(`<option  style="text-align: center;" value="${value.id}">${value.first_name}
                          ${value.last_name}</option>`);
                        });
                    },
                    error: function (xhr) {
                    }
                });
            });

            $(document).on('change', '#rooms', function () {
                var teacher_id = $('#teacher_id').val();
                var room_id = $(this).val();
                var url = "{{ URL::to('SMARMANger/dashboard/teacher/class/rooms/lessons') }}/" + room_id +
                    "/" + teacher_id;
                $.ajax({
                    url: url,
                    type: "get",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
                        $('#lesson').empty();
                        $('#lesson').append(`<option value="">
                        Choose subject </option>`);
                        $.each(data, function (key, value) {
                            $('#lesson').append(`<option style="text-align: center;" value="${value.id}">${value.name_en}
                            </option>`);
                        });
                    },
                    error: function (xhr) {
                    }
                });
            });
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
    <script>
      const switchers = [...document.querySelectorAll('.switcher')]
switchers.forEach(item => {
	item.addEventListener('click', function() {
		switchers.forEach(item => item.parentElement.classList.remove('is-active'))
		this.parentElement.classList.add('is-active')
	})
})
    </script>
    @endsection









