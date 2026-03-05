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










<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="mydiv" style="direction: rtl;">

    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
الطلاب
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr >
                        <th style=" text-align: right"> الاسم</th>
                        <th style=" text-align: right">الكنية</th>
                        <th style=" text-align: right">اسم الأب</th>
                        <th style=" text-align: right">الهاتف</th>
                        <th style=" text-align: right">الصف</th>
                        <th style=" text-align: right">الشعبة</th>
                        <th style=" text-align: right"> النتائج</th>


                        {{-- --------------------------- --}}
                    </tr>
                </thead>
                <tbody>


                    @foreach ($students as $item)
                    <tr>

                    <td> {{ $item->first_name }} </td>
                    <td> {{ $item->last_name }}  </td>
                    <td> {{ $item->father_name }} </td>
                    <td> {{ $item->phone }} </td>
                    <td>{{ $item->room[0]->classes->name }} </td>
                    <td>{{ $item->room[0]->name }} </td>

                    <td>
                         <a style="cursor: pointer; color: #fff; direction:ltr;text-decoration:none;font-size:23px"
                        title=" النتائج" target="_blank" href="{{ route('dashboard.supervisor.student_results',$item->id) }}" class="glyphicon glyphicon-arrow-left"></a>

                    </td>
                    </tr>

                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
