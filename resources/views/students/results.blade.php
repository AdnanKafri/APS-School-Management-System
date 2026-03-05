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





<h1 style="text-align: center">الجلاء المدرسي</h1>



@if ($student_mark!=null)




<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع الفصل الأول </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع الفصل الثاني </th>

                        <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> المجموع النهائي للفصلين</th>

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











<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                        <th scope="col" class="sort" data-sort="budget">
                            اسم المادة
                        </th>
                      <th scope="col" class="sort" data-sort="budget">
                          درجة اعمال
                      </th>
                      <th scope="col" class="sort" data-sort="budget">امتحان</th>
                      <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> محصلة الفصل الأول</th>


                      <th scope="col" class="sort" data-sort="budget">
                        درجة اعمال
                    </th>
                    <th scope="col" class="sort" data-sort="budget">امتحان</th>
                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> محصلة الفصل التاني</th>

                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> مجموع درجات الفصلين</th>

                    <th scope="col" class="sort" data-sort="budget" style="font-weight: bold; font-size: 16px"> متوسط درجات الفصلين</th>

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
