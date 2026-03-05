@extends('supervisors.layouts.app')

@section('email')
{{ $supervisor->email }}
@endsection

@section('image')
{{ asset('storage/'.$supervisor->image) }}
@endsection

@section('name')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}

@endsection
@section('my_info')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}
@endsection


@section('classes')
{{ route('dashboard.supervisor.classes',$supervisor->id) }}
@endsection

@section('classes2')
{{ route('dashboard.supervisor.classes2',$supervisor->id) }}
@endsection

@section('messages')
{{ route('dashboard.supervisor.teachers',$supervisor->id) }}
@endsection
<head>

    <style>
        a,i:hover{
            color: #337AB7 !important;
            transition: all 1s ease;
        }

        .xx{
    position: absolute !important;
    right: -20px;
    color:#019983 !important;

     border: 1px solid #019983 !important;
}
        .xx:hover{
            background-color: #019983 !important;
            color: white !important;
        }
    </style>
</head>




@section('content')


<div class="clearfix">
    <h1 style="text-align: center; font-size: 50px">{{ $lesson->name }}</h1>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <small style="display: block; direction: rtl; font-size:100%"> الصف : {{$class->name}} </small>
    <small style="display: block; direction: rtl; font-size:100%"> الشعبة : {{$room->name}} </small>

    @if ($teacher->count() != '0')

    <small style="display: block; direction: rtl; font-size:100%"> اسم المدرّس/ ة :  {{ $teacher[0]->first_name }} {{ $teacher[0]->last_name }} </small>

    <a class="btn waves-effect xx" style="background-color: transparent; width: 120px"
    href="{{ route('dashboard.supervisor.StudentsRoomLesson',[$room_id,$teacher[0]->id,$lesson->id]) }}"
   target="_blank">
   <i class="material-icons">extension</i>          <span style="font-size: 15px;"> العلامات</span></a>

@else  

    <small style="display: block; direction: rtl; font-size:100%">لا يوجد مدرس </small>


   @endif


        {{-- <a class="btn waves-effect xx" style="background-color: transparent; width: 120px"
    href=""
   target="_blank">
   <i class="material-icons">extension</i>          <span style="font-size: 15px;">  اضافة محتوى</span></a> --}}


    <!-- Nav tabs -->
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#home_animation_1" data-toggle="tab" aria-expanded="true">المحتوى العلمي</a></li>
        <li role="presentation" class=""><a href="#profile_animation_1" data-toggle="tab" aria-expanded="false">الفيديوهات</a></li>
        <li role="presentation" class=""><a href="#messages_animation_11" data-toggle="tab" aria-expanded="false">الاختبارات</a></li>
        <li role="presentation"><a href="#settings_animation_1" data-toggle="tab">المذاكرات</a></li>
        <li role="presentation"><a href="#settings_animation_2" data-toggle="tab">الامتحانات</a></li>

    </ul>


    <br>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane animated pulse active" id="home_animation_1">

            <div class="row">

@if ($lesson->book1 != null)
                <div class="col-md-3 "  style="padding:0; width:220px; margin-right:15px; margin-left:15px ">


<a href="
@if ($lesson->type_file1== '0')
{{$lesson->book1}}
@else
{{ asset('storage/'.$lesson->book1) }}
@endif


" target="_blank" style="text-decoration:none !important;">


<div class="card">
<div class="header" style="padding:0; width:220px; ">


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
                <div class="col-md-3" style="padding:0; width:220px; margin-right:15px; margin-left:15px ">

<a href="
@if ($lesson->type_file2== '0')
{{$lesson->book2}}
@else
{{ asset('storage/'.$lesson->book2) }}
@endif


" style="text-decoration:none !important;" target="_blank" width="220px" height="220px">




<div class="card">
<div class="header" style="padding:0;width:220px; ">


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
                <div class="col-md-3"  style="padding:0; width:220px; margin-right:15px; margin-left:15px ">

<a href="
@if ($lesson->type_file3== '0')
{{$lesson->book3}}
@else
{{ asset('storage/'.$lesson->book3) }}
@endif


" target="_blank" style="text-decoration:none !important;" width="220px" height="220px">




           <div class="card">
                            <div class="header" style="padding:0; width:220px;">

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
                <div class="col-md-3"style="padding:0; width:220px; margin-right:15px; margin-left:15px " >

<a href="
@if ($lesson->type_file4== '0')
{{$lesson->book4}}
@else
{{ asset('storage/'.$lesson->book4) }}
@endif


