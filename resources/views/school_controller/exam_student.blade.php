@extends('school_controller.layouts.app')
@section('css')
    <style>
    /*css for show homework button*/
        a:hover {
            color: #fff;
            text-decoration: none;
        }

        .home {
            position: relative;
            /* margin: 0;*/
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
            background-color: #14315C;
            border-radius: 10px;
            color: #fff;
            font-weight: 300;
            font-size: 18px;
            font-family: inherit;
            z-index: 0;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .home:hover {
            animation: sh0 0.5s ease-in-out both;
        }

        @keyframes sh0 {
            0% {
                transform: rotate(0deg) translate3d(0, 0, 0);
            }

            25% {
                transform: rotate(7deg) translate3d(0, 0, 0);
            }

            50% {
                transform: rotate(-7deg) translate3d(0, 0, 0);
            }

            75% {
                transform: rotate(1deg) translate3d(0, 0, 0);
            }

            100% {
                transform: rotate(0deg) translate3d(0, 0, 0);
            }
        }

        .home:hover span {
            animation: storm 0.7s ease-in-out both;
            animation-delay: 0.06s;
        }

        .home::before,
        .home::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            opacity: 0;
            transition: transform 0.15s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.15s cubic-bezier(0.02, 0.01, 0.47, 1);
            z-index: -1;
            transform: translate(100%, -25%) translate3d(0, 0, 0);
        }

        .home:hover::before,
        .home:hover::after {
            opacity: 0.15;
            transition: transform 0.2s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.2s cubic-bezier(0.02, 0.01, 0.47, 1);
        }

        .home:hover::before {
            transform: translate3d(50%, 0, 0) scale(0.9);
        }

        .home:hover::after {
            transform: translate(50%, 0) scale(1.1);
        }

        /*end css*/

        /*css for download file*/
        .download-button {
            position: relative;
            border-width: 0;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border-radius: 4px;
            z-index: 1;
            display: inline-block;
        }

        .download-button .docs {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 40px;
            padding: 0 10px;
            border-radius: 4px;
            z-index: 1;
            background-color: #14315C;
            border: solid 1px #14315C;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        .download {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 90%;
            margin: 0 auto;
            z-index: -1;
            border-radius: 4px;
            transform: translateY(0%);
            background-color: #a5c9ff;
            border: solid 1px #a5c9ff;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover .download {
            transform: translateY(100%)
        }

        .download svg polyline,
        .download svg line {
            animation: docs 1s infinite;
        }

        @keyframes docs {
            0% {
                transform: translateY(0%);
            }

            50% {
                transform: translateY(-15%);
            }

            100% {
                transform: translateY(0%);
            }
        }

        /*end css for download*/
        /*css select*/

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

        .form-control,
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--single .select2-search__field,
        .typeahead,
        .tt-query,
        .tt-hint {
            font-size: 17px;
            font-weight: 600;
        }



        /*edit btn*/
        .Btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            width: 70px;
            height: 40px;
            border: none;
            padding: 0px 23px;
            background-color: #14315C;
            color: white;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 5px 5px 0px #14315C;
            transition-duration: .3s;
        }

        .svg {
            width: 13px;
            position: absolute;
            right: 0;
            margin-right: 3px;
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
            box-shadow: 2px 2px 0px #14315C;
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
        @media(min-width:200px) and (max-width:755px) {
            .selectrow {
                top: 2px !important;
                /*left: 16px;*/

            }
        }

        /*@media(min-width:756px) and (max-width:1020px){
          .selectrow{
            top: -69px !important;
            right: 0px !important;
          }
        }
        @media(min-width:1000px) and (max-width:3000px){
          .selectrow{

            right: 116px !important;
            width:80% !important
          }
        }*/
        .newselect {
            width: 100% !important
        }

        /*responsive table*/
        /**/

        table {
  border: 1px solid #ccc ;
  border-collapse: collapse !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;

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
    padding-left: 10px !important;
    /* padding: 22px !important; */
    border-top: 1px solid #ddd !important;
    border-bottom: none !important;
    display: block !important;
    padding-top: 5px !important;
    padding-bottom: 20px !important;
    padding-right: 10px !important;
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
@media(min-width:200px) and (max-width:900px){
    .cssbuttons-io-button {
        margin-bottom:20px !important;
        font-weight: 900 !important;
        font-size: 14px !important;
    }
}

 .cssbuttons-io-button {
  display: flex;
  align-items: center;
  font-family: inherit;
  font-weight: 500;
  font-size: 17px;
  padding: 0.8em 1.5em 0.8em 1.2em;
  color: white;
  background: linear-gradient(195deg, #14315C 20%, #d2e4ff 102%);*/
  background: #14315C;
  border: none;
  box-shadow: 0 0.7em 1.5em -0.5em #14315C;
  letter-spacing: 0.05em;
  border-radius: 20em;
  float: left;
  cursor:pointer;
}

.cssbuttons-io-button svg {
  margin-right: 8px;
}

.cssbuttons-io-button:hover {
  box-shadow: 0 0.5em 1.5em -0.5em #4d36d0be;
}

.cssbuttons-io-button:active {
  box-shadow: 0 0.3em 1em -0.5em #4d36d0be;
}
.download-button{
    margin-bottom: 19px;
    margin-top: -20px;
}

    </style>
@endsection
@section('content')
 @if (session()->has('error'))
        <script>
            window.onload = function () {
                notif({
                    msg: "  لايوجد اي ملف لتنزيله ",
                    type: "error"
                })
            }
        </script>
        @endif
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
            <li class="li"><a href="{{ route('dashboard.coordinator.exams_quizes') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a href="{{ route('dashboard.coordinator.marks.subjects',['room_id' => $room_id, 'coordinator_id' => $coordinator->id]) }}">المذاكرات والامتحانات</a></li>
            {{-- <li class="li"><a
                    href="{{ route('teacher.marks.subjects', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">علامات
                    المواد</a></li>
                     <li class="li"><a
                    href="{{ route('teacher_exam',[$room_id,$teacher->id,$lesson_id]) }}">
                    جميع الامتحانات</a></li> --}}
            <li class="li"><a href="#">{{ $exam->name }} </a></li>
        </ul>
        <div class="content-wrapper pb-0">

                     <input  id="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input id="exam_id" hidden value="{{ $exam_id }}" type="text">
                     <input  id="lesson_id" hidden value="{{ $lesson_id }}" type="text">

            <!--start content-->
            <div class="container" style="direction: rtl;">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="color: #9ea7af;
                                        text-align: right;">وقت البداية : {{ $exam->start_date }}</p>
                                        <p style="color: #9ea7af;
                                        text-align: right;">وقت النهاية : {{ $exam->end_date }}</p>
                                        <p style="color: #9ea7af;
                                        text-align: right;">العلامة  : {{ $exam->mark }}</p>
                                        <input type="hidden" id="success_mark" value="{{$exam->mark}}">

                                </div>
                                    <div class="col-md-4">
                                <h4 style="text-align: center;padding-bottom: 20px;color: #152C4F;font-size: 28px;">علامات
                                    الامتحان</h4>
                                </div>
                                    <div class="col-md-4" style="position: relative;z-index: 9;">
                                        {{-- <a href="{{route('dashboard.teacher.quize_zip',['room_id' => $room_id, 'exam_id' => $exam->id])}}" class="cssbuttons-io-button">
                                            <span>تنزيل جميع أوراق الامتحان</span>
                                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h24v24H0z" fill="none"></path><path d="M1 14.5a6.496 6.496 0 0 1 3.064-5.519 8.001 8.001 0 0 1 15.872 0 6.5 6.5 0 0 1-2.936 12L7 21c-3.356-.274-6-3.078-6-6.5zm15.848 4.487a4.5 4.5 0 0 0 2.03-8.309l-.807-.503-.12-.942a6.001 6.001 0 0 0-11.903 0l-.12.942-.805.503a4.5 4.5 0 0 0 2.029 8.309l.173.013h9.35l.173-.013zM13 12h3l-4 5-4-5h3V8h2v4z" fill="currentColor"></path></svg>
                                          </a> --}}

                                   </div>
                                </div>
                                <!--select students-->
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <input class="homeid" hidden value="{{ $exam->id }}">
                                            <div class="row selectrow" style="position: relative;top: -80px;">
                                                <div class="col-md-6" style="height: 80px;">
                                                    <div class="form-group newselect" style="width: 300px;">
                                                        <select class="js-example-basic-single choice"
                                                            style="width: 100%;direction: rtl;">
                                                            <option value="0"> كل الاطلاب   </option>
                                                            <option value="1"> يوجد ملف </option>
                                                            <option value="2"> لايوجد ملف </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--end select students-->
                                        </div>

                                    </div>

                                </div>

                                <div >
                                    <table class="table1">

                                        <thead>
                                            <tr>
                                                <th>الرقم التسلسلي</th>
                                                <th>اسم الطالب </th>
                                               <th>تاريخ ترفيع ملف الامتحان</th>
                                                <th>العلامة</th>
                                                <th>تحميل الملف </th>
                                              
                                                {{-- <th>حفظ العلامة  </th> --}}

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($exam_result as $item)
                                                @if($item->student)
                                                    <tr>
                                                        <form >
                                                            <td data-label="الرقم التسلسلي"class="">
                                                                {{ $item->student->id }}</td>
                                                            <td data-label="اسم الطالب" class="">
                                                                {{ $item->student->first_name }} {{ $item->student->last_name }} </td>

                                                             <td class=""data-label="تاريخ ترفيع الملف">
                                                                   @if($item->student->exams_files)
                                                                @if($item->student->exams_files->last())
                                                                    <p>{{$item->student->exams_files->last()->updated_at}}</p>
                                                                    @endif
                                                                     @endif
                                                                </td>

                                                            <td style="padding-bottom:20px"  data-label="العلامة" class="">



                    <input style="height: 50px; width:60px"  hidden name="exam_result_id"  value="{{ $item->id }}" type="number">

                       <input  style="height: 50px; width:94px;" name="mark" min="0.0" max="{{$exam->mark}}" value="{{ $item->result!=null ?$item->result : '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="number_mark common-input mb-20 form-control input2"  type="number">





                     <input style="height: 50px; width:60px"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input style="height: 50px; width:60px" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="{{ $item->student->id }}" type="text">


                                                            </td>
                                                            <td data-label="تحميل ملف" class=""
                                                                style="padding-bottom: 25px !important;">
                                                                @foreach ($item->student->exams_files as $item32)

             @if ($item32->exam_id == $exam_id  && $item32->lesson_id ==$lesson_id   )



                                              <a target="_blank" href="{{ asset('storage/app/'.$item32->file) }}"
                                                                                class="download-button">
                                                                                <div class="docs"><svg
                                                                                        class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="20" width="20"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                                        </path>
                                                                                        <polyline points="14 2 14 8 20 8">
                                                                                        </polyline>
                                                                                        <line y2="13"
                                                                                            x2="8" y1="13"
                                                                                            x1="16"></line>
                                                                                        <line y2="17"
                                                                                            x2="8" y1="17"
                                                                                            x1="16"></line>
                                                                                        <polyline points="10 9 9 9 8 9">
                                                                                        </polyline>
                                                                                    </svg></div>
                                                                                <div class="download">
                                                                                    <svg class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="24" width="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                                        </path>
                                                                                        <polyline
                                                                                            points="7 10 12 15 17 10">
                                                                                        </polyline>
                                                                                        <line y2="3"
                                                                                            x2="12" y1="15"
                                                                                            x1="12"></line>
                                                                                    </svg>
                                                                                </div>
                                                                            </a>


                 @else

                 @endif
                 @endforeach




                                                            </td>
                                                        
                                                     
                                                            {{-- <td data-label="عمليات التعديل" class="">
                                                                 <button class="Btn" type="submit">
                                                                    <svg class="svg" viewBox="0 0 512 512">
                                                                        <path
                                                                            d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                                                        </path>
                                                                    </svg>
                                                                    حفظ
                                                                </button>

                                                            </td> --}}
                                                        </form>
                                                    </tr>
                                                @endif
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
        </div>
        <!--end content-wrapper pb-0-->
    </div>
    <!--end main panels-->
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function () {
        $.each($('.input1'),function (key,value) {
            var z=value.value;
            $(this).parent().find('.input2').val(z);
        })

})
  $(document).on('keyup', '.number_mark', function () {

    if(parseInt($(this).val())>parseInt($('#success_mark').val())){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }



})
    $(document).on('click','.btn11', function () {
            var mark1=$('.mark').val();
         var room_id=$('#room_id').val();
          var exam_id=$('#exam_id').val();
           var lesson_id=$('#lesson_id').val();
            var exam_result_id=$(this).parent().parent().find('#exam_result_id').val();

             var user_id=$(this).data('val');
               $.each($('.input1'), function (key, value) {
                 if($(this).data('id')==user_id){
                    mark=$(this).val();
                    return false

                 }



             })
             if(parseInt(mark1)<parseInt(mark)){
                 alert('يرجى تعديل العلامة ');

             }else{
                   var data={

                        "room_id":room_id,
                        "exam_id":exam_id,
                        "lesson_id":lesson_id,
                        "user_id":user_id,
                        "mark":mark,
                        "exam_result_id":exam_result_id

                    }
         var url = "{{ URL::to('SMARMANger/dashboard/teacher/student_save_mark3') }}";
            $.ajax({
                url: url,
                data : data,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    location.reload();


                }
            })
             }

   })
        function formatDate(timestamp) {
    return moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
}
        $(document).on('change', '.choice', function () {
        var class_id=$('#class_id').val();
         var room_id=$('#room_id').val();
          var exam_id=$('#exam_id').val();
           var lesson_id=$('#lesson_id').val();


var lect=$(this).val();
var home =$('.homeid').val();
var mark =$('.mark').val();
var url = "{{ URL::to('SMARMANger/dashboard/coordinator/quizestudent') }}/" + lect+"/"+home +"/"+room_id;
$.ajax({
url: url,
type: "get",
contentType: 'application/json',
success: function (data) {

console.log(data);

if(lect==1){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
    
         c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="" type="text">`
             d=`<input style="height: 50px; width:94px;" name="mark"  value=""   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">> `
             if(value.exam_result2.length>0){
    $.each(value.exam_result2, function (key1, value1) {
         if(value1.exam_id == home){
        if(value1.result != null){

       c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="${value1.id}" type="text">`
  d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="${value1.id}" type="text">
  <input style="height: 50px; width:94px;" name="mark"  value="${value1.result}"   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`




        }
        else{

     d=`   <input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id" value="${value1.id}" type="text">
     <input style="height: 50px; width:94px" name="mark" value="" data-id="${ value.id }"  class="common-input mb-20 form-control input1"  type="number" min="0" max="${mark}"> `
}

         }
})
}

else{
     d=`
     <input style="height: 50px; width:94px;" name="mark"  value=""   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`
}

var b=[];
 $.each(value.exams_files, function (key1, value2) {

      if(value2.exam_id == home){
console.log(value2);

      b.push(`<a href="{{ url('/storage/app/') }}/${value2.file}" target="_blank" class="download-button">
                                                                                <div class="docs"><svg
                                                                                        class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="20" width="20"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                                        </path>
                                                                                        <polyline points="14 2 14 8 20 8">
                                                                                        </polyline>
                                                                                        <line y2="13"
                                                                                            x2="8" y1="13"
                                                                                            x1="16"></line>
                                                                                        <line y2="17"
                                                                                            x2="8" y1="17"
                                                                                            x1="16"></line>
                                                                                        <polyline points="10 9 9 9 8 9">
                                                                                        </polyline>
                                                                                    </svg></div>
                                                                                <div class="download">
                                                                                    <svg class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="24" width="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                                        </path>
                                                                                        <polyline
                                                                                            points="7 10 12 15 17 10">
                                                                                        </polyline>
                                                                                        <line y2="3"
                                                                                            x2="12" y1="15"
                                                                                            x1="12"></line>
                                                                                    </svg>
                                                                                </div>
                                                                            </a>`);

 }})
                  if (value.exams_files) {
                                            var number = value.exams_files.length - 1;
                                            var timestamp = value.exams_files[number].updated_at;
                                            var date = new Date(timestamp);

                                            date = `<p>${formatDate(date)}</p>`;
                                        }
     $('.table1 tbody').append(`
         <tr  id="st">

<input style="height: 50px; width:60px"  hidden name="class_id"  value="${ class_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="room_id"  value="${ room_id }"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="${ exam_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="${ lesson_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="${ value.id }" type="text">

            <td data-label="الرقم التسلسلي"class="py-1">${ value.id }</td>
<td data-label="اسم الطالب "class="py-1">${ value.first_name } ${ value.last_name}</td>

${c}
<td data-label="تاريخ ترفيع  "class="py-1">${date}</td>
<td data-label="العلامة "class="py-1">${d}</td>

<td data-label="تحميل الملف "class="py-1">
${b}</td>





</tr> `)

});




}

else if(lect==2){
    $('.table1 tbody').empty();
    $.each(data, function (key, value) {
         c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="" type="text">`
       
         d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  id="exam_result_id" value=""  type="text">
   <input style="height: 50px; width:94px;" name="mark"  value=""   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`

        if(value.exam_result2.length>0){

    $.each(value.exam_result2, function (key1, value1) {
          if(value1.exam_id == home && value1.user_id==value.id){
       if(value1.result != null){
            c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="${value1.id}" type="text">`
  d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  id="exam_result_id" value="${value1.id}" type="text">
   <input style="height: 50px; width:94px;" name="mark"  value="${value1.result}"   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`

 


       }
else{
    d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id" value="${value1.id}" type="text">
    <input style="height: 50px; width:94px;" name="mark"    data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`


}
}



    }
)
}

else{
     d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id"  id="exam_result_id" value=""  type="text">
  <input style="height: 50px; width:94px;" name="mark"     data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`

}

        $('.table1 tbody').append(`<tr  id="st">

            <td data-label="الرقم التسلسلي"class="py-1">${ value.id }</td>
<td data-label="اسم الطالب  "class="py-1">${ value.first_name } ${ value.last_name}</td>
<td data-label="تاريخ ترفيع  "class="py-1"></td>
${c}

<td data-label="علامة الطالب "class="py-1">${d}</td>
   <td></td>






</tr> `)

});

}
  else{
       $('.table1 tbody').empty();
    $.each(data, function (key, value) {
    
         c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="" type="text">`
             d=`<input style="height: 50px; width:94px;" name="mark"  value=""   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number"> `
             if(value.exam_result2.length>0){
    $.each(value.exam_result2, function (key1, value1) {
         if(value1.exam_id == home){
        if(value1.result != null){

       c=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="${value1.id}" type="text">`
  d=`<input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id"  value="${value1.id}" type="text">
  <input style="height: 50px; width:94px;" name="mark"  value="${value1.result}"   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`




        }
        else{

     d=`   <input style="height: 50px; width:60px"  hidden name="exam_result_id" id="exam_result_id" value="${value1.id}" type="text">
     <input style="height: 50px; width:94px" name="mark" value="" data-id="${ value.id }"  class="common-input mb-20 form-control input1"  type="number" min="0" max="${mark}"> `
}

         }
})
}

else{
     d=`
     <input style="height: 50px; width:94px;" name="mark"  value=""   data-id="${ value.id }"  min="0.0" class="number_mark number_mark common-input mb-20 form-control input1" max="${ value.mark}" min="0.0"  type="number">`
}

var b=[];
 $.each(value.exams_files, function (key1, value2) {

      if(value2.exam_id == home){
console.log(value2);

      b.push(`<a href="{{ url('/storage/app/') }}/${value2.file}" target="_blank" class="download-button">
                                                                                <div class="docs"><svg
                                                                                        class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="20" width="20"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                                        </path>
                                                                                        <polyline points="14 2 14 8 20 8">
                                                                                        </polyline>
                                                                                        <line y2="13"
                                                                                            x2="8" y1="13"
                                                                                            x1="16"></line>
                                                                                        <line y2="17"
                                                                                            x2="8" y1="17"
                                                                                            x1="16"></line>
                                                                                        <polyline points="10 9 9 9 8 9">
                                                                                        </polyline>
                                                                                    </svg></div>
                                                                                <div class="download">
                                                                                    <svg class="css-i6dzq1"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-linecap="round"
                                                                                        fill="none" stroke-width="2"
                                                                                        stroke="currentColor"
                                                                                        height="24" width="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                                        </path>
                                                                                        <polyline
                                                                                            points="7 10 12 15 17 10">
                                                                                        </polyline>
                                                                                        <line y2="3"
                                                                                            x2="12" y1="15"
                                                                                            x1="12"></line>
                                                                                    </svg>
                                                                                </div>
                                                                            </a>`);

 }})
                  if (value.exams_files) {
                                            var number = value.exams_files.length - 1;
                                            if(value.exams_files[number]){
                                                var timestamp = value.exams_files[number].updated_at;
                                            var date = new Date(timestamp);

                                            date = `<p>${formatDate(date)}</p>`; 
                                            }
                                            else{
                                                 date = `<p></p>`; 
                                            }
                                           
                                        }
     $('.table1 tbody').append(`
         <tr  id="st">

<input style="height: 50px; width:60px"  hidden name="class_id"  value="${ class_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="room_id"  value="${ room_id }"  type="text">
                     <input style="height: 50px; width:60px"  hidden name="exam_id"  value="${ exam_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="lesson_id"  value="${ lesson_id }" type="text">
                     <input style="height: 50px; width:60px"  hidden name="user_id"  value="${ value.id }" type="text">

            <td data-label="الرقم التسلسلي"class="py-1">${ value.id }</td>
<td data-label="اسم الطالب "class="py-1">${ value.first_name } ${ value.last_name}</td>

${c}
<td data-label="تاريخ ترفيع  "class="py-1">${date}</td>
<td data-label="العلامة "class="py-1">${d}</td>

<td data-label="تحميل الملف "class="py-1">
${b}</td>





</tr> `)

});
  }


},
error: function (xhr) {

}

});})

    </script>
@endsection
