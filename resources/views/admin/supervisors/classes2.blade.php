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
    </style>
</head>




@section('content')


<div class="block-header">
    <h2>الصفوف الدراسية</h2>
</div>






@foreach ($classes as $class)
<div class="col-md-3"  style="text-align: center">

    <a style="text-decoration: none; color: #019983 !important;" href="{{ route('dashboard.supervisor.class_rooms',[$class->id]) }}">
        <i class="glyphicon glyphicon-home" style="font-size:70px;!important"></i>
<br>

<span style="font-size: 40px; text-align: center; color:#019983 !important ">        {{ $class->name }}

</span>
    </a>
</div>


@endforeach












@endsection