" target="_blank" style="text-decoration:none !important;" width="220px" height="220px">





           <div class="card">
                            <div class="header" style="padding:0;  width:220px;">

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

                @if (isset($additions))
                                    <div class="row">

                    @foreach ($additions as $item)
                    <div class="col-md-3" id="item1_{{$item->id}}"  style="padding:0; width:220px; margin-right:15px; margin-left:15px " >
                        <a href="  {{ asset('storage/'.$item->addition) }}">

                        <div class="card">
                            <div class="header" style="padding:0;width:220px;">

                                @if ($item->extension=="docx")
                                <img src="{{ asset('students/images/docx.jpg') }}"  style="border: 2px solid #019983" width="220px" height="220px" alt="">

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
                    @endforeach
                    </div>
                @endif







            </div>










         <div class="modal fade modal-fullscreen-xs-down alert_one" id="modal-fullscreen-xs-down1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                 </div>
                 <div class="modal-body">
                   <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button " class="btn btn-primary confirm1">Save changes</button>
                 </div>
               </div>
             </div>
           </div>


        <div role="tabpanel" class="tab-pane animated pulse" id="profile_animation_1">

            @if (isset($videos))
                <div class="row">

                    @foreach ($videos as $item)

                    <div class="col-md-4" id="item2_{{$item->id}}">
                        <a

                        @if($item->type_video=='1')

                                 href="  {{ $item->video }}"
                    @else

                         href="  {{ asset('storage/'.$item->video) }}"


                    @endif

                   target="_blank">

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

                        @endforeach


                </div>
            @endif



        </div>



         <div class="modal fade modal-fullscreen-xs-down alert_two" id="modal-fullscreen-xs-down2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                 </div>
                 <div class="modal-body">
                   <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button " class="btn btn-primary confirm2">Save changes</button>
                 </div>
               </div>
             </div>
           </div>


        <div role="tabpanel" class="tab-pane animated pulse" id="messages_animation_11">


            @if (isset($tests) && $tests->count()>0)
                <div class="row">

                    @foreach ($tests as $item)

                    <div class="col-md-4" id="item3_{{$item->id}}">
                        <a href=" {{ route('dashboard.supervisor.file_answers',
                        ['file_id' =>$item->id ,'lesson_id'=>$lesson->id,'room_id' =>$room_id]) }}  ">

                        <div class="card">
                            <div class="header bg-red1">

                                <img src="{{ asset('students/images/test.png') }}" width="100%" height="" alt="">

                            </div>

                   <div class="body" style="text-align: center; font-size: 20px">



                                  @if ($now<$item->start_time && $now<$item->end_time)

                               <small style="font-size: 12px;  text-align:left"> {{ $item->start_time }}</small>




                             <span class="label bg-green">بالانتظار</span>

                               @elseif($now>$item->start_time && $now<$item->end_time)

                                         <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-blue">جاري الاختبار</span>

                            @elseif($now>$item->start_time && $now>$item->end_time)

                                <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-red">انتهى</span>
                            @endif
                            </div>
                        </div>
                    </a>


                    </div>
                        @endforeach


                </div>
            @endif






        </div>



         <div class="modal fade modal-fullscreen-xs-down alert_three" id="modal-fullscreen-xs-down3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                 </div>
                 <div class="modal-body">
                   <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button " class="btn btn-primary confirm3">Save changes</button>
                 </div>
               </div>
             </div>
           </div>



        <div role="tabpanel" class="tab-pane animated pulse" id="settings_animation_1">

            @if (isset($quizes))
                <div class="row">

                    @foreach ($quizes as $item)

                    <div class="col-md-4" id="item4_{{$item->id}}">
     <a href="  {{ route('dashboard.supervisor.file_answers',
     ['file_id' =>$item->id ,'lesson_id'=>$lesson->id,'room_id' =>$room_id]) }}  ">

                        <div class="card">
                            <div class="header bg-red1">

                                <img src="{{ asset('students/images/quiz.jpg') }}" width="100%" height="" alt="">

                            </div>
              <div class="body" style="text-align: center; font-size: 20px">



                                  @if ($now<$item->start_time && $now<$item->end_time)

                               <small style="font-size: 12px;  text-align:left"> {{ $item->start_time }}</small>




                             <span class="label bg-green">بالانتظار</span>

                               @elseif($now>$item->start_time && $now<$item->end_time)

                                         <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-blue">جاري الاختبار</span>

                            @elseif($now>$item->start_time && $now>$item->end_time)

                                <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-red">انتهى</span>
                            @endif
                            </div>
                        </div>
                    </a>


                    </div>
                        @endforeach


                </div>
            @endif



        </div>


                 <div class="modal fade modal-fullscreen-xs-down alert_four" id="modal-fullscreen-xs-down4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                 </div>
                 <div class="modal-body">
                   <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button " class="btn btn-primary confirm4">Save changes</button>
                 </div>
               </div>
             </div>
           </div>


        <div role="tabpanel" class="tab-pane animated pulse" id="settings_animation_2">



            @if (isset($exams))
                <div class="row">

                    @foreach ($exams as $item)

                    <div class="col-md-4" id="item5_{{$item->id}}">
                     <a href=" {{ route('dashboard.supervisor.file_answers',
                     ['file_id' =>$item->id ,'lesson_id'=>$lesson->id,'room_id' =>$room_id]) }} ">

                        <div class="card">
                            <div class="header bg-red1">

                                <img src="{{ asset('students/images/exam.jpg') }}" width="100%" height="" alt="">

                            </div>
                   <div class="body" style="text-align: center; font-size: 20px">



                                  @if ($now<$item->start_time && $now<$item->end_time)

                               <small style="font-size: 12px;  text-align:left"> {{ $item->start_time }}</small>




                             <span class="label bg-green">بالانتظار</span>

                                    @elseif($now>$item->start_time && $now<$item->end_time)

                                         <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-blue">جاري الاختبار</span>

                            @elseif($now>$item->start_time && $now>$item->end_time)

                                <small style="font-size: 12px;  text-align:left"> {{ $item->end_time }}</small>


                            <span class="label bg-red">انتهى</span>
                            @endif
                            </div>
                        </div>
                    </a>


                    </div>
                        @endforeach


                </div>
            @endif



        </div>

                 <div class="modal fade modal-fullscreen-xs-down alert_five" id="modal-fullscreen-xs-down5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                 </div>
                 <div class="modal-body">
                   <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button " class="btn btn-primary confirm5">Save changes</button>
                 </div>
               </div>
             </div>
           </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script>
