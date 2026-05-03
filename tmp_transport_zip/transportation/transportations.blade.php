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
        <a class="breadcrumbs__item is-active">قسم المواصلات </a>
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
            <h3 class="mb-0">جدول خطوط الباصات </h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء خط جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم </th>
                        <th scope="col" class="sort" data-sort="budget"> التكلفة السنوية </th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($bus_lines as $item)
                        <tr>


                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->name }}
                            </td>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->annual_cost }}
                            </td>

                            <td class="text-right">
                                <a href="{{ route('buses', $item->id) }}" class="btn btn-success"
                                    style="margin-left: 10px">الباصات</a>

                                @can('update_class')

                                 <a href=".editClassModal" class="btn btn-secondary edit"
                                        data-name="{{ $item->name }}"
                                        data-annual_cost="{{ $item->annual_cost }}"

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
                    {{ $bus_lines->links() }}
                </div>
            </div>
        </div>


    </div>



    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('bus_lines_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة خط</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label>الاسم </label>
                            <input type="text" name="name" class="form-control" value="" style="direction: rtl"
                                placeholder="مثال :برامكة" maxlength="20" required>
                        </div>



                        <div class="form-group" style="text-align:right">
                            <label>التكلفة السنوية</label>
                            <input type="number" name="annual_cost" class="form-control" value=""
                                style="direction: rtl" maxlength="20" required>
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
                <form id="form_update" method="POST" action="{{ route('bus_lines_update') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الخط</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                         <input type="hidden" name="id" id="bus_line_id">
                        <div class="form-group" style="text-align:right">
                            <label>اسم </label>
                            <input type="text" name="class_name" class="form-control" required
                                        value="" style="direction: rtl" id="name"
                                        placeholder="مثال :برامكة" maxlength="20" >
                        </div>




                        <div class="form-group" style="text-align:right">
                            <label> التكلفة السنوية </label>
                             <input type="number" name="annual_cost" id="annual_cost" class="form-control"
                                        value=""
                                        placeholder="" maxlength="20" >
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
        $(document).ready(function() {
    $('.edit').click(function() {
        var bus_line_id = $(this).data('id');
        var name = $(this).data('name');
        var annual_cost = $(this).data('annual_cost');

          $.each($('.classCost10'), function (index, val) {
           $(this).val('');


          })
          $.each(classCost, function (index, val) {
           $(`.modal-body #${val.country_id}`).val(val.cost);


          })

        // Assign values to modal form fields
        $('.modal-body #id').val(id);
        $('.modal-body #name').val(name);
        $('.modal-body #annual_cost').val(annual_cost);

    });
});
    </script>
@endsection
