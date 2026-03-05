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
        a{
        color:#019983 !important;
    }
            a:hover{
            color: #337AB7 !important;
            transition: all 1s ease;
            text-decoration: none !important;
        }


        .card{
            background-color: #E9E9E9 !important;
            box-shadow: none !important;
        }
    </style>
</head>


@section('content')



<head>
    <style>
        td,th,tr,table{
            border-color: #000 !important;
          direction: rtl;
          text-align: center;
          line-height: 50%
        }
    </style>
</head>


<div class="col-md-12" style="direction: rtl; text-align: right">
    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">

عناصر سابقة

</h2>


        </div>
        <div class="body table-responsive">


    <a style="color: #FFF !important; margin-bottom:10px" href="{{ route('dashboard.supervisor.send_item',['teacher_id'=>$teacher->id,'lesson_id'=>$lesson_id])}}"  class="btn bg-teal waves-effect" data-toggle="modal" data-id="${value.id}"
    ><i class="material-icons" style="color: #FFF">forum</i> ارسال عنصر جديد</a>
     <table class="table  table-bordered table-striped table-hover" style="direction: rtl; text-align: right">
        <thead style="direction: rtl; text-align: right">
          <tr>
            <th scope="col">#</th>
            <th scope="col">اسم العنصر</th>
            <th scope="col">الوصف</th>

            <th scope="col">المادة</th>
            <th scope="col">الصف</th>
            <th scope="col">المدرس</th>
            <th scope="col">العنصر</th>
            <th scope="col">العمليات</th>

          </tr>
        </thead>
        <tbody>

@php
$counter = 0;
@endphp
            @foreach ($old_items as $item)

            @php
                $counter++
            @endphp
            <tr id="item_{{ $item->id }}">

                <th >{{ $counter }}</th>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $lesson->name }}</td>
                <td>{{ $class->name }}</td>
                <td>{{ $teacher->first_name }}</td>

                <td>
<a
title="مشاهدة"
@if ($item->type_file=='0')

href="{{ $item->item_link }}"

@else

href="{{ asset('storage/'.$item->item_storage) }}"

@endif

target="_blank"
>

    <!--<img src="https://picsum.photos/200" width="100px" height="100px" alt="">-->


        <i class="material-icons" style="color: #019983;font-size: 50px">visibility
        </i>
        
</a>

                </td>

                <td>


                    <button title="حذف" class="  btn-open-modal four" data-id="{{ $item->id }}"  data-toggle="modal" data-target="#modal-fullscreen-xs-down4">
                        <i class="material-icons" style="color: red;font-size: 40px">delete</i>
                        </button>

                        <a href="{{ route('dashboard.supervisor.edit_item',$item->id) }}" title="تعديل">
                            <i class="material-icons" style="color: #019983;font-size: 40px">edit</i>
                        </a>
                </td>

              </tr>


            @endforeach


        </tbody>
      </table>

    </div>
</div>
</div>



<div class="modal fade modal-fullscreen-xs-down alert_four" id="modal-fullscreen-xs-down4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
          <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
          <button type="button " class="btn btn-primary confirm4">نعم , موافق</button>
        </div>
      </div>
    </div>
  </div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script>

$('.alert_four').hide();


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
    url:"{{ route('dashboard.supervisor.delete_item') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#item_${id}`).remove();
        $(".modal").modal('hide');

$('.alert_four').hide();

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


</script>

@endsection