$('.alert_one').hide();
$('.alert_two').hide();
$('.alert_three').hide();
$('.alert_four').hide();
$('.alert_five').hide();


$(document).on('click' , '.one' , function () {
$('.alert_one').show();

var id=$(this).data('id');

$('.confirm1').data('id',id);



        });




        $(document).on('click' , '.cancel1' , function () {
$('.alert_one').hide();
        });


$(document).on('click','.confirm1',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.addition.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#addition_${id}`).remove();
$(`#item1_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_one').hide();

$('#success2').show();

document.getElementById('success2').innerText="Deleted Successfully !";

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

})


});

//  --------------------





$(document).on('click' , '.two' , function (e) {
    e.preventDefault();

$('.alert_two').show();

var id=$(this).data('id');

$('.confirm2').data('id',id);



        });




        $(document).on('click' , '.cancel2' , function () {
$('.alert_two').hide();
        });


$(document).on('click','.confirm2',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.addition.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#video_${id}`).remove();
$(`#item2_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_two').hide();

$('#success2').show();

document.getElementById('success2').innerText="Deleted Successfully !";

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

})


});

// --------------------------------

$(document).on('click' , '.three' , function (e) {
    e.preventDefault();

$('.alert_three').show();

var id=$(this).data('id');

$('.confirm3').data('id',id);



        });




        $(document).on('click' , '.cancel3' , function () {
$('.alert_three').hide();
        });


$(document).on('click','.confirm3',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.addition.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#test_${id}`).remove();
$(`#item3_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_three').hide();

$('#success2').show();

document.getElementById('success2').innerText="Deleted Successfully !";

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

})


});


// -------------------

$(document).on('click' , '.four' , function (e) {
    e.preventDefault();

$('.alert_four').show();

var id=$(this).data('id');

$('.confirm4').data('id',id);



        });




        $(document).on('click' , '.cancel4' , function () {
$('.alert_four').hide();
        });


$(document).on('click','.confirm4',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.addition.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#quize_${id}`).remove();
$(`#item4_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_four').hide();

$('#success2').show();

document.getElementById('success2').innerText="Deleted Successfully !";

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

})


});


// ---------------------------


$(document).on('click' , '.five' , function (e) {
    e.preventDefault();

$('.alert_five').show();

var id=$(this).data('id');

$('.confirm5').data('id',id);



        });




        $(document).on('click' , '.cancel5' , function () {
$('.alert_five').hide();
        });


$(document).on('click','.confirm5',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('dashboard.addition.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#exam_${id}`).remove();
$(`#item5_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_five').hide();

$('#success2').show();

document.getElementById('success2').innerText="Deleted Successfully !";

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

})


});

</script>

@endsection
