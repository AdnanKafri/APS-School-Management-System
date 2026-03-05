@extends('students.layouts.app')

@section('email')
{{ $student->email }}
@endsection

@section('image')
{{ asset('storage/'.$student->image) }}
@endsection

@section('name')
{{ $student->first_name }} {{ $student->last_name }}

@endsection

@section('lessons')
{{ route('dashboard.student.lessons',$student->id) }}
@endsection


@section('results')
{{ route('dashboard.student.results',$student->id) }}
@endsection


@section('financial_account')
{{ route('dashboard.financial_account',$student->id) }}
@endsection


@section('message')
{{ route('dashboard.messages',$student->id) }}
@endsection

@section('count')
@if ($count!='0')
{{ $count }}
    @endif
@endsection


@section('events')
{{ route('dashboard.student.events') }}
@endsection

@section('my_info')
{{ $student->first_name }} {{ $student->last_name }}
الصف 
{{$class->name}}
/
الشعبة 
{{$room->name}}
@endsection
@section('content')

<!--@if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

<!--@if(session()->has('warning'))-->


<!--  <div class="alert alert-warning alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('warning') }}-->
<!--    </div>-->
<!--@endif-->


<div class="clearfix">
    <h1 style="text-align: center; font-size: 50px">{{ $lesson->name }}</h1>

</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab" aria-expanded="true">المحتوى العلمي</a></li>
        <li role="presentation" class=""><a href="#profile_animation_1" data-toggle="tab" aria-expanded="false">الفيديوهات</a></li>
        <li role="presentation" class=""><a href="#messages_animation_11" data-toggle="tab" aria-expanded="false">الوظائف</a></li>
        <li role="presentation"><a href="#settings_animation_1" data-toggle="tab">المذاكرات</a></li>
        <li role="presentation"><a href="#settings_animation_2" data-toggle="tab">الامتحانات</a></li>
        <li role="presentation"><a href="#settings_animation_3" data-toggle="tab">العلامات</a></li>

    </ul>


    <br>
    <!-- Tab panes -->
    <div class="tab-content">
        
        
                <div role="tabpanel" class="tab-pane animated pulse active" id="home_animation_1">

            <div class="row">


@if ($lesson->book1 != null)
                <div class="col-md-3 " style="padding:0; width:220px; margin-right:15px; margin-left:15px">



<a href="
@if ($lesson->type_file1== '0')
{{$lesson->book1}}
@else
{{ asset('storage/'.$lesson->book1) }}
@endif


" target="_blank" style="text-decoration:none !important;">
    
    
<div class="card">
<div class="header" style="padding:0; width:220px">


@if ($lesson->image1 != null)
<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('storage/'.$lesson->image1) }}" alt="">

@else 

<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('website/images/course/c1.jpg') }}" alt="">

@endif


</div>
<div class="body" style="text-align: center; font-size: 20px; padding:7px">
{{ $lesson->name_book1_ar }}
</div>
</div>


</a>




                </div>

@endif






@if ($lesson->book2 != null)
                <div class="col-md-3" style="padding:0; width:220px;  margin-right:15px; margin-left:15px">

<a href="
@if ($lesson->type_file2== '0')
{{$lesson->book2}}
@else
{{ asset('storage/'.$lesson->book2) }}
@endif


" style="text-decoration:none !important;" target="_blank" width="220px" height="220px">




<div class="card">
<div class="header" style="padding:0; width:220px;">


@if ($lesson->image2 != null)
<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('storage/'.$lesson->image2) }}" alt="">

@else 

<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('website/images/course/c1.jpg') }}" alt="">

@endif


</div>
<div class="body" style="text-align: center; font-size: 20px; padding:7px">
{{ $lesson->name_book2_ar }}
</div>
</div>
                        
                        
                        

</a>
                </div>

@endif




@if ($lesson->book3 != null)
                <div class="col-md-3" style="padding:0; width:220px; margin-right:15px; margin-left:15px">

<a href="
@if ($lesson->type_file3== '0')
{{$lesson->book3}}
@else
{{ asset('storage/'.$lesson->book3) }}
@endif


" target="_blank" style="text-decoration:none !important;" width="220px" height="220px">




           <div class="card">
                            <div class="header" style="padding:0; width:220px">

@if ($lesson->image3 != null)
<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('storage/'.$lesson->image3) }}" alt="">

@else 

<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('website/images/course/c1.jpg') }}" alt="">

@endif



                            </div>
                            <div class="body" style="text-align: center; font-size: 20px; padding:7px">
                                {{ $lesson->name_book3_ar }}
                            </div>
                        </div>


