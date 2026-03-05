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
                                        data-first_payment="{{ $item->first_payment }}"
                                        data-first_payment_date="{{ $item->first_payment_date }}"
                                        data-second_payment="{{ $item->second_payment }}"
                                        data-second_payment_date="{{ $item->second_payment_date }}"
                                        data-third_payment="{{ $item->third_payment }}"
                                        data-third_payment_date="{{ $item->third_payment_date }}"
 
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
                                        <input type="hidden" id="id" name="id"/>

           <div class="form-group" style="text-align:right">
                            <label>اسم </label>
                            <input type="text" name="name" class="form-control" required
                                        value="" style="direction: rtl" id="name"
                                        placeholder="مثال :برامكة" maxlength="20" >
                        </div>




                        <div class="form-group" style="text-align:right">
                            <label> التكلفة السنوية </label>
                             <input type="number" name="annual_cost" id="annual_cost" class="form-control"
                                        value=""
                                        placeholder="" maxlength="20" >
                        </div>
                    <!-- New Row 1 -->
         <div class="form-group row" style="text-align:right">
                        <div class="col-md-6">
                            <label> الدفعة الأولى</label>
                            <input type="text" id="first_payment" name="first_payment" class="form-control" style="direction: rtl" placeholder="الدفعة الأولى"  >
                        </div>
                        <div class="col-md-6">
                                                        <label> &nbsp;    </label>

                             <input type="date" id="first_payment_date" name="first_payment_date" class="form-control" style="direction: rtl"   >
                        </div>
                    </div>
                    <!-- New Row 2 -->
                    <div class="form-group row" style="text-align:right">
                        <div class="col-md-6">
                            <label>الدفعة الثانية</label>
                            <input type="text" id="second_payment" name="second_payment" class="form-control" style="direction: rtl" placeholder=" الدفعة الثانية"  >
                        </div>
                        <div class="col-md-6">
                            <label>  &nbsp;   </label>

                             <input type="date" id="second_payment_date" name="second_payment_date" class="form-control" style="direction: rtl"  >
                        </div>
                    </div>
                    <!-- New Row 3 -->
                    <div class="form-group row" style="text-align:right">
                        <div class="col-md-6">
                            <label>الدفعة الثالثة  </label>
                            <input type="text" id="third_payment" name="third_payment" class="form-control" style="direction: rtl" placeholder="الدفعة الثالثة"  >
                        </div>
                        <div class="col-md-6">
                            <label> &nbsp;  </label>
                            <input type="date" id="third_payment_date" name="third_payment_date" class="form-control" style="direction: rtl"  >
                        </div>
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
        var first_payment = $(this).data('first_payment');
        var first_payment_date = $(this).data('first_payment_date');
        var second_payment = $(this).data('second_payment');
        var second_payment_date = $(this).data('second_payment_date');
        var third_payment = $(this).data('third_payment');
        var third_payment_date = $(this).data('third_payment_date');

 

        // Assign values to modal form fields
        $('.modal-body #id').val(bus_line_id);
        $('.modal-body #name').val(name);
        $('.modal-body #annual_cost').val(annual_cost);
        $('.modal-body #first_payment').val(first_payment);
        $('.modal-body #first_payment_date').val(first_payment_date);
        $('.modal-body #second_payment').val(second_payment);
        $('.modal-body #second_payment_date').val(second_payment_date);
        $('.modal-body #third_payment').val(third_payment);
        $('.modal-body #third_payment_date').val(third_payment_date);

    });
});
    </script>
@endsection
