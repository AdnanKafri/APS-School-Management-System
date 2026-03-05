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


@section('info')
<div class="user-info">
    <div class="image">
        <img src="{{ asset('storage/'.$student->image) }}" width="48" height="48" alt="User" />
    </div>
    <div class="info-container">
        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $student->first_name }} {{ $student->last_name }}</div>
        <div class="email">{{ $student->email }}</div>
        <div class="btn-group user-helper-dropdown">
            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
            <ul class="dropdown-menu pull-right">
                <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
            </ul>
        </div>
    </div>
</div>
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



        <div class="block-header">
            <h2 style="text-align: center; font-weight: bold; font-size: 26px">
                المواد الدراسية
            </h2>
            </div>

        <!-- Widgets -->
        <div class="row clearfix" style="direction:rtl">



  @foreach ($lessons as $lesson)

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('dashboard.student.lessons.details', ['lesson_id' => $lesson->id,'student_id' =>$student->id]) }}" style="cursor: pointer; text-decoration:none">

        <div class="info-box-2 hover-zoom-effect" style="background-color:#019983; direction:rtl;">
            <div class="icon">
                <i class="material-icons">email</i>
            </div>
            <div class="content">
                <div class="text"><h5 style="color:#FFF">{{ $lesson->name }}</h5></div>
                <!--<div class="number"><small style="font-size: 13px">{{ $lesson->teachers[0]->first_name }}</small></div>-->
            </div>
        </div>
    </a>

    </div>


  @endforeach

        </div>
        <!-- #END# Widgets -->
        <!-- CPU Usage -->

        <!-- #END# CPU Usage -->

        <div id="real_time_chart" class="dashboard-flot-chart" style="height: 0.1px; visibility: hidden;"></div>








@endsection