</a>
                </div>

@endif



@if ($lesson->book4 != null)
                <div class="col-md-3" style="padding:0; width:220px; margin-right:15px; margin-left:15px">

<a href="
@if ($lesson->type_file4== '0')
{{$lesson->book4}}
@else
{{ asset('storage/'.$lesson->book4) }}
@endif


" target="_blank" style="text-decoration:none !important;" width="220px" height="220px">





           <div class="card">
                            <div class="header" style="padding:0; width:220px">

@if ($lesson->image4 != null)
<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('storage/'.$lesson->image4) }}" alt="">

@else 

<img width="220px" height="220px" style="border: 2px solid #019983" src="{{ asset('website/images/course/c1.jpg') }}" alt="">

@endif



                            </div>
                            <div class="body" style="text-align: center; font-size: 20px; padding:7px">
                                {{ $lesson->name_book4_ar }}
                            </div>
                        </div>



</a>



                </div>

@endif
                
                       </div>
 
<br>
                @if (isset($lesson_details))
                <div class="row">
                @foreach ($lesson_details as $item)

                @if ($item->type=='4')

         <div class="col-md-3" style="padding:0; width:220px; margin-right:15px; margin-left:15px">
                        <a href="  {{ asset('storage/'.$item->addition) }}" style="text-decoration:none">

                        <div class="card">
                            <div class="header" style="padding:0; width:220px">

                                @if ($item->extension=="docx")
                                <img src="{{ asset('students/images/docx.jpg') }}" style="border: 2px solid #019983" width="220px" height="220px" alt="">

                                @elseif ($item->extension=="pdf")
                                <img src="{{ asset('students/images/pdf.png') }}" style="border: 2px solid #019983" width="220px" height="220px" alt="">

                                     @elseif ($item->extension=="jpg" || $item->extension=="jpeg" || $item->extension=="png")
                                
                                <img src="{{ asset('storage/'.$item->addition) }}" style="border: 2px solid #019983" width="220px" height="220px" alt="">

                                @endif



                            </div>
                            <div class="body" style="text-align: center; font-size: 20px; padding:7px">
                                {{ $item->created_at->format('d-m-Y') }}
                            </div>
                        </div>
                    </a>


                    </div>
                @endif
                @endforeach

            </div>
                @endif


        
</div>
        <div role="tabpanel" class="tab-pane animated pulse" id="profile_animation_1">


            @if (isset($lesson_details))
                <div class="row">

                    @foreach ($lesson_details as $item)
                    @if ($item->type=='0')

                    <div class="col-md-4">
                        <a 
                        
                             @if($item->type_video=='1')

                                 href="  {{ $item->video }}"     
                    @else 
                    
                         href="  {{ asset('storage/'.$item->video) }}" 
                    
                    
                    @endif
                    target="_blank" style="text-decoration:none!important">

                        <div class="card">
                            <div class="header bg-red">


                        @if($item->type_video=='1')

                                <img src="{{ asset('students/images/youtube.png') }}" width="100%" height="127px" alt="">

@else 

                                <img src="{{ asset('students/images/video_in.jpg') }}" width="100%" height="127px" alt="">


@endif




                            </div>
                            <div class="body" style="text-align: center; font-size: 20px">
                            {{ $item->created_at }}
                            </div>
                        </div>
                    </a>


                    </div>
                    @endif
                        @endforeach


                </div>
            @endif

        </div>

        <div role="tabpanel" class="tab-pane animated pulse" id="messages_animation_11">


            @if (isset($lesson_details))
                <div class="row">

                    @foreach ($lesson_details as $item)
                    @if ($item->type=='1')
@if ($now>$item->start_time)

                    <div class="col-md-3">

                        <div class="card">
                            <a 
                            
                    @if($item->type_file=='1')
                            
                              href="  {{$item->test}}"
                            @else 
                              href="  {{ asset('storage/'.$item->test) }}"
                            
                            @endif
                            
                          >

                            <div class="header bg-red1" style="padding:0">
                                <span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">{{ $item->id }}</span>
                                <img src="{{ asset('students/images/test.png') }}" width="100%" height="100%" alt="">

                            </div>

                    </a>
                            <div class="body" style="text-align: center; font-size: 20px; padding:10px">
                                {{-- {{ $item->end_time }} --}}
                                @if ($item->end_time!=null && $item->end_time>$now)
                                <input type="hidden" id="time" class="time" name="time" value="{{ $item->end_time }}">

                                @endif
                                @php
                                  $a=  $secondsDifference=strtotime($item->end_time)-strtotime($now);
                                $a=$a/60;
                                  $a=intval($a);
                                  $b=$a%60;
                                  $c=intval($a/60);
                                @endphp


