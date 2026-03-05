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


    </style>
</head>

 
@section('content')







<h1 style="text-align: center"> ارسال رسالة</h1>





<div class=" col-md-12 col-sm-12 col-xs-12" >
<input type="hidden" name="supervisor_id" id="supervisor_id" value="{{ $supervisor->id }}">

  <form action="{{ route('dashboard.supervisor.send_message',$teacher->id) }}" method="post">
    @csrf
<textarea name="message" id="" style="direction: rtl;font-size: 20px" class="form-control" cols="30" rows="5"></textarea>

<br>


<button class="btn btn-success">ارسال</button>
  </form>
</div>







<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>




@endsection
