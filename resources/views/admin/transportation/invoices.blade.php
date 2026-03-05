@extends('admin.master')
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

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
        
            .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }

        .section2_btn {
    border-radius: 35px;
    padding: 10px 12px;
    width: 100%;
    height: 52px;
    color: #fff;
    font-size: 16px;
    margin-bottom: 42px;
    -webkit-transition: all 0.5s;
    -o-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -moz-transition: all 0.5s;
    transition: all 0.5s
}
        .btn22 {
    background: transparent;
    border: 2px solid #4285f4;
    color: #4285f4
}

.btn22:hover {
    background: #4285f4;
    color: #fff
}
.select2-selection__choice{
    background: #0d376a !important;
    color: #ddd !important;
}

    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">الفواتير    </a>
        <a href="{{ route('students_financial_transport') }}" class="breadcrumbs__item ">قسم الاقساط المالية مواصلات </a>
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


<div class="card-header border-0" style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="mb-0">
        فواتير الطالب   
        {{$student->first_name}}
        {{$student->last_name}}
        
        
        @if($remain_invoices!=0)

            <a href=".financialaccountModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">  اضافة فاتورة</i></a>

@endif
    </h3>
    <h2>
     
        المبلغ المتبقي 
        :
        {{$remain_invoices}}
        
    </h2>
</div>

        <div class="table-responsive">
        
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> قيمة الفاتورة </th>

                        <th scope="col" class="sort" data-sort="budget">رقم الفاتورة </th>
                        <th scope="col" class="sort" data-sort="budget"> تاريخ الدفع </th>
                        <th scope="col" class="sort" data-sort="budget"> الخط </th>
                  

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($invoices as $item)
                        <tr>

                            <td class="budget" style="font-weight:bold;font-size:15px">
                                {{ $item->invoice_amount }}
                            </td>

                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->invoice_number }}
                            </td>
                            <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->created_at }}
                            </td>
                            
                                       <td class="budget"style="font-weight:bold;font-size:15px">
                                {{ $item->student->bus->bus_lines->name }}
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
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}

 





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



            <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('bus_students_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                             <div class="modal-header">
                                <h4 class="modal-title">اضافة طلاب</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">

 
                                <div class="row d-flex justify-content-center mt-100">
                                    <label>اختيار طلاب</label>

                                    <div class="col-md-12">
                                         <select  name="student_ids[]" id="choices-multiple-remove-button" class="form-control permissions" placeholder="Select up to 3 tags" multiple>

                                 
                                        </select>
                                  </div>
                                </div>





                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-info">حفظ</button>
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
                        <h4 class="modal-title">إزالة طالب من الباص</h4>
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
                <form id="form_delete" action="{{ route('bus_students_delete') }}" method="POST" autocomplete="off">

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




<div class="modal fade financialaccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('transport_invoice_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title">الحساب المالي &nbsp; <span class="student_name"
                            style="font-weight: bold; font-size: 20px"></span></h4>

 

                    <button type="button" class="close" style="margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
<input type="hidden" name="student_id" value="{{$student->id}}"/>
<input type="hidden" name="bus_line_id" value="{{$student->bus->bus_lines->id}}"/>

                </div>
                <div class="modal-body">


                    <input type="hidden" name="student_id" value="{{$student->id}}">
 
                    <div class="row" style="text-align: center">
                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 18px; " class="text-primary">الكامل</label>

                        </div>

                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 18px; " class="text-success"> المدفوع</label>
                        </div>
                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 16px; " class="text-warning"> المتبقي</label>

                        </div>
                    </div>

                    <div class="row" style="text-align: center">
                        <div class="col-4">
                            <label style="padding: 20px;font-size: 20px" id="full_account"
                                class="badge badge-primary">{{$student->bus->bus_lines->annual_cost}}</label>
                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-success"
                                id="amount_paid">{{$student->bus->bus_lines->annual_cost - $remain_invoices}}</label>

                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-warning"
                                id="remaining_account">{{$remain_invoices}}/</label>

                        </div>
                    </div>

                    <br>

@if($remain_invoices!=0)
                    <button type="button" class="btn btn-primary btn-block add_reciept" data-toggle="collapse"
                        data-target="#demo"> اضافة فاتورة</button>
                        @endif
                    <div id="demo" class="collapse">

                        <br>

                        <div class="form-group" style="text-align:right">
                            <label>رقم الفاتورة</label>
                            <input type="text" name="invoice_number" class="form-control b" value="" maxlength="20">
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>المبلغ المدفوع</label>
                            <input type="number" name="invoice_amount" class="form-control" id="invoice_amount"
                                value="">
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                            <button class="btn btn-info">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


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

    $(document).ready(function(){

var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
removeItemButton: true,
maxItemCount:200,
searchResultLimit:50,
renderChoiceLimit:50
});



});

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