@if ($now>$item->start_time && $now<$item->end_time)
<div class="time-left"> </div>

@if($item->type=='1')
<a href=".uploadTestModal" class=" btn btn-success xx" data-toggle="modal" id="uploadTestModal"
data-id="{{ $item->id }}"><i class="material-icons" data-toggle="tooltip"></i>ارفع الملف</a>
@endif

@else

<span class="label bg-red">انتهى</span>

@endif



                        </div>

                    </div>




                    </div>

                    @endif
                    @endif

                        @endforeach


                </div>


<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="text-align: left; font-weight: bold; font-size: 24px">
الحلول السابقة
                </h2>

            </div>
            <div class="body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="font-size: 20px; font-weight: bold">   الاجابات	</th>
                            <th style="font-size: 20px; font-weight: bold">الملف</th>
                            <th style="font-size: 20px; font-weight: bold">المهمات</th>

                            {{-- --------------------------- --}}
                        </tr>
                    </thead>
                    <tbody>
            @for ($i = 0; $i < count($answers); $i++)

    @foreach ($answers[$i] as $item)
@if ($item->type=='1')
<tr id="answer_{{ $item->id }}">

    <td><span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">{{ $item->file_id }}</span></td>
    <td>

<a href="{{ asset('storage/'.$item->file) }}">
    @if ($item->extension=="docx")
    <img src="{{ asset('students/images/docx.jpg') }}" width="50px" height="50px" alt="">

    @elseif ($item->extension=="pdf")
    <img src="{{ asset('students/images/pdf.png') }}" width="50px" height="50px" alt="">

@else
    <img src="{{ asset('storage/'.$item->file) }}" width="50px" height="50px" alt="">

    @endif
</a>


</td>

<td>



    <a id="delete_answer" data-id="{{ $item->id }}" class="btn btn-danger btn-sm delete_answer">حذف</a>


</td>
</tr>

@endif

    @endforeach
@endfor
                    </tbody>

                </table>

</div>



        </div>
    </div>
</div>
            @endif




        </div>





{{-- ------------------------------------------------ --}}



<div class="modal fade in uploadTestModal" id="" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: right">
                <h1 class="modal-title" id="defaultModalLabel">ارفع الملف </h1>


                <small>قم بترفيع الملف بعد الاجابة عليه
                </small>

            </div>
            <div class="modal-body" style="text-align: right; direction: rtl">

                <form method="POST" action="{{ route('dashboard.student.upload_store') }}"  enctype="multipart/form-data">


                    @csrf
                    <input type="hidden" value="{{ $lesson_id }}" name="lesson_id">
                    <input type="hidden" value="{{ $student_id }}"  name="student_id">
                    <input type="hidden" value="1" name="type">
                    <input type="hidden" value="{{ $teacher_id }}" name="teacher_id">
                    <input type="hidden" value="{{ $room_id }}" name="room_id">
                    <input type="hidden" value="{{ $term_id }}" name="term_id">



                    <label for="">Test</label>
                    <input type="hidden" id="" name="file_id" class="file_id" placeholder="test">

                    <input type="file" name="test_file" class="" placeholder="test">

                    <br>
                    <br>
                    <button class="send btn btn-success" id="test_btn">ارسال</button>

                </div>

                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div> --}}
        </div>
    </div>





{{-- ----------------------------------------------------------- --}}

        <div role="tabpanel" class="tab-pane animated pulse" id="settings_animation_1">

            @if (isset($lesson_details))
                <div class="row">

                    @foreach ($lesson_details as $item)
                    @if ($item->type=='2')

                    <div class="col-md-3">

                        <div class="card">
                    <a 
                    
                    @if($item->type_file=='1')
                     href=" {{$item->quize}}"
                    @else
                     href=" {{ asset('storage/'. $item->quize ) }}"
                    @endif
                    
                   >

                            <div class="header bg-red1" style="padding:0">
                                <span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">{{ $item->id }}</span>

                                <img src="{{ asset('students/images/quiz.jpg') }}" width="100%" height="100%" alt="">

                            </div>
                    </a>

                            <div class="body" style="text-align: center; font-size: 20px; padding:10px">
                                {{-- {{ $item->end_time }} --}}
                                @if ($item->end_time!=null && $item->end_time>$now)
                                <input type="hidden" id="time_quize" class="time_quize" name="time" value="{{ $item->end_time }}">

                                @endif
                                @php
                                  $a=  $secondsDifference=strtotime($item->end_time)-strtotime(now());
                                $a=$a/60;
                                  $a=intval($a);
                                  $b=$a%60;
                                  $c=intval($a/60);
                                @endphp


