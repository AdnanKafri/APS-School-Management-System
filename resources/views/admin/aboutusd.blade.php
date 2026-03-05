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

        .form-group {
            box-sizing: border-box;
        }
    </style>
@endsection
@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">من نحن </a>
        <a href="{{ route('websitehome') }}" class="breadcrumbs__item ">الصفحة الاساسية</a>
        <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection
@section('content')
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
            <h3 class="mb-0">جدول من نحن</h3>
        </div>

        <div class="table-responsive">

            <!--<a href=".createClassModal" class=" btn btn-success" data-toggle="modal"-->
            <!--data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء </i></a>-->


            <table class="table align-items-center table-bordered" id="table_xx" style="color: black; text-align:center">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th style="text-align: center;
    color: black;"> مرحبا بالعربي </th>
                        <th style="text-align: center;
    color: black;"> مرحبا بالانكليزي </th>

                        <th style="text-align: center;
    color: black;"> العنوان بالعربي </th>

                        <th style="text-align: center;
    color: black;"> العنوان بالانكليزي </th>
                        <th style="text-align: center;
    color: black;"> الوصف بالعربي </th>
                        <th style="text-align: center;
    color: black;"> الوصف بالانكليزي </th>
                        <th style="text-align: center;
    color: black;"> المحتوى بالعربي </th>
                        <th style="text-align: center;
    color: black;"> المحتوى بالانكليزي </th>
                        <th style="text-align: center;
                       color: black;"> الصورة </th>

                        <th style="text-align: center;
    color: black;"> تعديل </th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($bout as $item)
                        <tr>



                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;">   {{ $item->welcome_ar }}</textarea>
                            </td>

                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;">  {{ $item->welcome_en }}</textarea>
                            </td>

                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;">  {{ $item->title_ar }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;">  {{ $item->title_en }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;"> {{ $item->description_ar }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;"> {{ $item->description_en }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;">  {{ $item->content_ar }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;"> {{ $item->content_en }}</textarea>

                            </td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" style="width: 150px;">
                                @endif

                            </td>








                            <td class="delete"><a style="background-color: white; color: rgb(117, 115, 115);"
                                    class="btn delete11" href=".createClassModal" class=" btn btn-success"
                                    data-toggle="modal" data-id="" data-toggle="modal"><span
                                        class="btn btn-info">تعديل</span> </a>
                                <div class="modal fade createClassModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="" action="{{ route('about_store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input hidden name="id" value="{{ $item->id }}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تعديل </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group" style="text-align:right">
                                                        <label> مرحبا بالعربي </label>
                                                        <textarea type="text" name="welcome_ar" class="form-control" value="" required>{{ $item->welcome_ar }}</textarea>
                                                    </div>

                                                    <div class="form-group" style="text-align:right">
                                                        <label> مرحبا بالانكليزي </label>
                                                        <textarea type="text" name="welcome_en" class="form-control" value="" required>{{ $item->welcome_en }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> العنوان بالعربي </label>
                                                        <textarea type="text" name="title_ar" class="form-control" value="" required>{{ $item->title_ar }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> العنوان بالانكليزي </label>
                                                        <textarea type="text" name="title_en" class="form-control" value="" required>{{ $item->title_en }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> الوصف بالعربي </label>
                                                        <textarea type="text" name="description_ar" class="form-control" value="" required>{{ $item->description_ar }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> الوصف بالانكليزي </label>
                                                        <textarea type="text" name="description_en" class="form-control" value="" required>{{ $item->description_en }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> المحتوى بالعربي </label>
                                                        <textarea type="text" name="content_ar" class="form-control" value="" required>{{ $item->content_ar }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> المحتوى بالانكليزي </label>
                                                        <textarea type="text" name="content_en" class="form-control" value="" required>{{ $item->content_en }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>الصورة </label>
                                                        <br>
                                                        <input type="hidden" class="del" name="del_img1"
                                                            value="del_img1" disabled="disabled">

                                                        <img src="" width="50px" height="50px"
                                                            class="del_edit_img" id="image1" alt="Not found">
                                                        <span class="close-btn del_icon" title="الغاء" id=""
                                                            style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                                                        <input type="file" name="image"
                                                            onchange="loadFile_edit(event)" title=" size:	1350 × 500 px"
                                                            class="form-control input_image" id="input_edit_image1"
                                                            lang="en">
                                                        <label class="custom-file-label" for="customFileLang">Select
                                                            file</label>


                                                        <span class="close-btn del_img" title="الغاء" id=""
                                                            style="display: none; font-weight:bold">&times;</span>
                                                        <img id="output" class="output" style=" display: none"src=""
                                                            width="200px" alt="">
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
                    {{ $bout->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}

    <div class="modal fade deleteEmployeeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_delete" action="{{ route('delete_advantges') }}" method="POST">
                    @csrf


                    <div class="modal-header">

                        <h4 class="modal-title">Delete element</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input class="delete1" hidden name="id">
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


    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <script>
        $('.alert-success').hide(5000);


        $(document).ready(function() {

            $('.delete11').on('click', function() {
                var id = $(this).data('id');


                $('.delete1').val(id);

            });



            $('.edit').on('click', function() {
                alert('hi');
                var id = $(this).data('id');
                var name = $(this).data('name');
                var name_en = $(this).data('name_en');


                var cost = $(this).data('cost');
                $('#class_id').val(id);
                $('#name').val(name);
                $('#name_en').val(name_en);
                $('#image').attr('src', `{{ asset('storage/${image}') }}`);
                $('#cost').val(cost);




            });


        });
    </script>

    <script>
        $(document).ready(function() {
            $('#table_xx').DataTable({});
        })

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
