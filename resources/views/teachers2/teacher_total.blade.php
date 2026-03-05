@extends('teachers2.layouts.app')
@section('css')


    <style>

      @media (min-width: 1400px) and (max-width: 1499px){
     .col-lg-12 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 103% !important;
    max-width: 109% !important;
}
.stretch-card > .card {
    width: 100%;
    min-width: 116% !important;
    left: 95px !important;
}
.table-responsive {
    display: block;
    width: 105% !important;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.tabs {
    padding: 4px !important;
    position: relative;
    left: 29px;}


}

     @media (min-width: 1500px) and (max-width: 2000px){
      .col-lg-12 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 118% !important;
    max-width: 120% !important;
}
.stretch-card > .card {
    width: 100%;
    min-width: 102% !important;
    left: 90px !important;
}
.table-responsive {
    display: block;
    width: 104% !important;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.tabs {
   padding: 4px !important;
    position: relative;
    left: 25px;

}


}

     @media (min-width: 200px) and (max-width: 770px){
      .btn {
    width: 8rem !important;

}
table {
    width: 388px !important;
}
.card .card-body {
    padding: 30px 0px !important;
}
  }
        @media (min-width: 992px){
            .container, .container-sm, .container-md, .container-lg {
              max-width: 1006px;
        }
        }


        .tabs {
            /* left: 50%;
          transform: translateX(-50%);
          position: relative;
          background: white;*/
            padding: 20px;
            padding-bottom: 80px;
            width: 100%;
            height: auto;
            /*box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);*/
            border-radius: 5px;
            /* min-width: 240px;*/
            direction: rtl;

        }

        .tabs input[name="tab-control"] {
            display: none;
        }

        .tabs .content section h2,
        .tabs ul li label {
            font-family: "Montserrat";
            font-weight: bold;
            font-size: 18px;
            color: #428bff;
        }

        .tabs ul {
            list-style-type: none;
            padding-left: 0;
            flex-direction: row;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            /*justify-content: space-between;*/
            align-items: center;
            flex-wrap: wrap;

        }

        .tabs ul li {
            box-sizing: border-box;
            /*flex: 1;*/
            /*width: 25%;*/
            /*padding: 0 0px;*/
            text-align: center;
        }

        .tabs ul li label {
            transition: all 0.3s ease-in-out;
            color: #929daf;
            padding: 5px auto;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
            -webkit-touch-callout: none;
        }

        .tabs ul li label br {
            display: none;
        }

        .tabs ul li label svg {
            fill: #929daf;
            height: 1.2em;
            vertical-align: bottom;
            margin-right: 0.2em;
            transition: all 0.2s ease-in-out;
        }

        .tabs ul li label:hover,
        .tabs ul li label:focus,
        .tabs ul li label:active {
            outline: 0;
            color: #bec5cf;
        }

        .tabs ul li label:hover svg,
        .tabs ul li label:focus svg,
        .tabs ul li label:active svg {
            fill: #bec5cf;
        }

        .tabs .slider {
            position: relative;
            width: 25%;
            transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
        }

        .tabs .slider .indicator {
            position: relative;
            width: 50px;
            max-width: 100%;
            margin: 0 auto;
            height: 4px;
            background: #cc151525;
            border-radius: 1px;
        }

        .tabs .content {
            margin-top: 30px;
        }

        .tabs .content section {
            display: none;
            animation-name: content;
            animation-direction: normal;
            animation-duration: 0.3s;
            animation-timing-function: ease-in-out;
            animation-iteration-count: 1;
            line-height: 1.4;
        }

        .tabs .content section h2 {
            color: #428bff;
            display: none;
        }

        .tabs .content section h2::after {
            content: "";
            position: relative;
            display: block;
            width: 30px;
            height: 3px;
            background: #14315C;
            margin-top: 5px;
            left: 1px;
        }

        .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
            cursor: default;
            color: #14315C;
        }

        .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
            fill: #14315C;
        }

        @media (max-width: 600px) {
            .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
                background: rgba(0, 0, 0, 0.08);
            }
        }

        .tabs input[name="tab-control"]:nth-of-type(1):checked~.slider {
            transform: translateX(0%);
        }

        .tabs input[name="tab-control"]:nth-of-type(1):checked~.content>section:nth-child(1) {
            display: block;
        }

        .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
            cursor: default;
            color: #14315C;
        }

        .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
            fill: #14315C;
        }

        @media (max-width: 600px) {
            .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
                background: rgba(0, 0, 0, 0.08);
            }
        }

        .tabs input[name="tab-control"]:nth-of-type(2):checked~.slider {
            transform: translateX(100%);
        }

        .tabs input[name="tab-control"]:nth-of-type(2):checked~.content>section:nth-child(2) {
            display: block;
        }

        .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
            cursor: default;
            color: #14315C;
        }

        .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
            fill: #14315C;
        }

        @media (max-width: 600px) {
            .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
                background: rgba(0, 0, 0, 0.08);
            }
        }

        .tabs input[name="tab-control"]:nth-of-type(3):checked~.slider {
            transform: translateX(200%);
        }

        .tabs input[name="tab-control"]:nth-of-type(3):checked~.content>section:nth-child(3) {
            display: block;
        }

        /*tab 4*/
        .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
            cursor: default;
            color: #428bff;
        }

        .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
            fill: #428bff;
        }

        @media (max-width: 600px) {
            .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
                background: rgba(0, 0, 0, 0.08);
            }
        }

        .tabs input[name="tab-control"]:nth-of-type(4):checked~.slider {
            transform: translateX(0%);
        }

        .tabs input[name="tab-control"]:nth-of-type(4):checked~.content>section:nth-child(4) {
            display: block;
        }

        .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
            transform: translateX(300%);
        }

        .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
            display: block;
        }

        @keyframes content {
            from {
                opacity: 0;
                transform: translateY(5%);
            }

            to {
                opacity: 1;
                transform: translateY(0%);
            }
        }

        @media (max-width: auto) {
            .tabs ul li label {
                white-space: initial;
            }

            .tabs ul li label br {
                display: initial;
            }

            .tabs ul li label svg {
                height: 1.5em;
            }
        }

        @media (max-width: 600px) {
            .tabs ul li label {
                padding: 5px;
                border-radius: 5px;
            }

            .tabs ul li label span {
                display: none;
            }

            .tabs .slider {
                display: none;
            }

            .tabs .content {
                margin-top: 20px;
            }

            .tabs .content section h2 {
                display: block;
            }
        }

        .number {
            -webkit-transform: skew(0deg) !important;
            -moz-transform: skew(0deg) !important;
            -o-transform: skew(0deg) !important;
        }