@if ($now>$item->start_time && $now<$item->end_time)
<div class="time-left_quize"> </div>

@if($item->type_file!='1')

<a href=".uploadQuizeModal" class=" btn btn-success yy" data-toggle="modal" id="uploadQuizeModal"
data-id="{{ $item->id }}"><i class="material-icons" data-toggle="tooltip"></i>Upload</a>
@endif
@else


<span class="label bg-red">انتهى</span>

@endif


                            </div>
                        </div>


                    </div>
                    @endif
                        @endforeach


                </div>

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                الحلول السابقة
                                </h2>

                            </div>
                            <div class="body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 20px; font-weight: bold"> رقم المذاكرة	</th>
                                            <th style="font-size: 20px; font-weight: bold">الملف</th>
                                            <th style="font-size: 20px; font-weight: bold">العمليات</th>

                                            {{-- --------------------------- --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < count($answers); $i++)
                                        @foreach ($answers[$i] as $item)

                                    @if ($item->type=='2')
                                    <tr id="answer_{{ $item->id }}">

                                        <td><span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">{{ $item->file_id }}</span></td>
                                        <td>

                                    <a href="{{ asset('storage/'.$item->file) }}">

                                        @if ($item->extension=="docx")
                                        <img src="{{ asset('students/images/docx.jpg') }}" width="50px" height="50px" alt="">

                                        @elseif ($item->extension=="pdf")
                                        <img src="{{ asset('students/images/pdf.png') }}" width="50px" height="50px" alt="">

                                        @else
                                            <img src="{{ asset('storage/'.$item->file) }}" width="50px" height="50px" alt="">

                                        @endif


                                    </a>


                                    </td>

                                    <td>
                                        <a id="delete_answer" data-id="{{ $item->id }}" class="btn btn-danger btn-sm delete_answer">حذف</a>
                                    </td>
                                </tr>

                                    @endif

                                        @endforeach













                                        @endfor



                                    </tbody>

                                </table>

                </div>



                        </div>
                    </div>
                </div>


            @endif

        </div>








        <div class="modal fade in uploadQuizeModal" id="" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: right">
                        <h1 class="modal-title" id="defaultModalLabel">ارفع الملف </h1>


                        <small>قم بترفيع الملف بعد الاجابة عليه
                        </small>

                    </div>
                    <div class="modal-body" style="text-align: right; direction: rtl">

                        <form method="POST" action="{{ route('dashboard.student.upload_store') }}"  enctype="multipart/form-data">


                            @csrf

                            <input type="hidden" value="{{ $lesson_id }}" name="lesson_id">
                            <input type="hidden" value="{{ $student_id }}"  name="student_id">
                            <input type="hidden" value="2" name="type">
                            <input type="hidden" value="{{ $teacher_id }}" name="teacher_id">
                            <input type="hidden" value="{{ $room_id }}" name="room_id">
                            <input type="hidden" value="{{ $term_id }}" name="term_id">




                            <label for="">المذاكرة</label>
                            <input type="hidden" id="" name="file_id" class="file_id" placeholder="test">

                            <input type="file" name="quize_file" class="" placeholder="test">



                            <br>
                            <br>
                            <button class="send btn btn-success" id="quize_btn">ارسال</button>

                        </div>

                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div> --}}
                </div>
            </div>






        {{-- <form method="POST" action="{{ route('dashboard.student.upload_store') }}"  enctype="multipart/form-data">

            <div class="modal fade uploadQuizeModal3">
                <div class="modal-dialog">
                    <div class="modal-content">



                            @csrf

                            <input type="hidden" value="{{ $lesson_id }}" name="lesson_id">
                            <input type="hidden" value="{{ $student_id }}"  name="student_id">
                            <input type="hidden" value="2" name="type">
                            <input type="hidden" value="{{ $teacher_id }}" name="teacher_id">
                            <input type="hidden" value="{{ $room_id }}" name="room_id">
                            <input type="hidden" value="{{ $term_id }}" name="term_id">



                            <div class="modal-header" style="direction: rtl">
                                <h4 class="modal-title">ارفع الملف</h4>
                                <small>قم بترفيع الملف بعد الاجابة عليه
                                </small>
                                <button style="" type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" style="direction: rtl">

                                <label for="">المذاكرة</label>
                                <input type="hidden" id="" name="file_id" class="file_id" placeholder="test">

                                <input type="file" name="quize_file" class="" placeholder="test">

                                <small style="color: red">انتبه لا يمكن تعديل الملف بعد الارسال</small>

                                <br>
                                <br>
                            </div>
            <button class="send">ارسال</button>

                        </div>
                </div>
            </div>
            </form> --}}





        <div role="tabpanel" class="tab-pane animated pulse" id="settings_animation_2">



            @if (isset($lesson_details))
                <div class="row">

                    @foreach ($lesson_details as $item)
                    @if ($item->type=='3' && $now>=$item->start_time)

                    <div class="col-md-3">

                    <div class="card">
                    <a 
                    @if($item->type_file=='1')
                    href="  {{ $item->exam }}"
                    
                    @else 
                    
                    href=" {{ asset('storage/'. $item->exam ) }}"
                    
                    @endif >
                                <span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">  {{ $item->id }}   </span>
                                 <div class="header bg-red1" style="padding:0">
                                <img src="{{ asset('students/images/exam.jpg') }}" width="100%" height="100%" alt="">

                            </div>
                        </a>

                            <div class="body" style="text-align: center; font-size: 20px; padding:10px">
                 {{-- {{ $item->end_time }} --}}
                 @if ($item->end_time!=null && $item->end_time>$now)
                 <input type="hidden" id="time_exam" class="time_exam" name="time" value="{{ $item->end_time }}">

                 @endif
                 @php
                   $a=  $secondsDifference=strtotime($item->end_time)-strtotime(now());
                 $a=$a/60;
                   $a=intval($a);
                   $b=$a%60;
                   $c=intval($a/60);
                 @endphp


