@extends('teachers2.layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <!--link for select-->
    <link rel="stylesheet" href="{{ asset('teachers_2/assets/vendors/select2/select2.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('teachers_2/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <style>
        @media(min-width:1200px) and (max-width:2000px) {
            .lessondate {
                text-align: right;
                left: 18px;
                top: -15px;
            }
        }

        .col-md-4 {
            margin-bottom: 20px;
        }

        .form {
            --width-of-input: 100%;
        }

        @media(min-width:1200px) and (max-width:1900px) {
            .textcol {
                left: 15px;
            }
        }

        @media (min-width: 1011px) and (max-width: 1300px) {
            .newselect {
                position: relative;
                left: 0;
            }
        }


        /*text animation*/
        @import url('https://fonts.googleapis.com/css?family=Abril+Fatface|Lato');
.body {
  background: #D3DEEA;
}
.top {
  margin-top: -70px;
}
.container1 {
  margin: 0 auto;
  position: relative;
  width: 250px;
  height: 250px;
 /* margin-top: -40px;*/
}
.ghost {
  width: 50%;
  height: 53%;
  left: 25%;
  top: 10%;
  position: absolute;
  border-radius: 50% 50% 0 0;
  background: #a5c9ff  ;
  border: 1px solid #BFC0C0;
  border-bottom: none;
  animation: float 2s ease-out infinite;
}
.ghost-copy {
  width: 50%;
  height: 53%;
  left: 25%;
  top: 10%;
  position: absolute;
  border-radius: 50% 50% 0 0;
  background: #a5c9ff  ;
  border: 1px solid #BFC0C0;
  border-bottom: none;
  animation: float 2s ease-out infinite;
  z-index: 0;
}
.face {
  position: absolute;
  width: 100%;
  height: 60%;
  top: 20%;
}
.eye, .eye-right {
  position: absolute;
  background: #585959;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  top: 40%;
}
.eye {
  left: 25%;
}
.eye-right {
  right: 25%;
}
.mouth {
  position: absolute;
  top: 50%;
  left: 45%;
  width: 10px;
  height: 10px;
  border: 3px solid;
  border-radius: 50%;
  border-color: transparent #585959 #585959 transparent;
  transform: rotate(45deg);
}
.one, .two, .three, .four {
  position: absolute;
  background: #a5c9ff ;
  top: 85%;
  width: 25%;
  height: 23%;
  border: 1px solid #BFC0C0;
  z-index: 0;
}
.one {
  border-radius: 0 0 100% 30%;
  left: -1px;
}
.two {
  left: 23%;
  border-radius: 0 0 50% 50%;
}
.three {
  left: 50%;
  border-radius: 0 0 50% 50%;
}
.four {
  left: 74.5%;
  border-radius: 0 0 30% 100%;
}
.shadow {
  position: absolute;
  width: 30%;
  height: 7%;
  background: #a5c9ff ;
  left: 35%;
  top: 80%;
  border-radius: 50%;
  animation: scale 2s infinite;
}
@keyframes scale {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes float {
  50% {
    transform: translateY(15px);
  }
}
.bottom {
  margin-top: 10px;
}
/*text styling*/
h1 {
  font-family: 'Abril Fatface', serif;
  color: #152C4F ;
  text-align: center;
  font-size: 9em;
  margin: 0;
  text-shadow: -1px 0 #BFC0C0, 0 1px #a5c9ff, 1px 0 #a5c9ff, 0 -1px #BFC0C0;
}
h3 {
  font-family: 'Lato', sans-serif;
  font-size: 2em;
  text-transform: uppercase;
  text-align: center;
  color: #152C4F;
  margin-top: -20px;
  font-weight: 900;
}
p {
  text-align: center;
  font-family: 'Lato', sans-serif;
  color: #585959;
  font-size: 0.6em;
  margin-top: -20px;
  text-transform: uppercase;
}


        /*end text animation*/
    </style>
@endsection

@section('content')

    <div class="main-panel">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
          <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
          <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room->id ,'teacher_id'=>$teacher->id])}}">{{ $room->name }}</a></li>
          <li class="li"><a href="{{ route('dashboard.lessons.lectures',['lesson_id' =>$lesson->id ,'teacher_id'=>$teacher->id,'room_id'=>$room_id]) }}" style="cursor: pointer !important">{{ $lesson->name }}</a></li>
       </ul>



        <div class="content-wrapper pb-0">

            <!--lessons-->
            <div class="container" style="padding-bottom: 100px;">

                <div class="row newarticls">
                    {{-- <input hidden value="{{ $lesson_id }}" id="lesson_id">
            <input hidden id="room_id" value="{{ $room_id }}"> --}}
            @if($lectures->isNotEmpty())
                    @foreach ($lectures as $item)
                        <div class="col-md-4 ">
                            <section class="articles">
                                <!--start card-->
                                <article>
                                    <div class="article-wrapper">
                                        <figure>
                                            <img src="{{ asset('teachers_2/icons/sub1.jpg') }}" alt="" />
                                        </figure>
                                        <div class="article-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12 lessondate">
                                                        <span style="font-size: 15px;;">
                                                        <i class="mdi mdi-calendar"style="font-size: 14px;">
                                                            </i>&nbsp;{{ $item->lecture_time }}</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="justify-content: space-between;">
                                                    <h2>{{ $item->name }}</h2>
                                                    <div style="position: relative;top: -5px;">
                                                        <!--delete lesson-->
                                                        <a href="#"
                                                            data-lec_id="{{ $item->id }}"data-toggle="modal"
                                                            data-target="#delete_question" href="">
                                                            <i class="fa fa-trash"
                                                                style="font-size: 22px;color: #14315C ;"></i></a>
                                                        <!--end delete-->
                                                        &nbsp;
                                                        <!--edit lesson-->
                                                        <a href=".editEmployeeModal" class="edit11" data-toggle="modal"
                                                            data-target="#demoModal" data-id="{{ $item->id }}"
                                                            data-name="{{ $item->name }}"
                                                            data-time="{{ $item->lecture_time }}">
                                                            <i class="mdi mdi-pencil"
                                                                style="font-size: 22px;color: #14315C ;"></i></a>
                                                        <!--end edit-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="justify-content: space-around;">
                                                <button class="button">
                                                    <a href="{{ route('dashboard.student.lessons.book_details', [$lesson->id, $teacher->id, $room->id, $item->id]) }}"
                                                        style="color: #fff;"> مشاهدة المحتوى</a>
                                                </button>
                                                <button class="button">
                                                    <a href="{{ route('dashboard.teacher_rooms2', [$class->id, $teacher->id, $room->id, $item->id]) }}"
                                                        style="color: #fff;"> اضافة محتوى </a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <!--end card-->
                            </section>
                        </div>
                    @endforeach
                    @else
                    <div class="main-panel">

                        <div class="top">
                          <h1>404</h1>
                          <h3>لايوجد نتيجة</h3>
                        </div>
                        <div class="container1">
                          <div class="ghost-copy">
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                            <div class="four"></div>
                          </div>
                          <div class="ghost">
                            <div class="face">
                              <div class="eye"></div>
                              <div class="eye-right"></div>
                              <div class="mouth"></div>
                            </div>
                          </div>
                          <div class="shadow"></div>
                        </div>
                        <!--div class="bottom">
                          <p>Boo, looks like a ghost stole this page!</p>
                          <form class="search">
                            <input type="text" class="search-bar" placeholder="Search">
                            <button type="submit" class="search-btn">
                              <i class="fa fa-search"></i>
                            </button>
                          </form>
                          <div class="buttons">
                            <button class="btn">Back</button>
                            <button class="btn">Home</button>
                          </div>
                        </div-->

                    </div>

                @endif





                    <!--edit name lesson-->
                    <div class="modal fade auto-off editEmployeeModal" id="demoModal" tabindex="-1" role="dialog"
                        aria-labelledby="demoModal" aria-hidden="true">
                        <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
                            <div class="modal-content" style="padding-top: 50px !important;">
                                <div class="container-fluid">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        style="background-color: white !important;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 style="color: #05579e;text-align: center; ">تعديل الدرس</h4>

                                    {{-- <form action="" method="post" id="confirm4" style="text-align: right;direction: rtl;">
                      @csrf --}}
                                    <form action="{{ route('dashboard.lessons.lecture.update') }}" method="post"
                                        id="confirm4" style="text-align: right;direction: rtl;">
                                        @csrf
                                        <input type="text" hidden name="id" id="lec_id">
                                        <div class="container" style="padding-top: 20px;">
                                            <div class="row">
                                                <div class="col-md-12" style="display: grid;">
                                                    <label for="default" class="">اسم الدرس</label>
                                                    <input type="text" class="border p-2" name="name" id="name2"
                                                        placeholder="ادخل اسم الدرس " style="width:300px">


                                                </div>
                                                <!--end col-->
                                                <div class="col-md-12" style="display: grid;">
                                                    <label for="default" class="">تاريخ ظهور الدرس</label>
                                                    <!-- This is a normal file input -->
                                                    <input name="lecture_time" id="lecture_time2"
                                                        placeholder="ادخل بداية الوقت " onfocus="this.placeholder = ''"
                                                        onblur="this.placeholder = 'Enter start quize time'"
                                                        class="border p-2" type="date" style="width:300px">
                                                </div>
                                                <!--end col-->

                                            </div>
                                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                            <input type="hidden" name="class_id" value="{{ $class->id }}">
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                                            <div class="row" style="text-align: center;">
                                                <div class="col-md-12" style="padding-bottom: 10px;">
                                                    <button class="button" style="width:150px">حفظ</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end model-->
                    <!--end edit modal-->




                </div>

            </div>
            <!--end lessons-->

            <!-- main-panel ends -->
        </div>
        <!--end container of cards-->
        <!-- page-body-wrapper ends -->
    </div>
    </div>
    <!--end container-scroller-->


    <div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف درس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('dashboard.lec.delete') }}" method="post">
                        @csrf
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="question_id" id="question_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--- end add lesson -->
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    {{-- <script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
<script>
    $(document).ready(function () {
        $('#search_lecture').on('keyup', function(){
            var value = $(this).val();
            $.ajax({
                type: "get",
                url: "/search",
                data: {'search_lecture':value},
                success: function (data) {
                    $('.mycard').html(data);
                }
            });
        });
    });
</script> --}}


    <script>
        $(".edit11").on("click", function(e) {
            var lec_id = $(this).data('id');
            var lec_name = $(this).data('name');
            $('#lec_id').val(lec_id);
            $('#name2').val(lec_name);


        })
        $('#delete_question').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var question_id = button.data('lec_id')
            var modal = $(this)
            modal.find('.modal-body #question_id').val(question_id);
        })



        /*$(document).on('keyup','#search_lecture',function(){
            var search_lecture= $(this).val();
            if(search_lecture != ''){
                $.ajax({
                    url:'/search_lecture',
                    method:'GET',
                    data:{search_lecture},
                    datatype:'json',
                    success:function(data){
                        console.log(data);
                    }
                })
            }
        })*/
    </script>
    {{-- for select lessson --}}
@endsection