@media screen and (max-width: 900px){
 table td {
    padding: 16px !important;
    border-top: 1px solid #ddd !important;
    border-bottom: none !important;
    display: block !important;
    font-size: .8em !important;
    text-align: right !important;
}
}
table th {
    font-size: 15px !important;
}

        /*end section my classes*/
    </style>
@endsection
@section('content')
@if (session()->has('error22'))
<script>
    window.onload = function () {
        notif({
            msg: "  لا يمكن التعديل تم تثبيت العلامات",
            type: "error"
        })
    }
</script>
@endif
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
            <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a href="{{ route('teacher.mark_class') }}">دفتر العلامات </a></li>
            <li class="li"><a
                    href="{{ route('teacher.mark_room', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">علامات
                    المواد</a></li>
            <li class="li"><a href="#">دفتر العلامات</a></li>
        </ul>
        <div class="content-wrapper pb-0">
            <!-- marks of subjects -->
            <div class="container mt-5" style="direction: rtl;">
                <div class="row" style="justify-content: right">
                    {{--<div class="col-md-2" style="margin-right: 23px;">
                        <a href="{{ route('dashboard.StudentsRoomLessontotal_pdf', [$room_id, $teacher->id, $lesson_id]) }}"
                            class="button" target="_blank"
                            style="padding-top: 10px;
                            color: white;">pdf
                            تنزيل
                        </a>
                    </div>--}}
                    {{-- <div class="col-md-2">
                        <a href="{{ route('dashboard.StudentsRoomLessontotal_excel', [$room_id, $teacher->id, $lesson_id]) }}"
                            class="button" target="_blank"
                            style="padding-top: 10px;
                            color: white;">تنزيل اكسل
                        </a>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <!--start content-->
                                <div class="tabs">
                                    <input type="radio" id="tab1" name="tab-control" checked>
                                    <input type="radio" id="tab2" name="tab-control">
                                    <ul>
                                        <li title="الفصل الأول "><label for="tab1" role="button"><svg
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                                                </svg>
                                                <span>الفصل الأول</span></label></li> &nbsp;&nbsp;&nbsp;&nbsp;

                                        <li title="الفصل الثاني "><label for="tab2" role="button"><br><svg
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                                                </svg>
                                                <span>الفصل الثاني</span></label></li>&nbsp;&nbsp;&nbsp;&nbsp;

                                        <!--li title="المحصلة "><label for="tab3" role="button"><br><svg viewBox="0 0 24 24"><path d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z"/>
                  </svg>
                    <span>المحصلة</span></label></li-->

                                    </ul>


                                    <div class="">
                                        <div class="indicator"></div>
                                    </div>

                                    <div class="content">
                                        <section>
                                            <h2>الفصل الأول</h2>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="text-align: center;">الطلاب </th>
                                                            <th rowspan="2" style="text-align: center;">الدرجة العظمى
                                                            </th>
                                                            <th rowspan="1" colspan="4" style="text-align: center;">
                                                                درجات اعمال الفصل الأول
                                                            </th>
                                                            <th rowspan="1" colspan="1" style="text-align: center;">
                                                                درجة اختبار الفصل الأول
                                                            </th>
                                                            <th rowspan="1" colspan="1" style="text-align: center;">
                                                                مجموع درجات الفصل الأول
                                                            </th>
                                                            <th rowspan="2" colspan="1" style="text-align: center;">
                                                                تقدير الفصل الأول </th>
                                                            <th rowspan="2" colspan="1" style="text-align: center;">
                                                                ارسال </th>

                                                        </tr>
                                                        <tr>

                                                            <th rowspan="1" colspan="1"
                                                                style="text-align: center;">شفوية <br> <span
                                                                    style="color: #f38639;">%١٠</span> </th>
                                                            <th rowspan="1" colspan="1"
                                                                style="text-align: center;"> وظائف و اوراق عمل <br>
                                                                <span style="color: #f38639;">%١٠</span>
                                                            </th>
                                                            <th rowspan="1" colspan="1"
                                                                style="text-align: center;"> نشاطات و مبادرات <br>
                                                                <span style="color: #f38639;">%٢٠</span>
                                                            </th>
                                                            <th rowspan="1" colspan="1"
                                                                style="text-align: center;"> المذاكرات <br> <span
                                                                    style="color: #f38639;">%٢٠</span></th>
                                                            <th rowspan="1" colspan="1"
                                                                style="text-align: center;"><span
                                                                    style="color: #f38639;">%٤٠</span>
                                                            </th>
                                                            <th rowspan="1" colspan="1" style="text-align:center;">
                                                                <span style="color: #f38639;">%١٠٠</span>
                                                            </th>
                                                        </tr>


                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            function arabic_w2e($str)
                                                            {
                                                                $arabic_eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
                                                                $arabic_western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                                                                return str_replace($arabic_western, $arabic_eastern, $str);
                                                            }

                                                        @endphp
                                                        @foreach ($students->student as $item)
                                                            <form action="{{ route('admin.teacher_student_mark') }}"
                                                                method="post">
                                                                @csrf
                                                                <tr>
                                                                    <input type="hidden" name="term" value="term1">
                                                                    <input type="hidden" name="room_id"
                                                                        value="{{ $room_id }}">
                                                                    <input type="hidden" name="student_id"
                                                                        value="{{ $item->id }}">
                                                                    <input type="hidden" name="lesson_id"
                                                                        value="{{ $lesson_id }}">
                                                                    <td data-label="اسم الطالب"> {{ $item->first_name }} {{ $item->last_name }}
                                                                    </td>
                                                                    <td data-label="الدرجة العظمى"  class="total"
                                                                        data-number="{{ $lesson->max_mark }}"> </td>

                                                                    @foreach ($item->student_mark as $item2)

                                                                        <td data-label="شفوية">
                                                                            @php
                                                                            $decodedData = json_decode($item2->mark);
                                                                          @endphp
                                                                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                                                <input class="number"
                                                                                    style="height: 50px; width:60px; border: 1px solid red;"
                                                                                    value="" name="oral"
                                                                                    onfocus="this.placeholder = ''"
                                                                                    onblur="this.placeholder = ''"
                                                                                    class="common-input mb-20 form-control"
                                                                                    type="number" min="0"
                                                                                    data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                    max="{{ $lesson->max_mark * 0.1 }}">

                                                                            @endif
                                                                            @foreach (json_decode($item2->mark, true) as $key => $item)



                                                                                @if ($key == $lesson_id && $item['oral'] != 'null')

                                                                                    @if (json_decode($item2->mark, true)[$lesson_id]['oral'] == null)
                                                                                        <input class="number"
                                                                                            style="height: 50px; width:60px; border: 1px solid red;"
                                                                                            value="{{ json_decode($item2->mark, true)[$lesson_id]['oral'] }}"
                                                                                            name="oral"
                                                                                            onfocus="this.placeholder = ''"
                                                                                            onblur="this.placeholder = ''"
                                                                                            class="common-input mb-20 form-control"
                                                                                            type="number" min="0"
                                                                                            data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                            max="{{ $lesson->max_mark * 0.1 }}">
                                                                                    @else
                                                                                        <input class="number"
                                                                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                                            value="{{ json_decode($item2->mark, true)[$lesson_id]['oral'] }}"
                                                                                            name="oral"
                                                                                            onfocus="this.placeholder = ''"
                                                                                            onblur="this.placeholder = ''"
                                                                                            class="common-input mb-20 form-control"
                                                                                            type="number" min="0"
                                                                                            data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                            max="{{ $lesson->max_mark * 0.1 }}">
                                                                                    @endif
                                                                                @break

                                                                            @endif

                                                                        @endforeach




                                                                    </td>


                                                                    <td data-label="وظائف واوراق عمل">
                                                                        @php
                                                                        $decodedData = json_decode($item2->mark);
                                                                      @endphp
                                                                        @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                                            <input class="number"
                                                                                style="height: 50px; width:60px; border: 1px solid red;"
                                                                                value="" name="homework"
                                                                                onfocus="this.placeholder = ''"
                                                                                onblur="this.placeholder = ''"
                                                                                class="common-input mb-20 form-control"
                                                                                type="number" min="0"
                                                                                data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                max="{{ $lesson->max_mark * 0.1 }}">

                                                                        @endif

                                                                        @foreach (json_decode($item2->mark, true) as $key => $item)
                                                                            @if ($key == $lesson_id && $item['homework'] != 'null')
                                                                                @if (json_decode($item2->mark, true)[$lesson_id]['homework'] == null)
                                                                                    <input class="number"
                                                                                        style="height: 50px; width:60px; border: 1px solid red;"
                                                                                        value="{{ json_decode($item2->mark, true)[$lesson_id]['homework'] }}"
                                                                                        name="homework"
                                                                                        onfocus="this.placeholder = ''"
                                                                                        onblur="this.placeholder = ''"
                                                                                        class="common-input mb-20 form-control"
                                                                                        type="number" min="0"
                                                                                        data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                        max="{{ $lesson->max_mark * 0.1 }}">
                                                                                @else
                                                                                    <input class="number"
                                                                                        style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                                        value="{{ json_decode($item2->mark, true)[$lesson_id]['homework'] }}"
                                                                                        name="homework"
                                                                                        onfocus="this.placeholder = ''"
                                                                                        onblur="this.placeholder = ''"
                                                                                        class="common-input mb-20 form-control"
                                                                                        type="number" min="0"
                                                                                        data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                                        max="{{ $lesson->max_mark * 0.1 }}">
                                                                                @endif
                                                                            @break

                                                                        @endif

                                                                    @endforeach


                                                                </td>

                                                                <td data-label="نشاطات ومبادرات">
                                                                    @php
                                                                    $decodedData = json_decode($item2->mark);
                                                                  @endphp
                                                                    @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                                        <input class="number"
                                                                            style="height: 50px; width:60px; border: 1px solid red;"
                                                                            value="" name="activities"
                                                                            onfocus="this.placeholder = ''"
                                                                            onblur="this.placeholder = ''"
                                                                            class="common-input mb-20 form-control"
                                                                            type="number" min="0"
                                                                            data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                            max="{{ $lesson->max_mark * 0.2 }}">

                                                                    @endif
                                                                    @foreach (json_decode($item2->mark, true) as $key => $item)
                                                                        @if ($key == $lesson_id && $item['activities'] != 'null')
                                                                            @if (json_decode($item2->mark, true)[$lesson_id]['activities'] == null)
                                                                                <input class="number"
                                                                                    style="height: 50px; width:60px; border: 1px solid red;"
                                                                                    value="{{ json_decode($item2->mark, true)[$lesson_id]['activities'] }}"
                                                                                    name="activities"
                                                                                    onfocus="this.placeholder = ''"
                                                                                    onblur="this.placeholder = ''"
                                                                                    class="common-input mb-20 form-control"
                                                                                    type="number" min="0"
                                                                                    data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                                    max="{{ $lesson->max_mark * 0.2 }}">
                                                                            @else
                                                                                <input class="number"
                                                                                    style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                                    value="{{ json_decode($item2->mark, true)[$lesson_id]['activities'] }}"
                                                                                    name="activities"
                                                                                    onfocus="this.placeholder = ''"
                                                                                    onblur="this.placeholder = ''"
                                                                                    class="common-input mb-20 form-control"
                                                                                    type="number" min="0"
                                                                                    data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                                    max="{{ $lesson->max_mark * 0.2 }}">
                                                                            @endif
                                                                        @break

                                                                    @endif

                                                                @endforeach


                                                            </td>

                                                            <td data-label="المذاكرات">
                                                                @php
                                                                $decodedData = json_decode($item2->mark);
                                                              @endphp
                                                                @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                                    <input class="number"
                                                                        style="height: 50px; width:60px; border: 1px solid red;"
                                                                        value="" name="quize"
                                                                        onfocus="this.placeholder = ''"
                                                                        onblur="this.placeholder = ''"
                                                                        class="common-input mb-20 form-control"
                                                                        type="number" min="0"
                                                                        data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                        max="{{ $lesson->max_mark * 0.2 }}">

                                                                @endif
                                                                @foreach (json_decode($item2->mark, true) as $key => $item)
                                                                    @if ($key == $lesson_id && $item['quize'] != 'null')
                                                                        @if (json_decode($item2->mark, true)[$lesson_id]['quize'] == null)
                                                                            <input class="number"
                                                                                style="height: 50px; width:60px; border: 1px solid red;"
                                                                                value="{{ json_decode($item2->mark, true)[$lesson_id]['quize'] }}"
                                                                                name="quize"
                                                                                onfocus="this.placeholder = ''"
                                                                                onblur="this.placeholder = ''"
                                                                                class="common-input mb-20 form-control"
                                                                                type="number" min="0"
                                                                                data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                                max="{{ $lesson->max_mark * 0.2 }}">
                                                                        @else
                                                                            <input class="number"
                                                                                style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                                value="{{ json_decode($item2->mark, true)[$lesson_id]['quize'] }}"
                                                                                name="quize"
                                                                                onfocus="this.placeholder = ''"
                                                                                onblur="this.placeholder = ''"
                                                                                class="common-input mb-20 form-control"
                                                                                type="number" min="0"
                                                                                data-max="{{ $lesson->max_mark * 0.2 }}"
                                                                                max="{{ $lesson->max_mark * 0.2 }}">
                                                                        @endif
                                                                    @break

                                                                @endif

                                                            @endforeach



                                                        </td>

                                                        <td data-label="درجة اختبار الفصل الاول">
                                                            @php
                                                            $decodedData = json_decode($item2->mark);
                                                          @endphp
                                                            @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                                <input class="number"
                                                                    style="height: 50px; width:60px; border: 1px solid red;"
                                                                    value="" name="exam"
                                                                    onfocus="this.placeholder = ''"
                                                                    onblur="this.placeholder = ''"
                                                                    class="common-input mb-20 form-control"
                                                                    type="number" min="0"
                                                                    data-max="{{ $lesson->max_mark * 0.4 }}"
                                                                    max="{{ $lesson->max_mark * 0.4 }}">

                                                            @endif
                                                            @foreach (json_decode($item2->mark, true) as $key => $item)
                                                                @if ($key == $lesson_id && $item['exam'] != 'null')
                                                                    @if (json_decode($item2->mark, true)[$lesson_id]['exam'] == null)
                                                                        <input class="number"
                                                                            style="height: 50px; width:60px; border: 1px solid red;"
                                                                            value="{{ json_decode($item2->mark, true)[$lesson_id]['exam'] }}"
                                                                            name="exam"
                                                                            onfocus="this.placeholder = ''"
                                                                            onblur="this.placeholder = ''"
                                                                            class="common-input mb-20 form-control"
                                                                            type="number" min="0"
                                                                            data-max="{{ $lesson->max_mark * 0.4 }}"
                                                                            max="{{ $lesson->max_mark * 0.4 }}">
                                                                    @else
                                                                        <input class="number"
                                                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                            value="{{ json_decode($item2->mark, true)[$lesson_id]['exam'] }}"
                                                                            name="exam"
                                                                            onfocus="this.placeholder = ''"
                                                                            onblur="this.placeholder = ''"
                                                                            class="common-input mb-20 form-control"
                                                                            type="number" min="0"
                                                                            data-max="{{ $lesson->max_mark * 0.4 }}"
                                                                            max="{{ $lesson->max_mark * 0.4 }}">
                                                                    @endif
                                                                @break

                                                            @endif

                                                        @endforeach


                                                    </td>
                                                    <td data-label="مجموع درجات الفصل الاول">
                                                        @if ($item2->result1)
                                                            @foreach (json_decode($item2->result1, true) as $key => $item)
                                                                @if ($key == $lesson_id && $item['term1_result'] != 'null')
                                                                    @if (json_decode($item2->result1, true)[$lesson_id]['term1_result'] >= $lesson->min_mark)
                                                                        <span>
                                                                            {{ arabic_w2e(json_decode($item2->result1, true)[$lesson_id]['term1_result']) }}</span>
                                                                    @else
                                                                        <span
                                                                            style="color: red;
                         text-decoration: underline;">
                                                                            {{ arabic_w2e(json_decode($item2->result1, true)[$lesson_id]['term1_result']) }}</span>
                                                                    @endif
                                                                @break

                                                            @endif

                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td data-label="تقدير الفصل الاول">
                                                    @if ($item2->estimation1)
                                                        @foreach (json_decode($item2->estimation1, true) as $key => $item)
                                                            @if ($key == $lesson_id)
                                                                {{ $item }}
                                                            @break

                                                        @endif

                                                    @endforeach

                                                @endif
                                            </td>
                                            <td>
                                                @if ($item2->key == 0)
                                                    <button type="submit" class="btn"
                                                        style="background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);
                                color: white;
                                width: 100px;
                                margin: auto;">ارسال
                                                    </button>
                                                @endif

                                            </td>
                                        @endforeach
                                    </tr>
                                </form>
                            @endforeach





                        </tbody>
                    </table>
                </div>





            </section>
            <!-- end mark subject -->
            <section>
                <h2>الفصل الثاني </h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead style="text-align: center;">
                            <tr style="text-align: center;">
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;">الطلاب </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;"> الدرجة العظمى </th>
                                <th rowspan="1" colspan="4"
                                    style="text-align: center;"> درجة اعمال الفصل
                                    الثاني </th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;">درجة اختبار الفصل
                                    الثاني </th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;">مجموع درجات الفصل
                                    الثاني </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;">تقدير الفصل الثاني
                                </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;">مجموع درجات الفصلين
                                </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;"> متوسط درجات الفصلين
                                </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;"> التقدير النهائي </th>
                                <th rowspan="2" colspan="1"
                                    style="text-align: center;"> ارسال </th>
                            </tr>
                            <tr>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;">شفوية <br> <span
                                        style="color: #f38639;">%١٠</span> </th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;"> وظائف و اوراق عمل <br>
                                    <span style="color: #f38639;">%١٠</span>
                                </th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;"> نشاطات و مبادرات <br>
                                    <span style="color: #f38639;">%٢٠</span>
                                </th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;"> المذاكرات <br> <span
                                        style="color: #f38639;">%٢٠</span></th>
                                <th rowspan="1" colspan="1"
                                    style="text-align: center;"><span
                                        style="color: #f38639;">%٤٠</span>
                                </th>
                                <th rowspan="1" colspan="1" style="text-align:center;">
                                    <span style="color: #f38639;">%١٠٠</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody style="text-align: center;">
                            @foreach ($students->student as $item)
                                <form action="{{ route('admin.teacher_student_mark') }}"
                                    method="post">
                                    @csrf
                                    <tr>
                                        <input type="hidden" name="term" value="term2">
                                        <input type="hidden" name="room_id"
                                            value="{{ $room_id }}">
                                        <input type="hidden" name="student_id"
                                            value="{{ $item->id }}">
                                        <input type="hidden" name="lesson_id"
                                            value="{{ $lesson_id }}">
                                        <td data-label="اسم الطالب"> {{ $item->first_name }} {{ $item->last_name }}
                                        </td>
                                        <td data-label="الدرجة العظمى" class="total"
                                            data-number="{{ $lesson->max_mark }}"> </td>
                                        @foreach ($item->student_mark as $item2)
                                            <td data-label="شفوية">
                                                @php
                                                $decodedData = json_decode($item2->mark2);
                                              @endphp
                                                @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                    <input class="number"
                                                        style="height: 50px; width:60px; border: 1px solid red;"
                                                        value="" name="oral"
                                                        onfocus="this.placeholder = ''"
                                                        onblur="this.placeholder = ''"
                                                        class="common-input mb-20 form-control"
                                                        type="number" min="0"
                                                        data-max="{{ $lesson->max_mark * 0.1 }}"
                                                        max="{{ $lesson->max_mark * 0.1 }}">

                                                @endif
                                                @foreach (json_decode($item2->mark2, true) as $key => $item)
                                                    @if ($key == $lesson_id && $item['oral'] != 'null')
                                                        @if (json_decode($item2->mark2, true)[$lesson_id]['oral'] == null)
                                                            <input class="number"
                                                                style="height: 50px; width:60px; border: 1px solid red;"
                                                                value="{{ json_decode($item2->mark2, true)[$lesson_id]['oral'] }}"
                                                                name="oral"
                                                                onfocus="this.placeholder = ''"
                                                                onblur="this.placeholder = ''"
                                                                class="common-input mb-20 form-control"
                                                                type="number" min="0"
                                                                data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                max="{{ $lesson->max_mark * 0.1 }}">
                                                        @else
                                                            <input class="number"
                                                                style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                                value="{{ json_decode($item2->mark2, true)[$lesson_id]['oral'] }}"
                                                                name="oral"
                                                                onfocus="this.placeholder = ''"
                                                                onblur="this.placeholder = ''"
                                                                class="common-input mb-20 form-control"
                                                                type="number" min="0"
                                                                data-max="{{ $lesson->max_mark * 0.1 }}"
                                                                max="{{ $lesson->max_mark * 0.1 }}">
                                                        @endif
                                                    @break

                                                @endif

                                            @endforeach



                                        </td>


                                        <td data-label="وظائف واوراق عمل">
                                            @php
                                                $decodedData = json_decode($item2->mark2);
                                              @endphp
                                                @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                                <input class="number"
                                                    style="height: 50px; width:60px; border: 1px solid red;"
                                                    value="" name="homework"
                                                    onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = ''"
                                                    class="common-input mb-20 form-control"
                                                    type="number" min="0"
                                                    data-max="{{ $lesson->max_mark * 0.1 }}"
                                                    max="{{ $lesson->max_mark * 0.1 }}">

                                            @endif
                                            @foreach (json_decode($item2->mark2, true) as $key => $item)
                                                @if ($key == $lesson_id && $item['homework'] != 'null')
                                                    @if (json_decode($item2->mark2, true)[$lesson_id]['homework'] == null)
                                                        <input class="number"
                                                            style="height: 50px; width:60px; border: 1px solid red;"
                                                            value="{{ json_decode($item2->mark2, true)[$lesson_id]['homework'] }}"
                                                            name="homework"
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = ''"
                                                            class="common-input mb-20 form-control"
                                                            type="number" min="0"
                                                            data-max="{{ $lesson->max_mark * 0.1 }}"
                                                            max="{{ $lesson->max_mark * 0.1 }}">
                                                    @else
                                                        <input class="number"
                                                            style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                            value="{{ json_decode($item2->mark2, true)[$lesson_id]['homework'] }}"
                                                            name="homework"
                                                            onfocus="this.placeholder = ''"
                                                            onblur="this.placeholder = ''"
                                                            class="common-input mb-20 form-control"
                                                            type="number" min="0"
                                                            data-max="{{ $lesson->max_mark * 0.1 }}"
                                                            max="{{ $lesson->max_mark * 0.1 }}">
                                                    @endif
                                                @break

                                            @endif

                                        @endforeach



                                    <td data-label="نشاطات ومبادرات">
                                        @php
                                        $decodedData = json_decode($item2->mark2);
                                      @endphp
                                        @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                            <input class="number"
                                                style="height: 50px; width:60px; border: 1px solid red;"
                                                value="" name="activities"
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = ''"
                                                class="common-input mb-20 form-control"
                                                type="number" min="0"
                                                data-max="{{ $lesson->max_mark * 0.2 }}"
                                                max="{{ $lesson->max_mark * 0.2 }}">

                                        @endif
                                        @foreach (json_decode($item2->mark2, true) as $key => $item)
                                            @if ($key == $lesson_id && $item['activities'] != 'null')
                                                @if (json_decode($item2->mark2, true)[$lesson_id]['activities'] == null)
                                                    <input class="number"
                                                        style="height: 50px; width:60px; border: 1px solid red;"
                                                        value="{{ json_decode($item2->mark2, true)[$lesson_id]['activities'] }}"
                                                        name="activities"
                                                        onfocus="this.placeholder = ''"
                                                        onblur="this.placeholder = ''"
                                                        class="common-input mb-20 form-control"
                                                        type="number" min="0"
                                                        data-max="{{ $lesson->max_mark * 0.2 }}"
                                                        max="{{ $lesson->max_mark * 0.2 }}">
                                                @else
                                                    <input class="number"
                                                        style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                        value="{{ json_decode($item2->mark2, true)[$lesson_id]['activities'] }}"
                                                        name="activities"
                                                        onfocus="this.placeholder = ''"
                                                        onblur="this.placeholder = ''"
                                                        class="common-input mb-20 form-control"
                                                        type="number" min="0"
                                                        data-max="{{ $lesson->max_mark * 0.2 }}"
                                                        max="{{ $lesson->max_mark * 0.2 }}">
                                                @endif
                                            @break

                                        @endif

                                    @endforeach


                                </td>

                                <td data-label="المذاكرات">
                                    @php
                                    $decodedData = json_decode($item2->mark2);
                                  @endphp
                                    @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                        <input class="number"
                                            style="height: 50px; width:60px; border: 1px solid red;"
                                            value="" name="quize"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = ''"
                                            class="common-input mb-20 form-control"
                                            type="number" min="0"
                                            data-max="{{ $lesson->max_mark * 0.2 }}"
                                            max="{{ $lesson->max_mark * 0.2 }}">

                                    @endif
                                    @foreach (json_decode($item2->mark2, true) as $key => $item)
                                        @if ($key == $lesson_id && $item['quize'] != 'null')
                                            @if (json_decode($item2->mark2, true)[$lesson_id]['quize'] == null)
                                                <input class="number"
                                                    style="height: 50px; width:60px; border: 1px solid red;"
                                                    value="{{ json_decode($item2->mark2, true)[$lesson_id]['quize'] }}"
                                                    name="quize"
                                                    onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = ''"
                                                    class="common-input mb-20 form-control"
                                                    type="number" min="0"
                                                    data-max="{{ $lesson->max_mark * 0.2 }}"
                                                    max="{{ $lesson->max_mark * 0.2 }}">
                                            @else
                                                <input class="number"
                                                    style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                    value="{{ json_decode($item2->mark2, true)[$lesson_id]['quize'] }}"
                                                    name="quize"
                                                    onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = ''"
                                                    class="common-input mb-20 form-control"
                                                    type="number" min="0"
                                                    data-max="{{ $lesson->max_mark * 0.2 }}"
                                                    max="{{ $lesson->max_mark * 0.2 }}">
                                            @endif
                                        @break

                                    @endif

                                @endforeach


                            </td>

                            <td data-label="درجة اختبار الفصل الثاني">
                                @php
                                $decodedData = json_decode($item2->mark2);
                              @endphp
                                @if (!$decodedData ||  (!property_exists($decodedData,  $lesson_id )) )
                                    <input class="number"
                                        style="height: 50px; width:60px; border: 1px solid red;"
                                        value="" name="exam"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = ''"
                                        class="common-input mb-20 form-control"
                                        type="number" min="0"
                                        data-max="{{ $lesson->max_mark * 0.4 }}"
                                        max="{{ $lesson->max_mark * 0.4 }}">

                                @endif
                                @foreach (json_decode($item2->mark2, true) as $key => $item)
                                    @if ($key == $lesson_id && $item['exam'] != 'null')
                                        @if (json_decode($item2->mark2, true)[$lesson_id]['exam'] == null)
                                            <input class="number"
                                                style="height: 50px; width:60px; border: 1px solid red;"
                                                value="{{ json_decode($item2->mark2, true)[$lesson_id]['exam'] }}"
                                                name="exam"
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = ''"
                                                class="common-input mb-20 form-control"
                                                type="number" min="0"
                                                data-max="{{ $lesson->max_mark * 0.4 }}"
                                                max="{{ $lesson->max_mark * 0.4 }}">
                                        @else
                                            <input class="number"
                                                style="height: 50px; width:60px;border: 1px solid #e9d8db;"
                                                value="{{ json_decode($item2->mark2, true)[$lesson_id]['exam'] }}"
                                                name="exam"
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = ''"
                                                class="common-input mb-20 form-control"
                                                type="number" min="0"
                                                data-max="{{ $lesson->max_mark * 0.4 }}"
                                                max="{{ $lesson->max_mark * 0.4 }}">
                                        @endif
                                    @break

                                @endif

                            @endforeach


                        </td>
                        <td data-label="مجوع درجات الفصل الثاني">
                            @if ($item2->result2)
                                @foreach (json_decode($item2->result2, true) as $key => $item)
                                    @if ($key == $lesson_id && $item['term2_result'] != 'null')
                                        @if (json_decode($item2->result2, true)[$lesson_id]['term2_result'] >= $lesson->min_mark)
                                            <span>
                                                {{ arabic_w2e(json_decode($item2->result2, true)[$lesson_id]['term2_result']) }}</span>
                                        @else
                                            <span
                                                style="color: red;
                         text-decoration: underline;">
                                                {{ arabic_w2e(json_decode($item2->result2, true)[$lesson_id]['term2_result']) }}</span>
                                        @endif
                                    @break

                                @endif

                            @endforeach
                        @endif
                    </td>
                    <td data-label="تقدير الفصل الثاني">
                        @if ($item2->estimation2)
                            @foreach (json_decode($item2->estimation2, true) as $key => $item)
                                @if ($key == $lesson_id)
                                    {{ $item }}
                                @break

                            @endif

                        @endforeach

                    @endif
                </td>
                <td data-label="مجموع درجات الفصلين" class="c1"
                    @if ($item2->result) @foreach (json_decode($item2->result, true) as $key => $item)
                                @if ($key == $lesson_id && $item['year_result'] != 'null')
                                data-number="{{ json_decode($item2->result, true)[$lesson_id]['year_result'] }}"
                                @break @endif
                    @endforeach
            @endif ></td>



            <td data-label="متوسط درجات الفصلين">
                @if ($item2->result)
                    @foreach (json_decode($item2->result, true) as $key => $item)
                        @if ($key == $lesson_id && $item['year_result'] != 'null')
                            @if (ceil(json_decode($item2->result, true)[$lesson_id]['year_result'] / 2) >= $lesson->min_mark)
                                {{ arabic_w2e(ceil(json_decode($item2->result, true)[$lesson_id]['year_result'] / 2)) }}
                            @else
                                <span
                                    style="color: red;
                                    text-decoration: underline;">
                                    {{ arabic_w2e(ceil(json_decode($item2->result, true)[$lesson_id]['year_result'] / 2)) }}
                                </span>
                            @endif
                        @break

                    @endif

                @endforeach
            @endif
        </td>
        <td data-label="التقدير النهائي">
            @if ($item2->estimation)
                @foreach (json_decode($item2->estimation, true) as $key => $item)
                    @if ($key == $lesson_id)
                        {{ $item }}
                    @break

                @endif

            @endforeach

        @endif
    </td>
    <td>
        @if ($item2->key == 0)
            <button type="submit" class="btn"
                style="background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);
color: white;
width: 100px;
margin: auto;">ارسال
            </button>
        @endif

    </td>
@endforeach
</tr>

</form>
@endforeach





</tbody>
</table>
</div>
</section>

</div>
</div>
<!--end tabs-->
</div>
<!--card body-->
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.min.js>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    $.each($('.c1'), function(key, value) {

        $(this).append(`<p>${ new Intl.NumberFormat("ar-SA").format($(this).data('number'))}</p>`)
    })

    $.each($('.total'), function(key, value) {

        $(this).append(`<p>${ new Intl.NumberFormat("ar-SA").format($(this).data('number'))}</p>`)
    })
    $.each($('.v1'), function(key, value) {

        $(this).append(`<p>${ new Intl.NumberFormat("ar-SA").format($(this).data('number'))}</p>`)
    })

    $(document).on('keyup', '.number', function() {

        if ($(this).val() > $(this).data('max') || $(this).val() == "") {
            alert('لايمكن وضع القيمة');
            $(this).val("");
        }


    })
</script>
<script type="text/javascript">
    var array1 = new Array();

    var n = 1; //Total table
    for (var x = 1; x <= n; x++) {
        array1[x - 1] = x;

    }

    var tablesToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template =
            '<html xmlns.o="urn.schemas-microsoft-com.office.office" xmlns.x="urn.schemas-microsoft-com.office.excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x.ExcelWorkbook><x.ExcelWorksheets>',
            templateend = '</x.ExcelWorksheets></x.ExcelWorkbook></xml><![endif]--></head>',
            body = '<body>',
            tablevar = '<table>{table',
            tablevarend = '}</table>',
            bodyend = '</body></html>',
            worksheet = '<x.ExcelWorksheet><x.Name>',
            worksheetend =
            '</x.Name><x.WorksheetOptions><x.DisplayGridlines/></x.WorksheetOptions></x.ExcelWorksheet>',
            worksheetvar = '{worksheet',
            worksheetvarend = '}',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            },
            wstemplate = '',
            tabletemplate = '';

        return function(table, name, filename) {
            var tables = table;

            for (var i = 0; i < tables.length; ++i) {
                wstemplate += worksheet + worksheetvar + i + worksheetvarend + worksheetend;
                tabletemplate += tablevar + i + tablevarend;
            }

            var allTemplate = template + wstemplate + templateend;
            var allWorksheet = body + tabletemplate + bodyend;
            var allOfIt = allTemplate + allWorksheet;

            var ctx = {};
            for (var j = 0; j < tables.length; ++j) {
                ctx['worksheet' + j] = name[j];
            }

            for (var k = 0; k < tables.length; ++k) {
                var exceltable;
                if (!tables[k].nodeType) exceltable = document.getElementById(tables[k]);
                ctx['table' + k] = exceltable.innerHTML;
            }

            //document.getElementById("dlink").href = uri + base64(format(template, ctx));
            //document.getElementById("dlink").download = filename;
            //document.getElementById("dlink").click();
            window.location.href = uri + base64(format(allOfIt, ctx));

        }
    })();
</script>
@endsection