@if ($now>$item->start_time && $now<$item->end_time)

<div class="time-left_exam"> </div>
@if($item->type_file!='1')
<a href=".uploadExamModal" class=" btn btn-success zz" data-toggle="modal" id="uploadExamModal"
data-id="{{ $item->id }}"><i class="material-icons" data-toggle="tooltip"></i>ارفع الملف</a>
@endif
@elseif($now>$item->start_time && $now>$item->end_time)


<span class="label bg-red">انتهى</span>
@endif


                            </div>
                        </div>


                    </div>
                    @endif

                    @endforeach


                </div>


                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                الحلول السابقة
                                </h2>

                            </div>
                            <div class="body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 20px; font-weight: bold">   رقم الامتحان	</th>
                                            <th style="font-size: 20px; font-weight: bold">الملف</th>
                                            <th style="font-size: 20px; font-weight: bold">العمليات</th>

                                            {{-- --------------------------- --}}
                                        </tr>
                                    </thead>
                                    <tbody>
            @for ($i = 0; $i < count($answers); $i++)

                    @foreach ($answers[$i] as $item)
                @if ($item->type=='3')

                <tr id="answer_{{ $item->id }}">
                    <td><span style="display: inline-block; min-width: 25px; background-color: #00f; color: #fff">{{ $item->file_id }}</span></td>

                <td >

                <a href="{{ asset('storage/'.$item->file) }}">
                    @if ($item->extension=="docx")
                    <img src="{{ asset('students/images/docx.jpg') }}" width="50px" height="50px" alt="">

                    @elseif ($item->extension=="pdf")
                    <img src="{{ asset('students/images/pdf.png') }}" width="50px" height="50px" alt="">

                    @else
                        <img src="{{ asset('storage/'.$item->file) }}" width="50px" height="50px" alt="">


                    @endif
                </a>


                </td>

                <td>


                    <a id="delete_answer" data-id="{{ $item->id }}" class="btn btn-danger btn-sm delete_answer">حذف</a>


                </td>
            </tr>

                @endif

                    @endforeach
                @endfor
                                    </tbody>

                                </table>

                </div>



                        </div>
                    </div>
                </div>




            @endif






        </div>





        <div class="modal fade in uploadExamModal" id="" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: right">
                        <h1 class="modal-title" id="defaultModalLabel">ارفع الملف </h1>


                        <small>قم بترفيع الملف بعد الاجابة عليه
                        </small>

                    </div>
                    <div class="modal-body" style="text-align: right; direction: rtl">

                        <form method="POST" action="{{ route('dashboard.student.upload_store') }}"  enctype="multipart/form-data">

                            @csrf

                            <input type="hidden" value="{{ $lesson_id }}" name="lesson_id">
                            <input type="hidden" value="{{ $student_id }}"  name="student_id">
                            <input type="hidden" value="3" name="type">
                            <input type="hidden" value="{{ $teacher_id }}" name="teacher_id">
                            <input type="hidden" value="{{ $room_id }}" name="room_id">
                            <input type="hidden" value="{{ $term_id }}" name="term_id">


                            <label for="">الامتحان</label>
                            <input type="hidden" id="" name="file_id" class="file_id" placeholder="test">

                            <input type="file" name="exam_file" class="" placeholder="test">

                            <br>
                            <br>
                            <button class="send btn btn-success" id="exam_btn">ارسال</button>

                        </div>

                        </form>

                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div> --}}
                </div>
            </div>










