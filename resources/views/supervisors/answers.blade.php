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
    <!--<h2>الاجابات</h2>-->
</div>





<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
اجابات الطلاب
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered" style="text-align:right;">
                <thead>
                    <tr>

                        <th style="font-size: 20px; text-align:right; font-weight: bold">الحل</th>
                        <th style="font-size: 20px; text-align:right; font-weight: bold"> اسم الطالب</th>
                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($answers as $answer)



                    <tr>



<td>

    <a href="{{ asset('storage/'.$answer->file) }}" target="_blank">

        @if ($answer->extension=="docx")
        <img src="{{ asset('students/images/docx.jpg') }}" width="50px" height="50px" alt="">

        @elseif ($answer->extension=="pdf")
        <img src="{{ asset('students/images/pdf.png') }}" width="50px" height="50px" alt="">
    @else 
    
         <img src="{{ asset('storage/'.$answer->file) }}" width="50px" height="50px" alt="">
        @endif
        </a>

</td>

<td>

 {{ App\Student::find($answer->student_id)->first_name  }} {{ App\Student::find($answer->student_id)->last_name  }}

<!--@foreach ($students as $student)-->
<!--@if ($answer->student_id == $student->id)-->
<!--{{ $student->first_name }} {{ $student->last_name }}-->
<!--@endif-->
<!--@endforeach-->

</td>

                    </tr>



                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>











@endsection
