@extends('school_controller.layouts.app')
@section('css')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
        /*css for show homework button*/
        a:hover {
            color: #fff;
            text-decoration: none;
        }


        /*ens css select*/
        .select2-container .select2-selection--single .select2-selection__rendered {
            display: block;
            padding-left: 0px;
            /* padding-right: 20px; */

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            position: relative;
            bottom: 15px;
            text-align: center;
        }

        .select2-results {
            text-align: center;
        }

        /* .form-control, .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field, .typeahead, .tt-query, .tt-hint{
    font-size: 17px;
    font-weight: 600;
    }*/
        .newselect {
            border: 3px solid #995FDE;
            border-radius: 6px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
            line-height: 1;
            white-space: nowrap;
            /* padding-bottom: 35px; */
            padding-top: 5px;
            padding-bottom: 40px;
        }

        /*edit btn*/
        .Btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            width: 50px;
            height: 40px;
            border: none;
            padding: 0px 20px;
            background-color: rgb(168, 38, 255);
            color: white;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 5px 5px 0px rgb(140, 32, 212);
            transition-duration: .3s;
        }

        .svg {
            width: 13px;
            position: absolute;
            right: 0;
            margin-right: 20px;
            fill: white;
            transition-duration: .3s;
        }

        .Btn:hover {
            color: transparent;
        }

        .Btn:hover svg {
            right: 43%;
            margin: 0;
            padding: 0;
            border: none;
            transition-duration: .3s;
        }

        .Btn:active {
            transform: translate(3px, 3px);
            transition-duration: .3s;
            box-shadow: 2px 2px 0px rgb(140, 32, 212);
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e4e9f0;
            position: relative;
            padding-top: 28px;
            font-size: 22px;
            font-weight: 900;
            padding-bottom: -10px;
        }

        /*end edit btn*/
        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
            /* margin: 0 auto; */
            margin: auto;
            font-size: 30px;
            color: #152C4F;
            left: 60px;
            position: relative;
        }

        .table th img,
        .table td img {
            width: 20%;
            height: 20%;
            border-radius: 0;
        }

        @media (min-width:200px) and (max-width:481px) {
            .addexam1 {
                padding-right: 0px !important;
                padding-left: 140px !important;

            }
        }

        @media (min-width:482px) and (max-width:600px) {
            .addexam1 {
                padding-right: 0px !important;
                padding-left: 188px !important;

            }
        }

        @media (min-width:601px) and (max-width:700px) {
            .addexam1 {
                padding-right: 0px !important;
                padding-left: 200px !important;

            }
        }

        @media (min-width:701px) and (max-width:800px) {
            .addexam1 {
                padding-right: 0px !important;
                padding-left: 200px !important;

            }
        }

        /*responsive table*/
        /**/

        table {
            border: 1px solid #ccc;
            border-collapse: collapse !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            margin-top: 10px !important;
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

        @media(min-width:200px) and (max-width:600px) {}

        .showstate {
            width: 129px;
            padding: 0px !important;
        }

        /*end responsiave table*/
        .nav-tabs>.nav-item>.nav-link {
            color: #888888 !important;
            margin: 0 !important;
            margin-right: 5px !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
            border-radius: 30px !important;
            font-size: 18px !important;
            font-weight: 800 !important;
            padding: 11px 7px !important;
            line-height: 1.5 !important;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background-color: #152c4fc7 !important;
            border-radius: 30px !important;
            color: #FFFFFF !important;
        }

        .card .card-header {
            background-color: transparent !important;
            border-bottom: 0 !important;
            background: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
        }

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

        .form {
            display: inherit;
            flex-direction: inherit;
            width: 100%;
            height: auto;
            background-color: #FFF;
            margin: 0;
            box-shadow: none;
            padding: 0;
            box-sizing: border-box;
            border: none;
            border-radius: 0.5em;
            font-family: sans-serif;
            font-size: 16px;
            font-weight: 400;
            /* max-width: 320px; */
        }

        .e_icon {
            width: 100% !important
        }

        form div span {
            background-color: transparent
        }
    </style>
@endsection
@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
          <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.coordinator') }}"> الصفحة الرئيسية</a></li>

      <li class="li"><a href="#">اضافة فقرة</a></li>

   </ul>
        <div class="content-wrapper pb-0">
            @if (session()->has('Add'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: "تمت اضافة  بنجاح ",
                            type: "success"
                        })
                    }
                </script>
            @endif

            @if (session()->has('update'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: "  تم التعديل بنجاح ",
                            type: "success"
                        })
                    }
                </script>
            @endif
            @if (session()->has('error'))
                <script>
                    window.onload = function() {
                        notif({
                            msg: "يجب تحديد النوع ",
                            type: "error"
                        })
                    }
                </script>
            @endif
            <!--start content-->
            <div class="container" style="direction: rtl;">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <!--select students-->
                                <div class="container addexam1" style="position: relative;top: -8px;padding-right: 200px;">

                                    <div class="row" style="padding-top: 30px;padding-bottom: 50px;">
                                        <div class="col-md-5" style="right: 45px;">
                                            {{-- <a href="#" class="home"  data-toggle="modal" data-target="#demoModal1">
                        <span>اضافة فقرة</span>
                        </a> --}}
                                            <a class="home" href="#" data-toggle="modal" data-target="#demoModal1"
                                                style="color:#fff">اضافة فقرة</a>
                                        </div>
                                    </div>

                                </div>

                                <!--start modal-->
                                <div class="modal fade auto-off" id="demoModal1" tabindex="-1" role="dialog"
                                    aria-labelledby="demoModal" aria-hidden="true">
                                    <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
                                        <div class="modal-content" style="padding-top: 50px !important;">

                                            <div class="container-fluid">
                                                <form action="{{ route('dashboard.store') }}" method="post"
                                                    autocomplete="off" enctype="multipart/form-data">

                                                    @csrf
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <div class="row" style="direction: rtl;">
                                                        <div class="col-md-12">
                                                            <h4 style="color: #05579e;text-align: center; ">اضافة فقرة </h4>
                                                            <div class="video-wrapper">


                                                                <input type="hidden" name="coordinator_id" id="coordinator_id"
                                                                    value="{{ auth()->user()->coordinator_id }}">
                                                                {{-- <span style="float:right"> {{ $Lecture->name }} </span> --}}
                                                                <input hidden value="{{ $Lecture->id }}" name="lecture_id">
                                                                <input hidden type="text" name="lesson_id"
                                                                    value="{{ $lesson_id }}">
                                                                <input hidden type="text" name="room_id"
                                                                    value="{{ $room_id }}">
                                                                <input hidden type="text" name="class_id"
                                                                    value="{{ $class->id }}">
                                                                <label style="color: #094e89; float: right;">عنوان المحتوى
                                                                </label>
                                                                <input style="text-align: right;" type="text"
                                                                    class="form-control" name="title" required
                                                                    id="name" placeholder="ادخل عنوان المحتوى ">
                                                                <br>
                                                                <br>
                                                                <select id="myselection" name="type" aria-invalid="false"
                                                                    style="margin: 0 auto;margin-bottom: 30px;"
                                                                    class="form-control form-control-lg">
                                                                    <option value="" selected>اختر نوع الفقرة</option>

                                                                    <option value="0">نص </option>
                                                                    <option value="3">صورة</option>
                                                                    <option value="2">صوت </option>
                                                                </select>
                                                                <div id="show0" class="myDiv" style="display: none;">
                                                                    <textarea name="content" class="form-control" style="direction:ltr" cols="30" rows="10"></textarea>

                                                                </div>

                                                                <div id="show3" class="myDiv" style="display: none;">
                                                                    <label for="file-input" class="drop-container">
                                                                        <span class="drop-title">
                                                                            <br>
                                                                            <br>
                                                                        </span>
                                                                        <input type="file" accept="image/*"
                                                                            name="content2" id="file-input">
                                                                    </label>

                                                                </div>
                                                                <div id="show2" class="myDiv"
                                                                    style="display: none;">
                                                                    <label for="file-input" class="drop-container">
                                                                        <span class="drop-title">
                                                                            <br>
                                                                            <br>
                                                                        </span>
                                                                        <input type="file" name="content"
                                                                            id="file-input">
                                                                    </label>

                                                                </div>

                                                            </div>
                                                        
                                                        </div>
                                                    </div><!--end row-->
                                                    <div class="row" style="text-align: center;">
                                                        <div class="col-md-12" style="padding-top: 16px;">
                                                            <button class="newbtn2 home" type="submit">حفظ </button>

                                                        </div>
                                                    </div>
                                                    <br>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal-->

                                <!--end modal-->
                                <script>
                                    $(document).ready(function() {
                                        $('#myselection').on('change', function() {
                                            var demovalue = $(this).val();
                                            $("div.myDiv").hide();
                                            $("#show" + demovalue).show();
                                        });
                                    });
                                </script>
                                <!-- tablist for sectios-->
                                <div class="card-header">
                                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#text_in" role="tab">
                                                اضافة نص
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#image" role="tab">
                                                اضافة صورة
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#audio" role="tab">
                                                اضافة صوت
                                            </a>
                                        </li>
                                    </ul>
                                </div><!--end card header-->
                                <div class="card-body">
                                    <!-- Tab panes -->
                                    <div class="tab-content text-center">
                                        <div class="tab-pane active" id="text_in" role="tabpanel">
                                            <div class="container animated bounceInLeft">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>اسم المحتوى</th>
                                                                <th>المحتوى</th>
                                                                <th>عمليات التعديل</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i2 = 0;
                                                            @endphp

                                                            @foreach ($sections as $section)
                                                                @if ($section->type == '0')
                                                                    @php
                                                                        $i2++;
                                                                    @endphp
                                                                    <tr>
                                                                        <td> {{ $section->title }} </td>


                                                                        <td style="direction: ltr;">
                                                                            <textarea name="content" class="form-control" cols="3" rows="5">
                                    {{ $section->content }}</textarea>
                                                                        </td>
                                                                        <td>
                                                                            <a class="section_edit" href="#"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#demoModal2"
                                                                                data-section_id="{{ $section->id }}"
                                                                                data-content="{{ $section->content }}"
                                                                                data-type="{{ $section->type }}"
                                                                                data-section_title="{{ $section->title }}">
                                                                                <img class="e_icon"
                                                                                    src="{{ asset('teachers_2/icons/icons8-edit-50 (2).png') }}"
                                                                                    alt=""></a>

                                                                            {{-- <a href="#" type="button"
                                        data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                                        data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                                       class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a> --}}
                                                                            <!-- start modal -->

                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div><!--end tabcontetn-->
                                        <div class="tab-pane" id="image" role="tabpanel">
                                            <div class="container animated bounceInLeft">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>اسم المحتوى</th>
                                                                <th>المحتوى</th>
                                                                <th>عمليات التعديل</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i1 = 0;
                                                            @endphp

                                                            @foreach ($sections as $section)
                                                                @if ($section->type == '3')
                                                                    @php
                                                                        $i1++;
                                                                    @endphp
                                                                    <tr>
                                                                        <td> {{ $section->title }} </td>
                                                                        <td>
                                                                            <img src="{{ asset('storage/' . $section->content) }}"
                                                                                style="height: 60px;width:70px">
                                                                        </td>

                                                                        <td>
                                                                            <a class="section_edit" href="#"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#demoModal2"
                                                                                data-section_id="{{ $section->id }}"
                                                                                data-content="{{ $section->content }}"
                                                                                data-type="{{ $section->type }}"
                                                                                data-section_title="{{ $section->title }}">
                                                                                <img class="e_icon"
                                                                                    src="{{ asset('teachers_2/icons/icons8-edit-50 (2).png') }}"
                                                                                    alt=""></a>

                                                                            {{-- <a href="#" type="button"
                                           data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                                            data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                                           class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a> --}}

                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach

                                                        </tbody>
                                                    </table>


                                                </div>

                                            </div>

                                        </div><!--end tab content-->
                                        <div class="tab-pane" id="audio" role="tabpanel">
                                            <div class="container animated bounceInLeft">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>اسم المحتوى</th>
                                                                <th>المحتوى</th>
                                                                <th>عمليات التعديل</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 0;
                                                            @endphp

                                                            @foreach ($sections as $section)
                                                                @if ($section->type == '2')
                                                                    @php
                                                                        $i++;
                                                                    @endphp

                                                                    <tr>
                                                                        <td> {{ $section->title }} </td>
                                                                        <td>
                                                                            <audio
                                                                                src="{{ asset('storage/' . $section->content) }}"
                                                                                controls="">
                                                                            </audio>
                                                                        </td>
                                                                        <td>
                                                                            <a class="section_edit" href="#"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#demoModal2"
                                                                                data-section_id="{{ $section->id }}"
                                                                                data-content="{{ $section->content }}"
                                                                                data-type="{{ $section->type }}"
                                                                                data-section_title="{{ $section->title }}">
                                                                                <img class="e_icon"
                                                                                    src="{{ asset('teachers_2/icons/icons8-edit-50 (2).png') }}"
                                                                                    alt=""></a>

                                                                            {{-- <a href="#" type="button"
                                        data-section_id="{{$section->id}}" data-content="{{$section->content}}"
                                        data-type="{{$section->type}}" data-section_title="{{$section->title}}"
                                       class="btn section_edit" style="background-color: white; color: rgb(117, 115, 115);" data-toggle="modal" data-target="#staticBackdrop1">تعديل</a> --}}


                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div><!--end tab content-->

                                    </div>
                                </div><!--end card body-->
                                <!--end tablist for section-->


                                <!--end select students-->


                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!--end content-->
        </div><!--end content-wrapper pb-0-->
    </div><!--end main panels-->




    {{-- update modal --}}
    <!--start modal-->
    <div class="modal fade auto-off" id="demoModal2" tabindex="-1" role="dialog" aria-labelledby="demoModal"
        aria-hidden="true">
        <div class="modal-dialog animated zoomInDown modal-dialog-centered" role="document">
            <div class="modal-content" style="padding-top: 50px !important;">
                <div class="container-fluid">
                    <form action="{{ route('dashboard.update') }}" method="post" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section_id" id="id">
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="type" id="type_edit">
                        <input type="hidden" name="coordinator_id" value="{{ auth()->user()->coordinator_id }}">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row" style="direction: rtl;">

                            <div class="col-md-12">
                                <h4 style="color: #05579e;text-align: center; "> تعديل المحتوى </h4>
                                <div class="video-wrapper">

                                    <label style="color: #094e89; float: right;"> عنوان المحتوى </label>
                                    <input style="text-align: right;" type="text" class="form-control" name="title"
                                        id="title_edit" required placeholder="ادخل عنوان المحتوى ">
                                    <br>
                                    <br>

                                    <select id="text"style="text-align: center;" class="form-control">

                                    </select>
                                    <br>
                                    <br>
                                    <div class="row" style="text-align: center;">
                                        <div class="col-md-12">
                                            <div id="content_edit">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- <form>
                   <button type="submit" class="btn " data-dismiss="modal" aria-label="Close">
                     </button>
               </form> --}}
                            </div>
                        </div><!--end row-->
                        <div class="row" style="text-align: center;">
                            <div class="col-md-12">
                                <button class="home newbtn2" type="submit">حفظ </button>

                            </div>
                        </div>
                        <br>


                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end update modal --}}
@endsection
@section('js')
    <script>
        $(document).on('click', '.section_edit', function() {
            var id = $(this).data('section_id');
            var title = $(this).data('section_title');
            var type = $(this).data('type');
            var content = $(this).data('content');
            $('#id').val(id);
            $('#title_edit').val(title);
            $('#type_edit').val(type);
            $('#text').empty();
            $('#content_edit').empty();

            if (type == '0') {
                $('#text').append(`

                        <option value="hide" class="form-control form-control-lg">----------- نص -----------</option>


        `);
                $('#content_edit').append(`
        <textarea name="content" class="form-control" style="direction:ltr"
                                                        cols="30" rows="10">
                                                        ${content}</textarea>




        `);
            } else if (type == '3') {
                $('#text').append(`
        <option value="hide">-------------- صورة --------------</option>


        `);
$('#content_edit').append(` <img src="{{ asset('storage/${content}') }}"  width="50px" height="50px">
<form class="form">
<label for="file-input" class="drop-container">
<span class="drop-title">
  <br>
  <br>
</span>
<input type="file"  name="content"   id="file-input">
</label>
</form>





        `);

            } else {
                $('#text').append(`
        <option value="hide">-------------- صوت --------------</option>


        `);
                $('#content_edit').append(`
        <audio src="{{ asset('storage/${content}') }}" controls></audio>
        <form class="form">

<label for="file-input" class="drop-container">
<span class="drop-title">
  <br>
  <br>
</span>
<input type="file" name="content"   id="file-input">
</label>
</form>
        `);
           }
        })
        $(document).ready(function() {
            $('#myselection').on('change', function() {
                var demovalue = $(this).val();
                $("div.myDiv").hide();
                $("#show" + demovalue).show();
            });
        });
    </script>
@endsection