{{--
        <form method="POST" action="{{ route('dashboard.student.upload_store') }}"  enctype="multipart/form-data">

            <div class="modal fade uploadExamModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                            <label for="">Test</label>
                            <input type="hidden" id="" name="file_id" class="exam_id" placeholder="test">

                            <input type="file" name="exam_file" class="" placeholder="test">

                            @csrf

                            <input type="hidden" value="{{ $lesson_id }}" name="lesson_id">
                            <input type="hidden" value="{{ $student_id }}"  name="student_id">
                            <input type="hidden" value="3" name="type">
                            <input type="hidden" value="{{ $teacher_id }}" name="teacher_id">
                            <input type="hidden" value="{{ $room_id }}" name="room_id">
                            <input type="hidden" value="{{ $term_id }}" name="term_id">



                            <div class="modal-header" style="direction: rtl">
                                <h4 class="modal-title">ارفع الملف</h4>
                                <small>قم بترفيع الملف بعد الاجابة عليه
                                </small>
                                <button style="" type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" style="direction: rtl">



                                <small style="color: red">انتبه لا يمكن تعديل الملف بعد الارسال</small>

                                <br>
                                <br>
                            </div>
            <button class="send">send</button>

                        </div>
                </div>
            </div>
            </form> --}}


        <div role="tabpanel" class="tab-pane animated pulse" id="settings_animation_3">






            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                          درجات الفصل الأول
                        </h2>

                    </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الشفهي</th>
                        <th>الوظائف</th>
                        <th>النشاط</th>
                        <th>المذاكرة</th>
                        <th>الامتحان الفصلي</th>
                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    @foreach (json_decode($student_mark['mark'],true) as $key=>$value)



                    @if ($key==$lesson->id)



                    @foreach ($value as $key1=>$value1)


                    @if ($key1=='oral')
                    @if ($mark_status->oral_status!='1')
                    <td></td>
                    @elseif ($mark_status->oral_status=='1')

                        <td>{{ $value1 }}</td>


                        @endif






                    {{-- ----------------------------------- --}}


                    @elseif ($key1=='homework')

                    @if ($mark_status->homework_status!='1')
                        <td></td>
                    @elseif ($mark_status->homework_status=='1')
                        <td>{{ $value1 }}</td>


                        @endif




                        {{-- ----------------------------------- --}}

                        @elseif ($key1=='activities')

                        @if ($mark_status->activity_status!='1')
                        <td></td>
                        @elseif ($mark_status->activity_status=='1')
                            <td>{{ $value1 }} </td>
                            @endif




                    {{-- ----------------------------------- --}}


                    @elseif ($key1=='quize')

                            @if ($mark_status->quize_status!='1')
                            <td></td>
                        @elseif ($mark_status->quize_status=='1')
                            <td>{{ $value1 }}</td>

                            @endif


                    {{-- ----------------------------------- --}}

                    @elseif ($key1=='exam')

                        @if ($mark_status->exam_status!='1')
                        <td></td>
                        @elseif ($mark_status->exam_status=='1')
                            <td>{{ $value1 }}</td>

                            @endif

                            @endif





                                @endforeach




                                @endif


                                @endforeach

                            </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





{{-- -----------------------------محصلة الفصل الأول----------------------------- --}}


@if (true)


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

@if($mark_status->oral_status=='1' && $mark_status->homework_status =='1'
&& $mark_status->activity_status =='1' && $mark_status->quize_status =='1')
    <div class="card">
        <div class="header">
            <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                محصلة الفصل الأول
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>درجة اعمال	</th>
                        <th>امتحان</th>
                        <th style="font-size: 20px; font-weight: bold">محصلة الفصل الأول</th>

                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    @foreach (json_decode($student_mark['result1'],true) as $key=>$value)


                    @if ($key==$lesson->id)
                    @foreach ($value as $key1=>$value1)

                    <td> {{ $value1 }}</td>

                    @endforeach

                    @endif


                    @endforeach


                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@endif


