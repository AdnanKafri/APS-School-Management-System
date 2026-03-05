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
    <h2>المواد الدراسية</h2>
</div>


@foreach ($lessons as $lesson)

<div class="col-md-4" style="text-align: center;margin-bottom:20px;">

    <a style="color: #000" href="{{ route('dashboard.supervisor.lesson_rooms',[$class_id,$lesson->id]) }} ">
        <i class="glyphicon glyphicon-book" style=" font-size: 60px"></i>
        <br>
    <span style="font-size: 30px;">    {{ $lesson->name }}</span>
    </a>
    </div>
@endforeach







@endsection
