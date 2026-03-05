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







<h1 style="text-align: center">الجلاء المدرسي</h1>



@if ($student_mark!=null)




<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction: rtl">
    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
الجلاء المدرسي (المحصلات النهائية)
            </h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px;text-align: right"> مجموع الفصل الأول </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px;text-align: right"> مجموع الفصل الثاني </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px;text-align: right"> المجموع النهائي للفصلين</th>

                          {{-- <th scope="col" class="sort" data-sort="budget">Action</th> --}}
                        </tr>
                </thead>
                <tbody>

                    <tr>
                        @foreach (json_decode($student_mark->term_result,true) as $key=>$value)

                        <td style="font-weight: bold">{{round($value)  }}</td>


                        @endforeach

                        <td style="font-weight: bold">{{ round($student_mark->year_result) }}</td>

                        </tr>


                </tbody>
            </table>
        </div>
    </div>
</div>











<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="direction: rtl">
    <div class="card">
        <div class="header">
            <h2 style="text-align: right; font-weight: bold; font-size: 24px">
الدرجات التفصيلية
</h2>

        </div>
        <div class="body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="sort" data-sort="budget"  style="text-align: right">
                            اسم المادة
                        </th>
                      <th scope="col" class="sort" data-sort="budget" style="text-align: right">
                          درجة اعمال
                      </th>
                      <th scope="col" class="sort" data-sort="budget" style="text-align: right">امتحان</th>
                      <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px; text-align: right"> محصلة الفصل الأول</th>


                      <th scope="col" class="sort" data-sort="budget" style="text-align: right">
                        درجة اعمال
                    </th>
                    <th scope="col" class="sort" data-sort="budget" style="text-align: right">امتحان</th>
                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px; text-align: right"> محصلة الفصل التاني</th>

                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px; text-align: right"> مجموع درجات الفصلين</th>

                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px; text-align: right"> متوسط درجات الفصلين</th>

                      {{-- <th scope="col" class="sort" data-sort="budget">Action</th> --}}


                    </tr>
                </thead>
                <tbody>


                    @foreach ($lessons as $lesson)
                    <tr>

                  @foreach (json_decode($student_mark->result1,true) as $key=>$value)


                  @if ($key==$lesson->id)

                  <td>{{ $lesson->name }}</td>

                    @foreach ($value as $key1=>$value1)
                    @if ($key1=='term1_quizes')
                    <td>

                    {{ $value1 }}
                    </td>
                    @endif


                    @if ($key1=='term1_exam')
                    <td>

                    {{ $value1 }}
                    </td>
                    @endif


                    @if ($key1=='term1_result')
                    <td style="font-weight: bold; font-size:16px;">

                    {{ $value1 }}
                    </td>
                    @endif

                    @endforeach


                    @endif
                    @endforeach

                    @foreach (json_decode($student_mark->result2,true) as $key=>$value)
                    @if ($key==$lesson->id)

                    @foreach ($value as $key2=>$value2)
                    @if ($key2=='term2_quizes')
                    <td>

                    {{ $value2 }}
                    </td>
                    @endif


                    @if ($key2=='term2_exam')
                    <td>

                    {{ $value2 }}
                    </td>
                    @endif


                    @if ($key2=='term2_result')
                    <td style="font-weight: bold; font-size:16px;">

                    {{ $value2}}
                    </td>
                    @endif

                    @endforeach


                    @endif
                    @endforeach




                    @foreach (json_decode($student_mark->result,true) as $key=>$value)
                    @if ($key==$lesson->id)

                    @foreach ($value as $key2=>$value2)
                    @if ($key2=='year_result')
                    <td style="font-weight: bold; font-size:16px;">

                    {{ $value2 }}
                    </td>
                    @endif



                    @endforeach
                    @endif
                    @endforeach





                    @foreach (json_decode($student_mark->result,true) as $key=>$value)
                    @if ($key==$lesson->id)

                    @foreach ($value as $key2=>$value2)
                    @if ($key2=='year_result')
                    <td style="font-weight: bold; font-size:16px;">

                    {{ $value2/2 }}
                    </td>
                    @endif

                    @endforeach
                    @endif

                    @endforeach




                    </tr>

                    @endforeach


                </tr>


                </tbody>
            </table>
        </div>
    </div>
</div>












@endif





@endsection
