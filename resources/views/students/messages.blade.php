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





@foreach ($messages as $item)




<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">









    <div class="card">
        <div class="header">
            <h2>
                {{ $item->created_at->format('d-m-Y') }} <small></small>
            </h2>

        </div>
        <div class="body">

{{ $item->message }}

        </div>
    </div>
</div>



@endforeach













@endsection