{{-- -----------------------تفاصيل الفصل التاني---------------------------- --}}



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="card">
        <div class="header">
            <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                درجات الفصل الثاني
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الشفهي</th>
                        <th>الوظائف</th>
                        <th>النشاط</th>
                        <th>المذاكرة</th>
                        <th>الامتحان الفصلي</th>
                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>

                    <tr>

                        @foreach (json_decode($student_mark['mark2'],true) as $key=>$value)



                        @if ($key==$lesson->id)



                        @foreach ($value as $key1=>$value1)


                        @if ($key1=='oral')
                        @if ($mark_status->oral_status!='1')
                        <td></td>
                        @elseif ($mark_status->oral_status=='1')

                            <td>{{ $value1 }}</td>


                            @endif






                        {{-- ----------------------------------- --}}


                        @elseif ($key1=='homework')


                        @if ( $mark_status->homework_status!='1')
                            <td></td>
                        @elseif ($mark_status->homework_status=='1')
                            <td>{{ $value1 }}</td>


                            @endif




                            {{-- ----------------------------------- --}}

                            @elseif ($key1=='activities')

                            @if ($mark_status->activity_status!='1')
                            <td></td>
                            @elseif ($mark_status->activity_status=='1')
                                <td>{{ $value1 }} </td>
                                @endif




                        {{-- ----------------------------------- --}}


                        @elseif ($key1=='quize')

                                @if ($mark_status->quize_status!='1')
                                <td></td>
                            @elseif ($mark_status->quize_status=='1')
                                <td>{{ $value1 }}</td>

                                @endif


                        {{-- ----------------------------------- --}}

                        @elseif ($key1=='exam')

                            @if ($mark_status->exam_status!='1')
                            <td></td>
                            @elseif ($mark_status->exam_status=='1')
                                <td>{{ $value1 }}</td>

                                @endif

                                @endif





                                    @endforeach




                                    @endif


                                    @endforeach

                                </tr>






                </tbody>
            </table>
        </div>
    </div>
</div>








{{-- --------------------------------محصلة الفصل التاني-------------------------- --}}


@if (true)



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


@if($mark_status->oral_status =='1' && $mark_status->homework_status =='1'
&& $mark_status->activity_status =='1' && $mark_status->quize_status =='1')
    <div class="card">
        <div class="header">
            <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                محصلة الفصل الثاني
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>درجة اعمال	</th>
                        <th>امتحان</th>
                        <th style="font-size: 20px; font-weight: bold">محصلة الفصل التاني</th>

                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    @foreach (json_decode($student_mark['result2'],true) as $key=>$value)


                    @if ($key==$lesson->id)
                    @foreach ($value as $key1=>$value1)

                    <td> {{ $value1 }}</td>

                    @endforeach

                    @endif


                    @endforeach


                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>





@endif


{{-- --------------------------------المحصلة السنوية-------------------------- --}}

@if (true)


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

@if($mark_status->oral_status =='1'&& $mark_status->homework_status =='1'
&& $mark_status->activity_status =='1' && $mark_status->quize_status =='1')

    <div class="card">
        <div class="header">
            <h2 style="text-align: left; font-weight: bold; font-size: 24px">
                المحصلة النهائية للفصلين
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="font-size: 20px; font-weight: bold"> مجموع درجات الفصلين	</th>
                        <th style="font-size: 20px; font-weight: bold">متوسط درجات الفصلين</th>

                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    @foreach (json_decode($student_mark['result'],true) as $key=>$value)


                    @if ($key==$lesson->id)
                    @foreach ($value as $key1=>$value1)

                    <td> {{ $value1 }}</td>

                    @endforeach
                        <td>{{ $value1/2 }}</td>
                    @endif


                    @endforeach


                    </tr>


                </tbody>
            </table>
        </div>
    </div>

    @endif
</div>


















            @endif







        </div>


    </div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script>


$(document).on('click','#test_btn',function(e){

    $(this).css('display','none');
});

$(document).on('click','#quize_btn',function(e){

$(this).css('display','none');
});

$(document).on('click','#exam_btn',function(e){

$(this).css('display','none');
});


function srvTime()
{
	var xmlHttp, date;
	try {
		//FF, Opera, Safari, Chrome
		xmlHttp = new XMLHttpRequest();
	}
	catch (err1) {
		//IE
		try {
			xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
		}
		catch (err2) {
			try {
				xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			catch (err3) { err3 = "";
			}
		}
	}
	xmlHttp.open('HEAD', window.location.href, false);
	xmlHttp.setRequestHeader("Content-Type", "text/html");
	xmlHttp.send('');

date = new Date(xmlHttp.getResponseHeader('Date'));
return new Date(date.getTime() + (date.getTimezoneOffset() / 60));
}

//الزمن الحقيقي من السيرفر في سوريا
var x = srvTime();






$(document).ready(function () {



    $('.xx').on('click',function(){

       $('.file_id').val($(this).data('id'));

    });



    $('.yy').on('click',function(){


    $('.file_id').val($(this).data('id'));
    });

    $('.zz').on('click',function(){


$('.file_id').val($(this).data('id'));

});






$(document).on('click','.delete_answer',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.student.delete_answer2') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,
    },
    success:function(data){
$(`#answer_${id}`).remove();
swal({
  title: "Good job!",
  text: "! تمت العملية بنجاح ",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

})


});








});

