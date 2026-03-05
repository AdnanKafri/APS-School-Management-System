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
    <a class="breadcrumbs__item is-active">قسم الصفوف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
{{-- <div class="col" > --}}
<div class="card" style="direction:rtl; text-align:right;margin: 20px;">

    <!--@if(session()->has('success'))-->


    <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
    <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
    <!--    {{ session()->get('success') }}-->
    <!--    </div>-->

    <!--@endif-->



    <div class="card-header border-0">
        <h3 class="mb-0">جدول الصفوف</h3>
    </div>

    <div class="table-responsive">
        @can('create_class')
        <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i class="material-icons"
                data-toggle="tooltip">إنشاء صف جديد</i></a>
        @endcan

        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربية</th>
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزية</th>

                    <th scope="col" class="sort" data-sort="budget"> القسط السنوي</th>
                    <th scope="col" class="sort" data-sort="budget"> الصورة </th>
                    <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                </tr>
            </thead>
            <tbody class="list">
                @foreach ($classes as $item)

                <tr>
                    <!--    <th scope="row">-->
                    <!--    {{$item->id}}-->
                    <!--</th>-->


                    <td class="budget" style="font-weight:bold;font-size:15px">
                        {{$item->name}}
                    </td>

                    <td class="budget" style="font-weight:bold;font-size:15px">
                        {{$item->name_en}}
                    </td>

                    <td class="budget">
                        {{$item->annual_installment}}

                    </td>

                    <td>
                        @if ($item->image !=null)
                        <img src="{{ asset('storage/'.$item->image) }}" width="50px" height="50px" alt="">
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{route('classroom',$item->id)}}" class="btn btn-success"
                            style="margin-left: 10px">الشعب</a>
                        @can('update_class')
                        <a href=".editClassModal" class="btn btn-secondary edit" data-name="{{ $item->name }}"
                            data-name_en="{{ $item->name_en }}" data-image="{{$item->image}}"
                            data-stage_id="{{ $item->stage_id }}" data-report_card="{{ $item->report_card }}"
                            data-cost="{{ $item->annual_installment }}" data-id="{{ $item->id }}" data-toggle="modal"
                            style="color: white"> تعديل </a>
                        @endcan
                        @can('delete_class')
                        <a href=".deleteClassModal" class="delete2 btn btn-warning text-light " style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;
                      margin-right: 10px" data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-toggle="modal">
                            {{-- <i class="fa fa-trash" style="font-size: 30px;color: #af686e"></i> --}}
                            حذف
                        </a>
                        @endcan
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
            <div class="col-md-12">
                {{ $classes->links() }}
            </div>
        </div>
    </div>


</div>
{{-- </div> --}}





