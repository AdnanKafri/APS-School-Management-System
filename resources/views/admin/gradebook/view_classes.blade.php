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
    <a href="{{ route('admin.gradebook.view_classes_subject') }}" class="breadcrumbs__item ">دفتر العلامات - حسب المادة</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>
@endsection

@section('content')
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

            <div class="card-header border-0">
              <h3 class="mb-0">جدول الصفوف</h3>
            </div>

    <div class="table-responsive">

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">  اسم الصف</th>
                    <th scope="col" class="sort" data-sort="status">العام الدراسي</th>
                    <th scope="col" class="sort" data-sort="budget">  الشعب </th>
                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($classes as $item)

               <tr>

                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->name}}
                  </td>

                  <td class="budget">
                    {{$year->name}}
                    </td>

                    <td class="">
                      <a href="{{route('admin.gradebook.view_rooms',$item->id)}}" class="btn btn-success" style="margin-left: 10px">الشعب </a>
                    </td>

                  </tr>

               @endforeach

                </tbody>
              </table>

            </div>

            <div class="clearfix" style="padding-left:10px;text-align: center">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" >
                            {{ $classes->links() }}
                        </div>
                    </div>
            </div>

    </div>

@endsection
