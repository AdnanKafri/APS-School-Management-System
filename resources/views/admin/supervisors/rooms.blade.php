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

<div class="block-header">
    <h2>الشعب الدراسية</h2>
</div>



@foreach ($rooms as $room)
<div class="col-md-3"  style="text-align: center">

<a style="color: #000" href=" {{ route('dashboard.supervisor.lessons.book_details',[$lesson_id,$room->id]) }}">
    <i class="glyphicon glyphicon-th
    " style=" font-size: 50px"></i>
    <br>
<span style="font-size: 30px;">    {{ $room->name }}</span>
</a>
</div>
@endforeach



@endsection
