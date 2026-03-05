@extends('admin.master')
@section('style')
    <style>
        .custom-file-label {
            display: none !important;
        }

        .custom-file-label {
            display: none;
        }

        .pagination {
            justify-content: center !important;
        }

        button.close {
            margin: 0px !important;
            padding: 0px !important;
            float: left !important;
        }

        .modal-header {
            direction: rtl;
        }
    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">قسم الافرع الادارية</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if (session()->has('success'))
    -->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--
    @endif-->



        <div class="card-header border-0">
            <h3 class="mb-0">جدول الافرع الادارية</h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء قسم فرعي جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم </th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($subDepartments as $item)
                        <tr>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->name }}
                            </td>


                            <td class="text-right">
                                <a href="{{ route('adminEmployees', $item->id) }}" class="btn btn-success"
                                    style="margin-left: 10px"> الموظفين الااداريين</a>




                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>

        <div class="clearfix" style="padding-left:10px;text-align: center">
            <div class="hint-text">Showing
                <b>{{ !request('page') ? '1' : request('page') }}</b>
                out of <b>{{ ceil($count / paginate_num) }}</b> entries
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $subDepartments->links() }}
                </div>
            </div>
        </div>


    </div>



    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('subDepartment_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="mainDepartment_id" value="{{$mainDepartment_id}}">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة قسم فرعي</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label>اسم الفرع بالعربية</label>
                            <input type="text" name="name" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>



                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection
