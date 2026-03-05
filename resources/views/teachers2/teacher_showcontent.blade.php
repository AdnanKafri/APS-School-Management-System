@extends('teachers2.layouts.app')
@section('css')
    <style>



    @media(min-width:200px) and (max-width:400px){
        audio{
            position: relative;
            left: 30px;
        }
    }
        .form {
            width: auto;
        }

        @media(min-width:200px) and (max-width:500px) {
            .drop-container {
                width: 150px;
            }
        }

        form div span {
            background-color: transparent !important
        }

        /* CSS */
        .button-3 {
            appearance: none;
            background-color: #152C4F;
            border: 1px solid rgba(27, 31, 35, .15);
            border-radius: 6px;
            box-shadow: rgba(27, 31, 35, .1) 0 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            padding: 6px 16px;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
        }

        .button-3:focus:not(:focus-visible):not(.focus-visible) {
            box-shadow: none;
            outline: none;
        }

        .button-3:hover {
            background-color: #152C4F;
        }

        .button-3:focus {
            box-shadow: rgba(46, 77, 164, 0.4) 0 0 0 3px;
            outline: none;
        }

        .button-3:disabled {
            background-color: #94d3a2;
            border-color: rgba(27, 31, 35, .1);
            color: rgba(255, 255, 255, .8);
            cursor: default;
        }

        .button-3:active {
            background-color: #152C4F;
            box-shadow: rgba(20, 70, 32, .2) 0 1px 0 inset;
        }

        .cssbuttons-io-button {
            background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%) !important;
            color: white;
            font-family: inherit;
            padding: 0.35em;
            /*padding-left: 1.2em;*/
            font-size: 17px;
            font-weight: 500;
            border-radius: 0.9em;
            border: none;

            display: flex;
            align-items: center;
            box-shadow: inset 0 0 1.6em -0.6em #4382E0;
            overflow: hidden;
            position: relative;
            height: 2.8em;
            padding-right: 3.3em;
        }

        .cssbuttons-io-button .icon {
            background: white;
            margin-left: 1em;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 2.2em;
            width: 2.2em;
            border-radius: 0.7em;
            box-shadow: 0.1em 0.1em 0.6em 0.2em #4382E0;
            right: 0.3em;
            transition: all 0.3s;
        }

        .cssbuttons-io-button:hover .icon {
            width: calc(100% - 0.6em);
        }

        .cssbuttons-io-button .icon svg {
            width: 1.1em;
            transition: transform 0.3s;
            color: #153e7c;
        }

        .cssbuttons-io-button:hover .icon svg {
            transform: translateX(0.1em);
        }

        .cssbuttons-io-button:active .icon {
            transform: scale(0.95);
        }
        .card12{
            height: 100% !important;
        }
        .circle {
    margin-bottom: 20px;
    width: 43%;
    height: 50px;
    filter: none;
    animation: pulse_3011 4s infinite;
    z-index: -1;
}
a:hover {
     color: #fff;
    text-decoration: underline;
}
.ti_time{
    text-align: center;
    color: #152c4f;
    padding-top: 20px;
}
    </style>
@endsection


@section('content')



    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
            padding-top: 11px;">

            <li class="li"><a href="{{ route('dashboard.teacher') }}">المواد</a></li>

            <li class="li"><a
                    href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">{{ $room->name }}</a>
            </li>
            <li class="li"><a
                    href="{{ route('dashboard.lessons.lectures', ['lesson_id' => $lecture->lesson->id, 'teacher_id' => $teacher->id, 'room_id' => $room->id]) }}">{{ $lecture->lesson->name }}
                </a></li>
            <li class="li"><a href="#">{{ $lecture->name }}</a></li>

        </ul>
        <div class="content-wrapper pb-0">
            <!--start content-->
            <div class="container">
                <div class="row">
                    <div class="col-md-6">


                        <div class="tab" role="tabpanel" style="direction: rtl;">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#Section1" aria-controls="files"
                                        role="tab" data-toggle="tab">الملفات</a></li>
                                <li role="presentation"><a href="#Section2" aria-controls="exams" role="tab"
                                        data-toggle="tab">الاختبارات</a></li>
                                <li role="presentation"><a href="#Section3" aria-controls="audio" role="tab"
                                        data-toggle="tab">مقاطع الصوت</a></li>
                                <li role="presentation"><a href="#Section4" aria-controls="video" role="tab"
                                        data-toggle="tab">مقاطع الفيديو</a></li>
                                <li role="presentation"><a href="#Section5" aria-controls="homework" role="tab"
                                        data-toggle="tab">الوظائف</a></li>
                                   
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane active" id="Section1">
                                    <h3 style="text-align: center;padding-bottom: 20px;">الملفات </h3>
                                    <div class="container">
                                        <div class="row" style="justify-content: center;">
                                            @foreach ($additions as $item4)
                                                @if ($item4->addition_link != null && $item4->addition == null)
                                                    <div class="col-md-4 newrow">
                                                        <div class="card12">
                                                            <h6 style="text-align:center;color: #094e89; "> &nbsp;&nbsp;
                                                                {{ $item4->name_addition }} &nbsp;&nbsp;
                                                            </h6>

                                                            <a href="{{ $item4->addition_link }}" target="_blank" style="margin-top: -4px"> <img
                                                                    src="{{ asset('teachers/link.png') }}"
                                                                    style="height: 206px;width:206px;"> </a>

                                                            <div class="row "
                                                                style="justify-content: right; margin-top:31px;">
                                                                <a href="#" class="three"
                                                                    data-id="{{ $item4->id }}" data-toggle="modal"
                                                                    data-target="#modal-fullscreen-xs-down3"> <img
                                                                        src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                        style="height: 30px;width:30px"
                                                                        title=" حذف  الوظيفة "> </a>

                                                                <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($item4->addition != null)
                                                    <div class="col-md-4 newrow">
                                                        <div class="card12">
                                                            <h6 style="text-align:center;color: #094e89;">
                                                                {{ $item4->name_addition }}</h6>

                                                            <!-- link for exam-->
                                                            @if ($item4->extension == 'docx')
                                                                <img src="{{ asset('teachers/photo/word.png') }}">
                                                            @elseif ($item4->extension == 'pdf')
                                                                <img src="{{ asset('teachers/photo/pdf1.png') }}">
                                                            @elseif ($item4->extension == 'pptx')
                                                                <img src="{{ asset('teachers/photo/powerpoint.png') }}">
                                                            @else
                                                                <img src="{{ asset('storage/' . $item4->addition) }}" style="height: 207px;">
                                                            @endif
                                                            <br>
                                                            <div class="row ">
                                                                @if ($item4->addition_link != null)
                                                                    <div
                                                                        style="justify-content: right; float: right;text-align: right;">

                                                                        <a href="{{ $item4->addition_link }}" target="_blank"> <img
                                                                                src="{{ asset('teachers/link.png') }}"
                                                                                style="height: 40px;width:40px"
                                                                                title="رابط الوظيفة "> </a>

                                                                    </div>
                                                                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    &nbsp;
                                                                @endif

                                                                <a href=""
                                                                    style="justify-content: left; float: left;"
                                                                    class="three" data-id="{{ $item4->id }}"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-fullscreen-xs-down3"> <img
                                                                        title="حذف الملف " data-id="{{ $item4->id }}"
                                                                        src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                        style="height: 30px;width:30px" title=" حذف الملف ">
                                                                </a>

                                                                <a href="{{ asset('storage/' . $item4->addition) }}"
                                                                    target="_blank"
                                                                    style="justify-content: left; float: left; text-align: left;">
                                                                    <img title=" تنزيل الملف "
                                                                        src=" {{ asset('teachers/icons/icons8-download.gif') }}"
                                                                        style="height: 30px;width:30px"> </a>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- link for file-->
                                                @endif
                                            @endforeach



                                        </div>


                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Section2">
                                    <h3 style="text-align: center;padding-bottom: 20px;">الاختبارات</h3>
                                    <div class="container">
                                        <div class="row">

                                            @foreach ( $quizes1 as $item)
                                            @if ($item->type=='8' && $item->name_quize1!=null )

                                            <div class="col-md-4 newrow">
                                                <div class="card12">
                                                    <span style="color: #444bba;text-align: center;">{{ $item->name_quize1 }}</span>
                                                    <div class="Group" style="padding-top: 18px;" >
                                                        <a href="{{route('dashboard.quest_exam', $item->id ) }}">
                                                            <img src="{{  asset('teachers/photo/quiz44.jpg')}}" alt="" style="width:200px">
                                                        </a>

                                                    </div>
                                                @if ($now < $item->start_time && $now < $item->end_time)
                                                        <h6 class="ti_time"> {{ $item->start_time }}</h6>

                                                        <div class="row " style="justify-content: center;z-index:9">
                                                            {{-- <a href="#" class="btn btn-primary circle"> بالانتظار </a> --}}
                                                            <a href="#" class="live circle" style="text-decoration: none;">
                                                                 بالانتظار
                                                               &nbsp;
                                                              </a>
                                                        </div>

                                                        @elseif($now > $item->start_time && $now < $item->end_time)
                                                            <h6 class="ti_time"> {{ $item->end_time }}</h6>

                                                            <div class="row " style="justify-content: center;z-index:9">
                                                                <a href="#" class="live circle" style="text-decoration: none;">
                                                                    جاري
                                                                  &nbsp;
                                                                 </a>
                                                            </div>
                                                            @elseif($now > $item->start_time && $now > $item->end_time)
                                                            <h6 class="ti_time"> {{ $item->end_time }}</h6>

                                                            <div class="row " style="justify-content: center;z-index:9">
                                                                <a href="#" class="btn btn-primary"> انتهى </a> &nbsp;&nbsp;
                                                            </div>
                                                            @endif
                                                            <div class="Group">
                                                                @if ($now < $item->start_time && $now < $item->end_time)
                                                                <a href="#"><img src="{{asset('teachers_2/icons/trash.png')}}" title="حذف الامتحان" style="width:40px"></a>
                                                                @endif
                                                                <a href="{{ route('dashboard.exams_addquestion',[$item->id,$lecture->id,$room_id]) }}"><img src="{{asset('teachers_2/icons/plus.png')}}" title="اضافة سؤال" style="width: 40px;"></a>

                                                                <a href="{{route('dashboard.teacher.exams',[$class_id,$lecture->id,$room_id]) }}"><img src="{{asset('teachers_2/icons/edit.png')}}" title="تعديل الاختبار" style="width:37px;position: relative;"></a>
                                                            </div>


                                            </div>
                                            </div>

                                            @elseif( $item->type=='7')
                                            @if ($item->quize1)
                                            <div class="col-md-4 newrow">
                                                <div class="card12">
                                                <span style="color: #444bba;text-align: center;">{{ $item->name_quize1 }}</span>
                                                <div class="Group" style="padding-top: 18px;" >
                                                    <a href="#">
                                                        <img src="{{  asset('teachers/photo/quiz44.jpg')}}" alt="" style="width:200px">
                                                    </a>

                                                </div>

                                                @if ($now < $item->start_time && $now < $item->end_time)
                                                        <h6 class="ti_time"> {{ $item->start_time }}</h6>

                                                        <div class="row " style="justify-content: center;">
                                                            <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                                        </div>

                                                        @elseif($now > $item->start_time && $now < $item->end_time)
                                                            <h6 class="ti_time"> {{ $item->end_time }}</h6>


                                                            <div class="row " style="justify-content: center;">
                                                                <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                                            </div>
                                                            @elseif($now > $item->start_time && $now > $item->end_time)
                                                            <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                                            <div class="row " style="justify-content: center;">
                                                                <a href="#" class="btn btn-primary"> انتهى </a> &nbsp;&nbsp;
                                                            </div>
                                                            @endif
                                                            <div class="Group">
                                                                <a href="{{asset("storage/")}}/{{$item->quize}}"><img src="{{  asset('teachers/icons/icons8-download.gif')}}" title="تنزيل الملف" style="width: 40px;"></a>
                                                                <a href="{{ route('dashboard.edit_quize',$item->id) }}"><img src="{{asset('teachers_2/icons/edit.png')}}" title="تعديل الاختبار" style="width:37px;position: relative;"></a>
                                                            </div>


                                            </div>
                                            @else
                                            {{-- start card --}}
                                            <div class="col-md-4 newrow">
                                                <div class="card12">
                                                <span style="color: #444bba;text-align: center;">{{ $item->name_quize1 }}</span>
                                                <div class="Group" style="padding-top: 18px;" >
                                                    <a href="{{ $item->quiz_link1 }}">
                                                    <img src="{{asset('teachers/link.png') }}" alt="" style="width:200px">
                                                    </a>
                                                </div>

                                                <div class="Group">
                                                    @if ($now < $item->start_time && $now < $item->end_time)
                                                    <h6 class="ti_time"> {{ $item->start_time }}</h6>
                                                    <div class="row" style="justify-content: center;">
                                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                                    </div>
                                                    @elseif($now > $item->start_time && $now < $item->end_time)
                                                        <h6 class="ti_time"> {{ $item->end_time }}</h6>
                                                        <div class="row " style="justify-content: center;">
                                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                                        </div>
                                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                                        <h6 class="ti_time"> {{ $item->end_time }}</h6>

                                                        <div class="row " style="justify-content: center;">
                                                            <a href="#" class="btn btn-primary"> انتهى </a> &nbsp;&nbsp;
                                                        </div>
                                                        @endif
                                                </div><!--end Group-->
                                                <div class="Group">
                                                    @if ($now < $item->start_time && $now < $item->end_time)
                                                    <a href="#" style="text-align: center;"> <img title="حذف الملف"
                                                            src="{{  asset('teachers/icons/icons8-waste.gif')}}"
                                                            style="height: 30px;width:30px"> </a> &nbsp;
                                                            @endif
                                                    <a href="{{ route('dashboard.edit_quize',$item->id) }}" style="text-align: center;"><img
                                                            src="{{  asset('teachers/icons/icons8-edit-file-30.png')}}"
                                                            style="text-align: center;" title="تعديل  الملف"> </a>&nbsp;
                                                </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endforeach


                                    </div>
                                </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Section3">
                                    <h3 style="text-align: center;padding-bottom: 20px;">مقاطع الصوت</h3>
                                    <div class="container">
                                        <div class="row" style="justify-content: center;">

                                            @foreach ($voices as $item)
                                                @if ($item->audio_link != null && $item->audio_file == null)
                                                    <div class="col-md-4 newrow">
                                                        <div class="card12">
                                                            <h6 style="text-align:center;color: #094e89; ">
                                                                {{ $item->name_audio }}
                                                                </h6>
                                                            <br>
                                                            <div class="Group">
                                                            <a href="{{ $item->audio_link }}" target="_blank"> <img
                                                                    src="{{ asset('teachers/link.png') }}"
                                                                    style="height: 100px;width:100px"> </a>
                                                            </div>
                                                            <div class="Group">
                                                                <a href="#" class="three"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-target="#modal-fullscreen-xs-down3"> <img
                                                                        src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                        style="height: 30px;width:30px"
                                                                        title=" حذف  الامتحان "> </a>
                                                                <a href="{{ route('dashboard.edit_audio', $item->id) }}"
                                                                    style="text-align: center;">
                                                                    <img src="{{ asset('teachers/photo/audio22.jpg') }}"
                                                                        style="text-align: center; height: 35px;width: 35px; "
                                                                        title="تعديل  مقطع الصوت "> </a>
                                                            </div>
                                                                <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                                                            </div>
                                                        </div>

                                                @elseif($item->audio_file)
                                                <div class="col-md-4 newrow">
                                                    <div class="card12">
                                                        <h6 style="text-align:center;color: #094e89;">
                                                            {{ $item->name_audio }} </h6>
                                                        <div class="Group">
                                                        <audio
                                                            style="width: 210px; margin: 0 auto;justify-content: center;"
                                                            src="{{ asset('storage/') }}/{{ $item->audio_file }}"
                                                            controls="">
                                                        </audio>
                                                        </div>
                                                        <br>
                                                        <div class="Group" >
                                                            @if ($item->audio_link != null)

                                                                    <a href="{{ $item->audio_link }}" target="_blank"> <img
                                                                            src="{{ asset('teachers/link.png') }}"
                                                                            style="height: 40px;width:40px"
                                                                            title="رابط مقطع الصوت "> </a>

                                                            @endif

                                                            <a href="#" class="three"  data-id="{{ $item->id }}" data-toggle="modal"
                                                                data-target="#modal-fullscreen-xs-down3"
                                                                style="text-align: center;"> <img
                                                                    src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                    style="height: 30px;width:30px"
                                                                    title=" حذف مقطع الصوت "> </a>
                                                            <a href="{{ route('dashboard.edit_audio', $item->id) }}"
                                                                style="text-align: center;">
                                                                <img src="{{ asset('teachers/photo/audio22.jpg') }}"
                                                                    style="text-align: center; height: 35px;width: 35px; "
                                                                    title="تعديل  مقطع الصوت "> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        </div>
                                        <!-- end cards-->
                                    </div>

                                <div role="tabpanel" class="tab-pane fade" id="Section4">
                                    <h3 style="text-align: center;padding-bottom: 20px;">مقاطع الفيديو</h3>
                                    <div class="container">
                                        <div class="row" style="justify-content: center;">
                                            @foreach ($videos as $item)
                                                @if ($item->video_link != null && $item->video == null)
                                                <div class="col-md-4 newrow">
                                                    <div class="card12">
                                                        <h6 style="text-align:center;color: #094e89; ">
                                                            {{ $item->name_video }}</h6>
                                                        <div class="Group"style="padding-top: 50px;" >
                                                       <!-- <a href="{{ $item->video_link }}" target="_blank"> <img
                                                                src="{{ asset('teachers/link.png') }}"
                                                                style="height: 150px;width:150px"> </a>-->

                                                                  <?php
                                                            // Replace the 'watch?v=' part of the video link with 'embed/'
                                                           $embed_link = str_replace('watch?v=', 'embed/', $item->video_link);
                                                                 ?>
                                                            <iframe width="215" height="168" src="<?php echo $embed_link; ?>"
                                                            frameborder="0" allowfullscreen style="border-radius: 10px;"></iframe>

                                                        </div>

                                                        <div class="Group"style="padding-top: 24px">
                                                            <a href="" style="text-align: center;" class="three"
                                                                data-id="{{ $item->id }}" data-toggle="modal"
                                                                data-target="#modal-fullscreen-xs-down3"> <img
                                                                    title="حذف الفيديو " data-id="{{ $item->id }}"
                                                                    src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                    style="height: 30px;width:30px" title=" حذف الملف ">
                                                            </a>

                                                            <a href="{{ route('dashboard.edit_video', $item->id) }}"
                                                                style="text-align: center;">
                                                                <img src="{{ asset('teachers/photo/video22.jpg') }}"
                                                                    style="text-align: center; width: 35px;height: 35px;"
                                                                    title="تعديل  الفيديو ">
                                                            </a>


                                                            <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                                                        </div>
                                                    </div>
                                        </div>
                                                @elseif($item->video)
                                                <div class="col-md-4 newrow">
                                                    <div class="card12">
                                                        <h6 style="text-align:center;color: #094e89;">
                                                            {{ $item->name_video }} </h6>
                                                        <div class="Group"style="padding-top: 50px;" >
                                                        <video controls style="border-radius: 10px;width:215px; height:168px">
                                                            <source src="{{ asset('storage/' . $item->video) }}"
                                                                type="video/mp4">
                                                        </video>
                                                        </div>
                                                        <!-- start edit -->
                                                        <div class="Group" style="padding-top: 24px">
                                                            @if ($item->video_link != null)
                                                                <div
                                                                    style="justify-content: right; float: right;text-align: right;">
                                                                    <a href="{{ $item->video_link }}" target="_blank"> <img
                                                                            src="{{ asset('teachers/link.png') }}"
                                                                            style="height: 40px;width:40px"
                                                                            title="رابط الوظيفة "> </a>
                                                                </div>
                                                            @endif

                                                            <a href="" style="text-align: center;" class="three"
                                                                data-id="{{ $item->id }}" data-toggle="modal"
                                                                data-target="#modal-fullscreen-xs-down3"> <img
                                                                    title="حذف الفيديو " data-id="{{ $item->id }}"
                                                                    src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                    style="height: 30px;width:30px" title=" حذف الملف ">
                                                            </a>
                                                            &nbsp;
                                                            <a href="{{ route('dashboard.edit_video', $item->id) }}"
                                                                style="text-align: center;">
                                                                <img src="{{ asset('teachers/photo/video22.jpg') }}"
                                                                    style="text-align: center; width: 35px;height: 35px;"
                                                                    title="تعديل  الفيديو ">
                                                            </a>
                                                        </div>
                                                        <!-- end edit -->


                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                            <!-- link for video -->
                                            <!-- end link for video-->
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Section5">
                                    <h3 style="text-align: center;padding-bottom: 20px;">الوظائف</h3>
                                    <div class="container">
                                        <div class="row" style="padding-bottom: 20px;">


                                        </div>
                                        <div class="row" style="justify-content: center;">
                                            @foreach ($tests as $item)
                                                @if ($item->test_link != null && $item->test == null)
                                                    <div class="col-md-4 newrow">
                                                        <div class="card12">
                                                            <span style="color: #444bba;text-align: center;">
                                                                {{ $item->namehomework }}</span>
                                                            <div class="Group" style="padding-top: 35px">
                                                                <a href="{{ $item->test_link }}" target="_blank"> <img
                                                                        src="{{ asset('teachers/link.png') }}"
                                                                        style="height: 206px;width:206px"> </a>

                                                            </div>
                                                            <div class="Group" style="padding-top: 20px;">
                                                                 <a href=""
                                                                    style="justify-content: left; float: left;"
                                                                    class="three" data-id="{{ $item->id }}"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-fullscreen-xs-down3"> <img
                                                                        title="حذف الملف " data-id="{{ $item->id }}"
                                                                        src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                        style="height: 30px;width:30px" title=" حذف الملف ">
                                                                </a>

                                                                        <a href="{{ route('dashboard.StudentsRoomLesson',[$room_id ,$teacher->id,$lesson->id,$item->id]) }}"
                                                                            class="" title="علامات">

                                                                            <img  src="{{ asset('teachers_2/icons/icons8-scorecard-30.png') }}">
                                                                        </a>


                                                            </div>
                                                        </div>

                                                    </div>
                                               @elseif($item->test )
                                                    <div class="col-md-4 newrow">
                                                        <div class="card12">
                                                            <h6 style="text-align:center;color: #094e89;">
                                                                {{ $item->namehomework }}
                                                            </h6>

                                                            <br>
                                                            @if ($item->extension == "docx")
                                                             <img src="{{  asset('teachers/photo/word.png')}}">
                                                             @elseif ($item->extension =="pdf")
                                                            <img src="{{  asset('teachers/photo/pdf1.png')}}">
                                                           @elseif ($item->extension == "pptx")
                                                            <img src="{{  asset('teachers/photo/powerpoint.png')}}">
                                                             @elseif ($item->extension == "mp3")
                                                             <audio
                                                            style="width: 210px; margin: 0 auto;justify-content: center;"
                                                            src="{{ asset('storage/') }}/{{ $item->test }}"
                                                            controls="">
                                                        </audio>
                                                            @else
                                                            <img src="{{ asset('storage/'.$item->test) }}" style="height: 207px;">
                                                            @endif
                                                            <br>
                                                            <div class="row ">
                                                                @if ($item->test_link != null)
                                                                    <div
                                                                        style="justify-content: right; float: right;text-align: right;">

                                                                        <a href="{{ $item->test_link }}" target="_blank"> <img
                                                                                src="{{ asset('teachers/link.png') }}"
                                                                                style="height: 40px;width:40px"
                                                                                title="رابط الوظيفة "> </a>

                                                                    </div>
                                                                @endif
                                                                &nbsp;&nbsp;&nbsp; &nbsp;
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a href="#"
                                                                    style="justify-content: left; float: left;"
                                                                    class="three" data-id="{{ $item->id }}"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-fullscreen-xs-down3"> <img
                                                                        title="حذف الملف "
                                                                        src="{{ asset('teachers/icons/icons8-waste.gif') }}"
                                                                        style="height: 30px;width:30px"
                                                                        title=" حذف الملف "> </a>
                                                                        &nbsp;&nbsp;

                                                                <a href="#"
                                                                    style="justify-content: left; float: left; text-align: left;">
                                                                    <a href="{{ asset('storage/' . $item->test) }}"
                                                                        target="_blank">
                                                                        <img title=" تنزيل الملف "
                                                                            src="{{ asset('teachers/icons/icons8-download.gif') }}"
                                                                            style="height: 30px;width:30px"> </a>
                                                                </a>
                                                                &nbsp;&nbsp;
                                                                <a href="{{ route('dashboard.edit_home', $item->id) }}">
                                                                    <img src="{{ asset('teachers/icons/icons8-edit-file-30.png') }}"
                                                                        tyle="justify-content: left; float: left; text-align: left;"
                                                                        title="تعديل  الوظيفة "> </a>
                                                                       &nbsp;&nbsp;
                                                                        <a href="{{ route('dashboard.StudentsRoomLesson',[$room_id ,$teacher->id,$lesson->id,$item->id]) }}"
                                                                            class="" title="علامات">

                                                                            <img  src="{{ asset('teachers_2/icons/icons8-scorecard-30.png') }}">
                                                                        </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach



                                            <!-- end link for homeworkk -->


                                        </div>


                                    </div>
                                </div>
                                  <div role="tabpanel" class="tab-pane fade" id="Section6">
                                    <h3 style="text-align: center;padding-bottom: 20px;">ملفات وزارية </h3>
                                    <div class="container">
                                        <div class="row" style="padding-bottom: 20px;">


                                        </div>
                                        <div class="row" style="justify-content: center;">
                                            @foreach ($super_file as $item)
                                            @if ($item->type==1)
                                            <div class="col-md-4 newrow">
                                                <div class="card12">
                                                    <h6 style="text-align:center;color: #094e89;">
                                                         ملف   ({{$item->name}})
                                                    </h6>

                                                    <br>
                                                    @if ($item->extension == "docx")
                                                     <img src="{{  asset('teachers/photo/word.png')}}">
                                                     @elseif ($item->extension =="pdf")
                                                    <img src="{{  asset('teachers/photo/pdf1.png')}}">
                                                   @elseif ($item->extension == "pptx")
                                                    <img src="{{  asset('teachers/photo/powerpoint.png')}}">
                                                     @elseif ($item->extension == "mp3")
                                                     <audio
                                                    style="width: 210px; margin: 0 auto;justify-content: center;"
                                                    src="{{ asset('storage/') }}/{{ $item->file }}"
                                                    controls="">
                                                      </audio>
                                                    @else
                                                    <img src="{{ asset('storage/'.$item->file) }}" style="height: 207px;">
                                                    @endif
                                                    <br>
                                                    <div class="row ">
                                                      


                                                        <a href="#"
                                                            style="justify-content: left; float: left; text-align: left;">
                                                            <a href="{{ asset('storage/' . $item->file) }}"
                                                                target="_blank">
                                                                <img title=" تنزيل الملف "
                                                                    src="{{ asset('teachers/icons/icons8-download.gif') }}"
                                                                    style="height: 30px;width:30px"> </a>
                                                        </a>
                                                        &nbsp;&nbsp;
                                                       

                                                    </div>
                                                </div>
                                            </div>
                                                @else
                                                <div class="col-md-4 newrow">
                                                    <div class="card12">
                                                        <h6 style="text-align:center;color: #094e89;">
                                                               خطة فصلية ({{$item->name}})
                                                        </h6>
    
                                                        <br>
                                                        @if ($item->extension == "docx")
                                                         <img src="{{  asset('teachers/photo/word.png')}}">
                                                         @elseif ($item->extension =="pdf")
                                                        <img src="{{  asset('teachers/photo/pdf1.png')}}">
                                                       @elseif ($item->extension == "pptx")
                                                        <img src="{{  asset('teachers/photo/powerpoint.png')}}">
                                                         @elseif ($item->extension == "mp3")
                                                         <audio
                                                        style="width: 210px; margin: 0 auto;justify-content: center;"
                                                        src="{{ asset('storage/') }}/{{ $item->file }}"
                                                        controls="">
                                                          </audio>
                                                        @else
                                                        <img src="{{ asset('storage/'.$item->file) }}" style="height: 207px;">
                                                        @endif
                                                        <br>
                                                        <div class="row ">
                                                          
                                                            
                                                            <a href="#"
                                                                style="justify-content: left; float: left; text-align: left;">
                                                                <a href="{{ asset('storage/' . $item->file) }}"
                                                                    target="_blank">
                                                                    <img title=" تنزيل الملف "
                                                                        src="{{ asset('teachers/icons/icons8-download.gif') }}"
                                                                        style="height: 30px;width:30px"> </a>
                                                            </a>
                                                            &nbsp;&nbsp;
                                                           
    
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end content-->
        </div>
        <!--end content-wrapper pb-0-->

    </div>
    <!--end main panels-->

    <div class="modal fade modal-fullscreen-xs-down alert_three" id="modal-fullscreen-xs-down3" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="direction:rtl">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                    <h4 class="modal-title" id="myModalLabel">انتباهك مطلوب </h4>
                </div>
                <div class="modal-body">
                    <p>هل انت متأكد من حذف العنصر ؟</p>
                </div>
                <div class="modal-footer">
                    <input id="s11" hidden type="text">
                    <button type="button" class="button-3" data-dismiss="modal">الغاء</button>
                    <button type="button " class="button-3 confirm3">نعم , موافق</button>
                </div>
            </div>
        </div>
    </div>
    <!-- container-scroller -->

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script>
        $(document).on('click', '.three', function(e) {
            var id = $(this).data('id');
            $('#s11').val($(this).data('id'));
            $('.confirm3').data('id', id);
        });
        $(document).on('click', '.confirm3', function(e) {
            var id = $('#s11').val();;
            e.preventDefault();
            $.ajax({
                type: 'get',
                url: "{{ route('dashboard.addition.delete') }}",
                data: {
                    'id': id,
                },
                success: function(data) {
                    //           notif({
                    //     msg: "تم عرض الدرس عند الطلاب",
                    //     type: "success"
                    // })
                    location.reload();
                    $(`#test_${id}`).remove();
                    $(`#item3_${id}`).remove();
                    $(".modal").modal('hide');
                    $('.alert_three').hide();


                },
                error: function(xhr) {

                }

            })


        });
    </script>
@endsection
