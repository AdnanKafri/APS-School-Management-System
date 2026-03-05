@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
     <style>

@media (min-width: 992px){
    .modal-lg, .modal-xl {
    max-width: 34%;
}
}

table {
  border: 1px solid #ccc ;
  border-collapse: collapse !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;
  margin-top:150px !important;
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
@media screen and (max-width: 600px) {

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
	 </style>
@endsection
@section('content')
@if (session()->has('success'))

<script>
    window.onload = function() {
        notif({
            msg: "  تم التخزين بنجاح  ",
            type: "success"
        })
    }

</script>
@endif
@if (session()->has('otherday'))

<script>
    window.onload = function() {
        notif({
            msg: " {{ session()->get('otherday') }} ",
            type: "warning"
        })
    }

</script>
@endif
@if (session()->has('othertime'))

<script>
    window.onload = function() {
        notif({
            msg: " {{ session()->get('othertime') }} ",
            type: "warning"
        })
    }

</script>
@endif
@if ($errors->any())

    @foreach ($errors->all() as $error)
    {{-- <li>{{ $error }}</li> --}}
    <script>
        window.onload = function() {
            notif({
                msg: `{{  $error }}`  ,
                type: "error"
            })
        }

    </script>
    @endforeach

@endif
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="{{route('student_exam')}}">الامتحانات</a></li>
    <li class="li"><a href="#"> الامتحانات</a></li>

   </ul>
    <div class="content-wrapper pb-0">
      <!--content -->
      <!--css foe modal-->
      <!--end css for mdal-->
      <div class="container" style="position: relative; top: -95px;">

          <div class="row">
            <!--table of exams-->
           <div class="col-md-12">

              <table class=""  >
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">اسم الامتحان</th>
                      <th scope="col">اليوم</th>
                      <th scope="col">التاريخ</th>
                      <th scope="col">الوقت</th>
                      <th scope="col">مدة الامتحان</th>
                      <th scope="col">النوع</th>
                      <th scope="col">المطلوب </th>
                      <th scope="col">حالة الامتحان</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1 ;
                    $background = '#fff';
                ?>
            @foreach ($exams as $item)
            @php
                // if($item->type == 2) $background = '#269dbbf5';
                // else if($item->type == 3) $background = '#51a3b7d6';
                if($item->type == 2) $background = '#1c4d76e3';
                else if($item->type == 3) $background = '#357885f0';
            @endphp
                    <tr  style="background: {{ $background }};">

                        <th scope="row" data-label="#" >{{ $i++ }}</th>
                        <td data-label=" اسم الامتحان" >{{ $item->name . ' / ' .$item->lesson->name}}</td>
                        <td scope="row" data-label=" اليوم " >
                            @if( $item->day == 0)
                            السبت
                            @elseif($item->day == 1)
                            الأحد
                            @elseif($item->day == 2)
                            الاثنين
                            @elseif($item->day == 3)
                            الثلاثاء
                            @elseif($item->day == 4)
                            الأربعاء
                            @elseif($item->day == 5)
                            الخميس
                            @elseif($item->day == 6)
                            الجمعة
                            @endif
                        </td>

                        <td data-label=" التاريخ " > {{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</td>
                        <td data-label=" الوقت " > {{ \Carbon\Carbon::parse($item->start_date)->format('g:i a') }}</td>

                      <td data-label=" مدة الامتحان" >{{ $item->period }}  </td>
                      <td data-label=" نوع الامتحان" >
                      @if($item->is_file == 0 )
                      مؤتمت
                  @elseif($item->is_file == 1 )
                      ملف
                  @endif
                      </td>
                      <td data-label=" المطلوب " ><a href="#modal" class="butt exam_required"   data-required="{{ $item->required }}"
                        data-name="{{ $item->name }}"
                        data-lesson_name="{{ $item->lesson->name }}"
                         title="المطلوب">المطلوب</a></td>

                      <td data-label=" حالة الامتحان" >
                        @if(isset($item->result))

                        @if( $item->result != -1)
                           <a class=" butt aaa btn btn-info circle" href=" {{route('dashboard.student.exam.view_main_exam',$item->id)}}">
                               {{ $item->result.'/'.$item->mark }}
                           </a >
                        @else
                           <button class=" butt aaa btn btn-info circle" href=""
                                   title=" لم يتم التصحيح من قبل الاستاذ بعد">
                                               قيد التصحيح
                                   </button>
                        @endif

                 @elseif($item->is_file=='0')
                       @if ($now > $item->start_date && $now < $item->end_date)
                       <a   href="{{ route('dashboard.student.start_main_exam',$item->id) }}"
                               target="_blank"
                               class=" butt aaa btn btn-success circle" >
                               ابدأ الامتحان
                       </a>

                       @elseif ($now > $item->end_date)
                       <button class=" butt aaa btn btn-dark circle" >
                               انتهت
                       </button>
                       @else
                       <button class=" butt aaa btn btn-dark circle" >
                               مخطط لها
                       </button>
                       @endif
                   @else

                       @if ($now > $item->start_date && $now < $item->end_date)
                       @if ($item->file)
                       <a href="  {{ asset('storage/'.$item->file) }}"
                       target="_blank"
                       class=" butt"  >
                        تنزيل الأسئلة
                       </a>
                       @endif

                       <button class=" butt  upload_files"   data-effect="effect-scale"
                       data-toggle="modal" data-target="#upload_files"
                       data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                       data-lesson_name="{{ $item->lesson->name }}"
                       title="ارفع ملف" >
                           <!--<i class="fa fa-pencil-square-o fa-xs" aria-hidden="true "></i>-->
                           رفع الحل
                       </button>
                       @elseif($now > $item->end_date)
                       <button class="butt">
                               انتهت
                       </button>
                       @else
                       <button class="butt">
                               مخطط لها
                       </button>
                       @endif
                   @endif
                       </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>

       <!--end content of table-->
           </div><!--end col-md-12-->



           </div><!--end row-->

            <div class="modal fade" id="upload_files">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content" style="direction: rtl; text-align:right">
              <a href="#"></a>
              <section>

                  <div class="controls">
                    <a href="#" data-dismiss="modal"><i class="fa fa-times"></i></a>
                  </div>
                  <h3 style="text-align: center;">ترفيع الملف</h3>
                  <!--content of form-->
                  <form  action="{{ route('dashboard.student.upload_exam_files') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="exam_id" id="exam_id" value="" class="exam_id">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <label for="">  اسم المحتوى  </label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text"  name="content_name" id="content_name" value="" readonly class=" content_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">اسم المادة </label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text"name="content_name" id="lesson_name"  value="  " readonly class=" lesson_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">ترفيع  الحل */يمكن رفع عدة ملفات معاً/* : </label>
                          <input name="file[]" id="file" class="common-input mb-20 form-control"  type="file" multiple>

                        </div>
                      </div><!--end col-->

                    </div>
                    <div class="form-group modal-footer row px-3">
                      <button class="button" type="submit" >تأكيد </button>
                    <button  class="button" data-dismiss="modal" >خروج</button>
                </div>
    </form>
                  </div>



                  <!--end contetn of foem-->

              </section>
            </div>
              </div>
            </div>
            <!--end modal popup-->
            <!--end table of exams-->

          </div>
        </div>

      <!--end content-->

        <!---modal popup-->
             <div id="modal" style="z-index:9">
              <a href="#"></a>
              <section>
                <form style="direction: rtl; text-align: right;position: relative;
                top: -30px;">
                  <div class="controls">
                    <a href="#"><i class="fa fa-times"></i></a>
                  </div>
                  <h3 style="text-align: center;">المطلوب دراسته</h3>
                  <!--content of form-->
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <label for="">الاسم</label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text" name="name" value="" readonly class=" content_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">اسم المادة </label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text" name="name" value="  " readonly class=" lesson_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">المطلوب </label>
                          <textarea class=" required form-control"  name="" id="" cols="30" rows="10" value="المطلوب دراسته " readonly></textarea>

                        </div>
                      </div><!--end col-->

                    </div>

                  </div>


                  <!--end contetn of foem-->
                </form>
              </section>
            </div>

</div>


	@endsection
    @section('js')
    <script>
 $(document).ready(function(){
   $('.exam11').addClass('active') ;
 })
        $(window).on("load",function(){
            if ("{{ Session::has('success') }}") {
                notif({
                    msg: " {{ Session::get('success') }} ",
                    type: "success"
                })
            }
            if ("{{ Session::has('error') }}") {
                notif({
                    msg: " {{ Session::get('error') }} ",
                    type: "error"
                })            }
        })
        $(document).ready(function(){
                $(document).on("click", ".upload_files", function (event) {
                var  button = $(this);
                var id = button.data('id');
                var content_name = button.data('name');
                var lesson_name = button.data('lesson_name');
                $('#exam_id').val(id);
                $('#content_name').val(content_name);
                $('#lesson_name').val(lesson_name);

            });
                $(document).on("click", ".exam_required", function (event) {
                var  button = $(this);
                var content_name = button.data('name');
                var lesson_name = button.data('lesson_name');
                var required = button.data('required');

                $('.content_name').val(content_name);
                $('.lesson_name').val(lesson_name);
                $('.required').val(required);

            });

        });
    </script>
    @endsection
