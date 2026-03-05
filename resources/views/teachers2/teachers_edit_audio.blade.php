@extends('teachers2.layouts.app')
@section('css')
    <style>
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 100% !important;
            width: 100% !important;
            margin: auto !important;
            background-color: #fff;
            padding-top: 10px;
            padding-left: 20px;
            padding-right: 20px;
            padding-bottom: 50px;
            border-radius: 20px;
            position: relative;
        }

        .title {
            font-size: 28px;
            color: royalblue;
            font-weight: 600;
            letter-spacing: -1px;
            position: relative;
            display: flex;
            align-items: center;
            padding-left: 30px;
        }

        .title::before,
        .title::after {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50%;
            left: 0px;
            background-color: royalblue;
        }

        .title::before {
            width: 18px;
            height: 18px;
            background-color: royalblue;
        }

        .title::after {
            width: 18px;
            height: 18px;
            animation: pulse 1s linear infinite;
        }

        .message,
        .signin {
            color: rgba(88, 87, 87, 0.822);
            font-size: 14px;
        }

        .signin {
            text-align: center;
        }

        .signin a {
            color: royalblue;
        }

        .signin a:hover {
            text-decoration: underline royalblue;
        }

        .flex {
            display: flex;
            width: 100%;
            gap: 6px;
        }

        .form label {
            position: relative;
        }

        .form label .input {
            width: 100%;
            padding: 10px 10px 20px 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }

        .form label .input+span {
            position: absolute;
            left: 10px;
            top: 15px;
            color: grey;
            font-size: 0.9em;
            cursor: text;
            transition: 0.3s ease;
        }

        .form label .input:placeholder-shown+span {
            top: 15px;
            font-size: 0.9em;
        }

        .form label .input:focus+span,
        .form label .input:valid+span {
            top: 30px;
            font-size: 0.7em;
            font-weight: 600;
        }

        .form label .input:valid+span {
            color: green;
        }

        .submit {
            width: 300px;
            position: relative;
            top: 45px;

            border: none;
            outline: none;
            background-color: royalblue;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            transform: .3s ease;
        }

        .submit:hover {
            background-color: rgb(56, 90, 194);
        }

       

        label {
            text-align: right;
            display: block;
            font-size: 18px;
            color: #152C4F;
        }

        form div span {
            background-color: transparent !important
        }

        @media(min-width:1000px) and (max-width:2000px) {
            . {
                /*top: -44px !important;*/
                margin-bottom: -50px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
            <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a
                    href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room->id, 'teacher_id' => $teacher->id]) }}">{{ $room->name }}
                </a></li>
            <li class="li"><a
                    href="{{ route('dashboard.lessons.lectures', ['lesson_id' => $lecture->lesson->id, 'teacher_id' => $teacher->id, 'room_id' => $room->id]) }}">{{ $lecture->lesson->name }}</a>
            </li>
            <li class="li"><a
                    href="{{ route('dashboard.student.lessons.book_details', [$lecture->lesson->id, $teacher->id, $room->id, $lecture->id]) }}">{{ $lecture->name }}</a>
            </li>
            <li class="li"><a href="#">تعديل مقطع الصوت</a></li>

        </ul>

        <div class="content-wrapper pb-0">
            @if (session()->has('message'))
            <div class="alert alert-danger">
                {{ session()->get('message') }}
            </div>
        @endif
            <!--start content-->
            <div class="container" style="padding-bottom: 100px">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('dashboard.audio.update', $file->id) }}" class="form" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <label for="">اسم مقطع الصوت</label>
                                        <input class="form-control" type="text" name="name_audio"  value="{{ $file->name_audio }}" />
                                    </div>



                                    <div class="col-md-6 ">
                                        <label>رابط خارجي </label>
                                        <input class="form-control" type="text"name="audio_link" value="{{ $file->audio_link }}" />
                                    </div>
                                    <div class="col-md-6 ">
                                        @if ($file->audio_file)
                                            <label style="top: -45px">ملف الصوت القديم </label>
                                            <audio style="float:right"
                                                src="{{ asset('storage/') }}/{{ $file->audio_file }}" controls="">
                                            </audio>
                                        @endif
                                        </a>
                                    </div>



                                    <div class="col-md-6 ">
                                        <label for="">تحميل مقطع الصوت</label>
                                        <label for="file-input" class="drop-container">
                                            <span class="drop-title">
                                                <br>
                                                <br>
                                            </span>
                                            <input type="file" id="file-input" name="audio_file" value="{{ $file->audio_file }}"  accept="audio/*" >
                                        </label>
                                        </a>
                                    </div>
                                </div>
                                <div class="row" style="justify-content: center">
                                    <div class="col-md-5">
                                        <input class="submit" type="submit" value="حفظ التعديل" style="width: 300px">
                                    </div>

                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
