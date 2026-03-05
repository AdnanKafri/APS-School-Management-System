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
        <a class="breadcrumbs__item is-active">قسم الباصات </a>
        <a href="{{ route('transportations') }}" class="breadcrumbs__item ">قسم المواصلات </a>
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
            <h3 class="mb-0">جدول  الباصات </h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء باص جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget">  رقم الباص  </th>
                        <th scope="col" class="sort" data-sort="budget"> عدد الطلاب </th>
                        <th scope="col" class="sort" data-sort="budget">  الخط التابع له </th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($buses as $item)
                        <tr>


                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->name }}
                            </td>
                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->students_count }}
                            </td>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->bus_lines->name }}
                            </td>

                            <td class="text-right">
                                <a href="{{ route('bus_students', $item->id) }}" class="btn btn-success"
                                    style="margin-left: 10px">الطلاب</a>

                                @can('update_class')

                                 <a href=".editClassModal" class="btn btn-secondary edit"
                                        data-name="{{ $item->name }}"
                                         data-students_count="{{ $item->students_count }}"
                                         data-bus_lines_id="{{ $item->bus_lines_id }}"
                                            
                                         data-id="{{ $item->id }}"
                                  data-toggle="modal" style="color: white">
                                        تعديل </a>


                                @endcan


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
                    {{ $buses->links() }}
                </div>
            </div>
        </div>


    </div>



    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('buses_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bus_lines_id"  value="{{ $id }}">

                    <div class="modal-header">
                        <h4 class="modal-title">اضافة باص</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label> رقم الباص  </label>
                            <input type="text" name="name" class="form-control" value="" style="direction: rtl"
                                placeholder="مثال :باص رقم 541" maxlength="20" required>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>عدد الطلاب </label>
                            <input type="number" name="students_count" class="form-control" value="" style="direction: rtl"
                                placeholder="مثال :  20" maxlength="20" required>
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



    <div class="modal fade editClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_update" method="POST" action="{{ route('buses_update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bus_lines_id" id="bus_lines_id" value="{{ $id }}">

                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الباص</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                         <input type="hidden" name="id" id="id">
                        <div class="form-group" style="text-align:right">
                            <label> رقم الباص  </label>
                            <input type="text" name="name" class="form-control" required
                                        value="" style="direction: rtl" id="name"
                                        placeholder="مثال :547" maxlength="20" >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>عدد الطلاب  </label>
                            <input type="number" name="students_count" class="form-control" required
                                        value="" style="direction: rtl" id="students_count"
                                        placeholder="مثال :20" maxlength="20" >
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

    <script>
 
    $('.edit').click(function() {
        var bus_id = $(this).data('id');
        var name = $(this).data('name');
        var students_count = $(this).data('students_count');
        var bus_line_id = $(this).data('bus_lines_id');

 

        // Assign values to modal form fields
        $('.modal-body #id').val(bus_id);
        $('.modal-body #name').val(name);
        $('.modal-body #students_count').val(students_count);
        $('.modal-body #bus_lines_id').val(bus_lines_id);

 
});
    </script>
@endsection
