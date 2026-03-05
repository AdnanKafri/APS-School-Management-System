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

@section('training')
{{ route('dashboard.supervisor.teachers2',$supervisor->id) }}
@endsection


<head>
    <style>
        a{
        color:#019983 !important;
    }
            a:hover{
            color: #337AB7 !important;
            transition: all 1s ease;
            text-decoration: none !important;
        }


    </style>
</head>


@section('content')







<h1 style="text-align: center"> ارسال عنصر</h1>





<div class=" col-md-12 col-sm-12 col-xs-12" >





    <form action="{{ route('dashboard.supervisor.update_item') }} " method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction: rtl">


<input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="card" style="direction: rtl; text-align: right">
                <div class="header" style=" padding: 5px 20px 5px 20px;">

                    {{-- <h4 style="direction: rtl; text-align: right"> المادة:  {{ $lesson->name }}</h4>

                    <h5 style="direction: rtl; text-align: right"> المدرس: {{ $teacher->first_name }} {{ $teacher->last_name }}</h5> --}}


                    @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible" role="alert" style="text-align: right; font-size: 30px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session()->get('warning') }}
                        </div>
                    @endif
                </div>
                <div class="body" style="    padding: 0px 20px 0px 20px;">

                    <div class="row clearfix">
                        <div class="col-sm-12">


                <br>
<input type="hidden" name="teacher_id" id="teacher_id" value="{{ $item->teacher_id }}">
<input type="hidden" name="lesson_id" id="lesson_id" value="{{ $item->lesson_id }}">

<label style="font-size:18px">  اسم العنصر</label>
<input type="text" name="title" value="{{ $item->title }}" class="form-control" placeholder="ادخل عنوان العنصر">

<br>

<label style="font-size:18px">  الوصف</label>
<input type="text" name="description" value="{{ $item->description }}" class="form-control" placeholder="أدخل وصف العنصر">

<br>
                    <label for="" style="font-size:18px;font-size:16px; text-align:center">اختيار نوع النشاط</label>
                    <br>
                    <select name="type" style="width:100%;height: 40px; font-size:16px; text-align:center" id="input_type" required>
                        <option value="">-- يرجى الاختيار --</option>
                        <option value="0" {{ ($item->type == '0' )? "selected" :'' }}> صورة</option>

                        <option value="1" {{ $item->type == '1' ? "selected"  : ""}}>مقطع فيديو</option>
                        <option value="2" {{ $item->type == '2' ? "selected" : ""}}>مقطع صوت</option>
                        <option value="3" {{ $item->type == '3' ? "selected" : "" }}> ملف</option>

                        <option value="4" {{ $item->type == '4' ? "selected" : "" }}> رابط خارجي</option>



                    </select>

<br>
<input type="hidden" value="{{ $item->type }}" id="check_type">

<div class="form-group0 input" style="margin-top: 10px;" id="image"  >
    <div class="">


                <label style="font-size:18px"> تحميل الصورة  </label>
                <img src="{{ asset('storage/'.$item->item_storage) }}" width="100px" height="100px" alt="">

                <input type="file" name="image_in" id="image_in" class="form-control">

    </div>
</div>


                <div class="form-group1 input" style="margin-top: 10px;" id="video"  >
                    <div class="">
                                <label style="font-size:18px">رابط  الفيديو</label>
                        <input type="text" id="a" name="video" value="{{ $item->item_link }}"  class="form-control" placeholder="Enter Youtube link">

                    <br>


                                <label style="font-size:18px">او تحميل الفيديو  </label>
                                @if ($item->type_file=='1')
                                يوجد فيديو مخزّن
                                @endif
                                <input type="file" name="video_in" id="video_in" class="form-control">


                    </div>
                </div>



                <div class="form-group2 input" style="margin-top: 10px;" id="video"  >
                    <div class="">
                                <label style="font-size:18px">رابط  الصوت</label>
                        <input type="text" id="b" name="audio" value="{{ $item->item_link }}"  class="form-control" placeholder="Enter voice link">

                    <br>

                                <label style="font-size:18px">او تحميل الصوت  </label>
                                @if ($item->type_file=='1')
                                يوجد مقطع صوت مخزّن
                                @endif
                                <input type="file" name="audio_in" id="audio_in" class="form-control">


                    </div>
                </div>



                <div class="form-group3 input" style="margin-top: 10px;" id="file"  >
                    <div class="">
                                <label style="font-size:18px">رابط  الملف</label>
                        <input type="text" id="c" name="file"  value="{{ $item->item_link }}" class="form-control" placeholder="Enter file link">

                    <br>

                                <label style="font-size:18px">او تحميل الملف  </label>
                                @if ($item->type_file=='1')
                                يوجد  ملف مخزّن
                                @endif
                                <input type="file" name="file_in" id="file_in" class="form-control">


                    </div>
                </div>

                <div class="form-group4 input" style="margin-top: 10px;" id="link"  >
                    <div class="">
                                <label style="font-size:18px">  الرابط</label>
                        <input type="text" id="d" name="link" value="{{ $item->item_link }}"  class="form-control" placeholder="Enter link">


                    </div>
                </div>


                <br> <br>
                            <button class="btn btn-success btn-lg" style="background-color:#019983 !important">ارسال</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>



    </form>













</div>







<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>


<script>
    $(document).ready(function () {
    $("button.dropdown-toggle" ).remove();


$('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').hide();


if($('#check_type').val()=='0') {

    $('.form-group0').show();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').hide();

$('#a').val('');
$('#b').val('');
$('#c').val('');
$('#d').val('');

}

if($('#check_type').val()=='1') {

    $('.form-group0').hide();
$('.form-group1').show();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').hide();
$('#b').val('');
$('#c').val('');
$('#d').val('');

}

if($('#check_type').val()=='2') {


    $('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').show();
$('.form-group3').hide();
$('.form-group4').hide();

$('#a').val('');
 $('#c').val('');

$('#d').val('');
}

if($('#check_type').val()=='3') {
    $('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').show();
$('.form-group4').hide();
$('#a').val('');
$('#b').val('');
 $('#d').val('');

}

if($('#check_type').val()=='4') {


    $('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').show();
$('#a').val('');
$('#b').val('');
$('#c').val('');

}


    $('#input_type').on('change',function(){

        $('#a').val('');
$('#b').val('');
$('#c').val('');
$('#d').val('');
        if ($(this).val()=='0') {

$('.form-group0').show();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').hide();
        }


        if ($(this).val()=='1') {

$('.form-group0').hide();
$('.form-group1').show();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').hide();



}

if ($(this).val()=='2') {

$('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').show();
$('.form-group3').hide();
$('.form-group4').hide();
}

if ($(this).val()=='3') {

$('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').show();
$('.form-group4').hide();
}


if ($(this).val()=='4') {

$('.form-group0').hide();
$('.form-group1').hide();
$('.form-group2').hide();
$('.form-group3').hide();
$('.form-group4').show();
}


    });
    });
</script>

@endsection
