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
        <a class="breadcrumbs__item is-active">قسم سائقين الباصات</a>
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
            <h3 class="mb-0">جدول سائقي الباصات</h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء سائق  جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم </th>

                        <th scope="col" class="sort" data-sort="budget"> العنوان </th>
                        <th scope="col" class="sort" data-sort="budget"> الهاتف </th>
                        <th scope="col" class="sort" data-sort="budget"> الباص </th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($bus_driver as $item)
                        <tr>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->name }}
                            </td>

                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->address }}
                            </td>
                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->phone }}
                            </td>
                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->bus->name }}
                            </td>


                            <td class="text-right">



                                 <a href=".editClassModal" class="btn btn-secondary edit"
                                        data-name="{{ $item->name }}"
                                        data-address="{{ $item->address }}"
                                        data-phone="{{ $item->phone }}"
                                        data-bus_id="{{ $item->bus_id }}"

                                         data-id="{{ $item->id }}"

                                        data-toggle="modal" style="color: white">
                                        تعديل </a>



                                    <a href=".deleteClassModal" class="delete2 btn btn-warning text-light "
                                        style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;
                      margin-right: 10px"
                                        data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-toggle="modal">
                                        {{-- <i class="fa fa-trash" style="font-size: 30px;color: #af686e"></i> --}}
                                        حذف
                                    </a>


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
                    {{ $bus_driver->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}



    {{-- $class_cost = Class_cost::whereIn('class_id', $all_classes->pluck('id'))
    ->whereIn('country_id', $countries_currencies->pluck('id'))
->get(); --}}



    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('bus_driver_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة سائق باص</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label>اسم السائق </label>
                            <input type="text" name="name" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>العنوان  </label>
                            <input type="text" name="address" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>



                        <div class="form-group" style="text-align:right">
                            <label> تحديد الباص    </label>

                            <select name="bus_id" id="" class="form-control "
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد الباص  </option>
                                @foreach ($buses as $buse)
                                    <option value="{{ $buse->id }}"> {{ $buse->name }}</option>
                                @endforeach

                            </select>
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
                <form id="form_update" method="POST" action="{{ route('bus_driver_update') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">تعديل معلومات السائق</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                         <input type="hidden" name="driver_id" id="driver_id">
                        <div class="form-group" style="text-align:right">
                            <label>الاسم  </label>
                            <input type="text" name="name" class="form-control" required
                                        value="" style="direction: rtl" id="name"
                                        placeholder=" اكتب الاسم" maxlength="20" >
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>العنوان  </label>
                             <input type="text" name="address" id="address" class="form-control"
                                        value=""
                                        placeholder="دمشق" maxlength="20" >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>الهاتف  </label>
                             <input type="text" name="phone" id="phone" class="form-control"
                                        value=""
                                        placeholder="099...." maxlength="20" >
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label> تحديد    الباص </label>

                            <select name="bus_id" id="bus_id" class="form-control "
                                style="min-height: 36px;direction: rtl" required>
                                <option value="" hidden>حدد  الباص </option>
                                @foreach ($buses as $buse)
                                    <option value="{{ $buse->id }}"> {{ $buse->name }}</option>
                                @endforeach

                            </select>
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



    <div class="modal fade deleteEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_delete" method="POST">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h4 class="modal-title">Delete element</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                        <button class="btn btn-danger">Delete</button>


                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- delete class  --}}

    <div class="modal fade deleteClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_delete" action="{{ route('bus_driver_delete') }}" method="POST" autocomplete="off">

                    @csrf
                    <input type="hidden" name="class_id_delete" id="class_id_delete" required>

                    <div class="modal-header">
                        <h4 class="modal-title" style="color: #f00">حذف سائق</h4>
                        <button type="button" class="close" style="color: #f00" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group" style="text-align:right">
                            <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                            <input type="password" style="direction:rtl" id="delete_code" name="delete_code"
                                class="form-control a" value="" placeholder="أدخل كود الحذف  " required>
                        </div>

                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                        <button class="btn btn-danger">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end delete class  --}}


    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
     $('.edit').click(function() {
        var driver_id = $(this).data('id');
        var name = $(this).data('name');
        var address = $(this).data('address');
        var phone = $(this).data('phone');
        var bus_id = $(this).data('bus_id');

     
  
        $('.modal-body #driver_id').val(driver_id);
        $('.modal-body #name').val(name);
        $('.modal-body #address').val(address);
        $('.modal-body #phone').val(phone);
        $('.modal-body #bus_id').val(bus_id);


    });
     </script>
    <script>

        $('.alert-success').hide(5000);


        $(document).ready(function() {

            $('.delete').on('click', function() {

                var id = $(this).data('id');
                var url = "{{ URL::to('SMARMANger/admin/students') }}";
                $('#form_delete').attr("action", url);

            });



            // $('.edit').on('click', function () {
            //     var id = $(this).data('id');
            //     var name=$(this).data('name');
            //     var name_en=$(this).data('name_en');
            //     var image=$(this).data('image');
            //     var annual_installment=$(this).data('annual_installment');
            //     var stage_id=$(this).data('stage_id');
            //     var report_card=$(this).data('report_card');
            //     var next_class=$(this).data('next_class');
            //     $('#class_id').val(id);
            //     $('#name').val(name);
            //     $('#name_en').val(name_en);
            //     $('#image').attr('src',`{{ asset('storage/${image}') }}`);
            //     $('#annual_installment').val(annual_installment);
            //     $('#stage_id').val(stage_id);
            //     $('#report_card').val(report_card);
            //     $('#next_class').val(next_class);
            // });



            // // Clear previous content in the div
            // $('#annual_installment_div').empty();

            // // Generate unique IDs for each input field
            // var index = 0;
            // $.each(annual_installment, function (index, installment) {
            //     var installmentElement = $(`
        //         <input type="number" name="cost" id="annual_installment_${index}" class="form-control mb-2" value="${installment}" style="direction: rtl">
        //     `);
            //     $('#annual_installment_div').append(installmentElement);
            //     index++;
            // });



            $(document).on('click', '.delete2', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#name_delete').val(name);
                $('#class_id_delete').val(id);
            });


        });
    </script>

    <script>
        var loadFile = function(event) {
            var id = event.target.id;
            var input_image = document.getElementById(id);
            var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img = input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

                output.setAttribute('style', 'display:inline');
                del_img.setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

        };


        var loadFile_edit = function(event) {
            var id = event.target.id;
            var input_image = document.getElementById(id);
            var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img = input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style', 'display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style', 'display:none');

            output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

                output.setAttribute('style', 'display:inline');
                del_img.setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

        };


        $(document).on('click', '.del_img', function() {
            $(this).nextAll('.output').attr('style', 'display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click', '.del_icon', function() {
            $(this).prevAll('.del:first').attr('disabled', false);
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });
    </script>
@endsection
