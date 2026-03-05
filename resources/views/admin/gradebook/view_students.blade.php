@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
    th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }
</style>

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item ">قسم الطلاب </a>
    <a href="{{ route('admin.gradebook.view_rooms_student', $room->class_id) }}" class="breadcrumbs__item ">قسم الشعب  </a>
    <a href="{{ route('admin.gradebook.view_classes_student') }}" class="breadcrumbs__item ">دفتر العلامات - حسب الطالب  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>
@endsection

@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
            <div class="card-header border-0">
              <h3 class="mb-0" style="text-align: center;color: #001586">جدول الطلاب</h3>
              <br>
            </div>
    <div class="table-responsive">

              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">اسم الطالب</th>
                    <th scope="col" class="sort" data-sort="status">الشعبة</th>
                    <th scope="col" class="sort" data-sort="status">الصف</th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>
                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($students as $item)

               <tr>

                    <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->first_name}} {{$item->last_name}}
                    </td>

                  <td class="budget">
                  {{$room->name}}
                  </td>

                  <td class="budget">
                  {{$room->classes->name}}
                  </td>

                    <td class="">
                      <a class="btn btn-success" href="{{ route('admin.gradebook.view_student_card', ['student_id' => $item->id])}}" style="color: white;background:  #28a745;border-color: #28a745">عرض دفتر العلامات
                        </a>
                    </td>

                  </tr>

               @endforeach

                </tbody>
              </table>

            </div>

        </div>
    </div>

@endsection