</script>



<script>








var time=document.getElementsByClassName('time');
var i;
if (time.length!=0) {
    setInterval(function(){

 i=0;
 m(i);

function m(i){

    var time=document.getElementsByClassName('time');

var length=time.length;
console.log('i='+i);
time=time[i].value;

console.log('value='+time);

var countDownDate = new Date(time).getTime();



    if (i<length) {
var x = srvTime();

// var now = new Date().getTime();
var now=x.getTime();
var distance = countDownDate - now;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
//           document.getElementsByClassName("time-left")[i].innerHTML =`<i class="glyphicon glyphicon-time
// "></i> `+ days + "d " + hours + "h "
//           + minutes + "m " + seconds + "s ";
$('.time-left')[i].innerHTML=`<i class="glyphicon glyphicon-time
"></i> `+ days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

if (distance < 0) {
clearInterval(x);
$('.buy-btn').removeAttr('data-target');
$('.buy-btn').addClass('end');
document.getElementsByClassName("time-left")[i].style.marginLeft="170px";
// document.getElementById("xxx").style.display="none";
// document.getElementsByClassName("time-left")[0].innerHTML = "<i class='ti-face-sad' style='color: #961b1e;'></i>العرض انتهى ";
}
i++;




}

if (i<length) {
    m(i);

}


}




    },1000)




}






// -------------------------------------------------


var time_quize=document.getElementsByClassName('time_quize');
var j;
if (time_quize.length!=0) {
    setInterval(function(){

 j=0;
 n(j);

function n(j){

    var time_quize=document.getElementsByClassName('time_quize');

var length=time_quize.length;
console.log('j='+j);
time_quize=time_quize[j].value;

console.log('value='+time);

var countDownDate = new Date(time_quize).getTime();



    if (j<length) {

var now = new Date().getTime();

var distance = countDownDate - now;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
//           document.getElementsByClassName("time-left")[i].innerHTML =`<i class="glyphicon glyphicon-time
// "></i> `+ days + "d " + hours + "h "
//           + minutes + "m " + seconds + "s ";
$('.time-left_quize')[j].innerHTML=`<i class="glyphicon glyphicon-time
"></i> `+ days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

if (distance < 0) {
clearInterval(x);
$('.buy-btn').removeAttr('data-target');
$('.buy-btn').addClass('end');
document.getElementsByClassName("time-left_quize")[j].style.marginLeft="170px";
// document.getElementById("xxx").style.display="none";
// document.getElementsByClassName("time-left")[0].innerHTML = "<i class='ti-face-sad' style='color: #961b1e;'></i>العرض انتهى ";
}
j++;




}

if (j<length) {
    n(j);

}


}




    },1000)




}




// -------------------------------------------------





var time_exam=document.getElementsByClassName('time_exam');
var k;
if (time_exam.length!=0) {
    setInterval(function(){

 k=0;
 o(k);

function o(k){

    var time_exam=document.getElementsByClassName('time_exam');

var length=time_exam.length;
console.log('k='+k);
time_exam=time_exam[k].value;

console.log('value='+time_exam);

var countDownDate = new Date(time_exam).getTime();



    if (k<length) {

var now = new Date().getTime();

var distance = countDownDate - now;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
//           document.getElementsByClassName("time-left")[i].innerHTML =`<i class="glyphicon glyphicon-time
// "></i> `+ days + "d " + hours + "h "
//           + minutes + "m " + seconds + "s ";
$('.time-left_exam')[k].innerHTML=`<i class="glyphicon glyphicon-time
"></i> `+ days + "d " + hours + "h "
+ minutes + "m " + seconds + "s ";

if (distance < 0) {
clearInterval(x);
$('.buy-btn').removeAttr('data-target');
$('.buy-btn').addClass('end');
document.getElementsByClassName("time-left_exam")[k].style.marginLeft="170px";
// document.getElementById("xxx").style.display="none";
// document.getElementsByClassName("time-left")[0].innerHTML = "<i class='ti-face-sad' style='color: #961b1e;'></i>العرض انتهى ";
}
k++;




}

if (k<length) {
    o(k);

}


}




    },1000)




}











// ==============================================






    </script>



@endsection