<div class="modal fade createClassModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="" action="{{ route('class_store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">اضافة صف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align:right">
                        <label>اسم الصف بالعربية</label>
                        <input type="text" name="class_name" class="form-control" value="" style="direction: rtl"
                            placeholder="مثال :أول" maxlength="20" required>
                    </div>

                    <div class="form-group" style="text-align:right">
                        <label>اسم الصف بالانكليزية</label>
                        <input type="text" name="class_name_en" class="form-control" value=""
                            placeholder="example :first" maxlength="20" required>
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> المرحلة الدراسية </label>

                        <select name="stage_id" id="" class="form-control lesson_id"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="" hidden>حدد المرحلة الدراسية </option>
                            @foreach($stages as $stage)
                            <option value="{{$stage->id}}"> {{ $stage->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> تصميم الجلاء </label>

                        <select name="report_card" id="" class="form-control lesson_id"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="" hidden>حدد تصميم الجلاء </option>
                            <option value="1"> صف 1-4</option>
                            <option value="2">صف 5-6</option>
                            <option value="3"> صف 7-8</option>
                            <option value="4"> صف 9</option>
                            <option value="5"> صف 10-11</option>
                            <option value="6"> صف 12</option>


                        </select>
                    </div>


                    <div class="form-group" style="text-align:right">
                        <label>المبلغ</label>
                        <input type="number" name="annual_installment" class="form-control" value=""
                            style="direction: rtl" placeholder="" required>
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label>الصورة</label>

                        <input type="file" name="image" onchange="loadFile(event)" id="input_image11"
                            class="input_image form-control" required>
                        <label class="custom-file-label" for="customFileLang">Select file</label>

                        <span class="close-btn del_img" title="الغاء" id="del_img"
                            style="display: none; font-weight:bold">&times;</span>
                        <img id="output" style=" display: none" src="" class="output" width="200px" alt="">
                    </div>

                </div>
                <div class="modal-footer">
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
            <form id="form_update" method="POST" action="{{ route('class_update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="class_id" id="class_id">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل الصف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align:right">
                        <label>اسم الصف بالعربية</label>
                        <input type="text" name="class_name" class="form-control" value="" style="direction: rtl"
                            id="name" placeholder="مثال :أول" maxlength="20">
                    </div>

                    <div class="form-group" style="text-align:right">
                        <label>اسم الصف بالانكليزية</label>
                        <input type="text" name="class_name_en" id="name_en" class="form-control" value=""
                            placeholder="example :first" maxlength="20" required>
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> المرحلة الدراسية </label>

                        <select name="stage_id" id="stage_id" class="form-control stage_id"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="" hidden>حدد المرحلة الدراسية </option>
                            @foreach($stages as $stage)
                            <option value="{{$stage->id}}"> {{ $stage->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group" style="text-align:right">
                        <label> تصميم الجلاء </label>

                        <select name="report_card" id="report_card" class="form-control "
                            style="min-height: 36px;direction: rtl" required>
                            <option value="" hidden>حدد تصميم الجلاء </option>
                            <option value="1"> صف 1-4</option>
                            <option value="2">صف 5-6</option>
                            <option value="3"> صف 7-8</option>
                            <option value="4"> صف 9</option>
                            <option value="5"> صف 10-11</option>
                            <option value="6"> صف 12</option>


                        </select>
                    </div>

                    <div class="form-group" style="text-align:right">
                        <label>المبلغ</label>
                        <input type="number" name="annual_installment" id="cost" class="form-control" value=""
                            style="direction: rtl" placeholder="" required>
                    </div>



                    <div class="form-group" style="text-align:right">
                        <label>الصورة الأولى</label>
                        <br>
                        <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                        <img src="" width="50px" height="50px" class="del_edit_img" id="image" alt="Not found">
                        <span class="close-btn del_icon" title="الغاء" id=""
                            style="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image" onchange="loadFile_edit(event)" class="form-control input_image"
                            id="input_edit_image1" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                        <span class="close-btn del_img" title="الغاء" id=""
                            style="display: none; font-weight:bold">&times;</span>
                        <img id="output" class="output" style=" display: none" src="" width="200px" alt="">

                    </div>



                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                    <button class="btn btn-primary">Save</button>
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
            <form id="form_delete" action="{{ route('class_delete') }}" method="POST" autocomplete="off">

                @csrf
                <input type="hidden" name="class_id_delete" id="class_id_delete" required>

                <div class="modal-header">
                    <h4 class="modal-title" style="color: #f00">حذف الصف</h4>
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

<script>
    $('.alert-success').hide(5000);


    $(document).ready(function () {

        $('.delete').on('click', function () {

            var id = $(this).data('id');
            var url = "{{URL::to('SMARMANger/admin/students')}}";
            $('#form_delete').attr("action", url);

        });



        $('.edit').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var name_en = $(this).data('name_en');
            var image = $(this).data('image');
            var cost = $(this).data('cost');
            var stage_id = $(this).data('stage_id');
            var report_card = $(this).data('report_card');
            $('#class_id').val(id);
            $('#name').val(name);
            $('#name_en').val(name_en);
            $('#image').attr('src', `{{asset('storage/${image}')}}`);
            $('#cost').val(cost);
            $('#stage_id').val(stage_id);
            $('#report_card').val(report_card);




        });
        $(document).on('click', '.delete2', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');

            $('#name_delete').val(name);
            $('#class_id_delete').val(id);
        });


    });
</script>

<script>
    var loadFile = function (event) {
        var id = event.target.id;
        var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function () {

            output.setAttribute('style', 'display:inline');
            del_img.setAttribute('style',
                'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };

    };


    var loadFile_edit = function (event) {
        var id = event.target.id;
        var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        input_image.previousElementSibling.setAttribute('style', 'display:none');
        input_image.previousElementSibling.previousElementSibling.setAttribute('style', 'display:none');

        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function () {

            output.setAttribute('style', 'display:inline');
            del_img.setAttribute('style',
                'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };

    };


    $(document).on('click', '.del_img', function () {
        $(this).nextAll('.output').attr('style', 'display:none;');
        $(this).prevAll('.input_image:first').val('');
        $(this).hide();

    });

    $(document).on('click', '.del_icon', function () {
        $(this).prevAll('.del:first').attr('disabled', false);
        $(this).prevAll('.del_edit_img:first').hide();
        $(this).hide();

    });
</script>

@endsection
