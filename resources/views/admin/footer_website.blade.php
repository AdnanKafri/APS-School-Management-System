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
    </style>
@endsection
@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">معلومات التواصل    </a>
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
            <h3 class="mb-0">جدول اتصل بنا </h3>
        </div>

        <div class="table-responsive">

            <!--<a href=".createClassModal" class=" btn btn-success" data-toggle="modal"-->
            <!--data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء </i></a>-->


            <table class="table align-items-center table-bordered" id="table_xx" style="color: black; text-align:center">
                <thead class="">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th style="text-align: center;
    color: black;">
                            العنوان الصفحة بالعربي </th>
                        <th style="text-align: center;
    color: black;">
                            العنوان الصفحة بالانكليزي </th>
                        <th style="text-align: center;
    color: black;">
                            المحتوى بالعربي </th>
                        <th style="text-align: center;
    color: black;">
                            المحتوى بالانكليزي </th>


                        <th style="text-align: center;
    color: black;">
                            العنوان بالعربي </th>
                        <th style="text-align: center;
    color: black;">
                            العنوان بالانكليزي </th>

                        <th style="text-align: center;
    color: black;">
                            رقم الهاتف </th>

                        <th style="text-align: center;
    color: black;">
                            الايميل </th>
                        <th style="text-align: center;
    color: black;">
                            facebook </th>
                        <th style="text-align: center;
    color: black;">
                            twitter </th>
                        <th style="text-align: center;
    color: black;">
                            linkedin</th>
                        <th style="text-align: center;
    color: black;">
                            instgram </th>
                        <th style="text-align: center;
    color: black;">
                            WhatsApp </th>

                        <th style="text-align: center;
    color: black;">
                            تعديل </th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($footer as $item)
                        <tr>

                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->title_ar }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->title_en }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;"> {{ $item->content_ar }}</textarea>

                            </td>
                            <td>
                                <textarea readonly cols="50" rows="10" style="border: none;"> {{ $item->content_en }}</textarea>


                            </td>

                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->address_ar }}</textarea>

                            </td>

                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->address_en }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->phone }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->email }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;">{{ $item->facebook }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->twitter }} </textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->linkedin }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;">  {{ $item->instgram }}</textarea>


                            </td>
                            <td>
                                <textarea readonly cols="20" rows="5" style="border: none;"> {{ $item->whatsApp }}</textarea>


                            </td>







                            <td class="delete"><a style="background-color: white; color: rgb(117, 115, 115);"
                                    class="delete11 btn btn-info" href=".createClassModal" 
                                    data-toggle="modal" data-id="" data-toggle="modal">تعديل </a>
                                <div class="modal fade createClassModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="" action="{{ route('footer_website.update') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input hidden name="id" value="{{ $item->id }}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تعديل </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group" style="text-align:right">
                                                        <label> عنوان الصفحة بالعربي </label>
                                                        <input type="text" name="title_ar" class="form-control"
                                                            value="{{ $item->title_ar }}" required>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> عنوان الصفحة بالانكليزي </label>
                                                        <input type="text" name="title_en" class="form-control"
                                                            value="{{ $item->title_en }}" required>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> محتوى الصفحة بالعربي </label>
                                                        <textarea type="text" name="content_ar" class="form-control" value="" required>{{ $item->content_ar }}</textarea>

                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> محتوى الصفحة بالانكليزي </label>
                                                        <textarea type="text" name="content_en" class="form-control" value="" required>{{ $item->content_en }}</textarea>

                                                    </div>





                                                    <div class="form-group" style="text-align:right">
                                                        <label> العنوان بالعربي </label>
                                                        <textarea type="text" name="address_ar" class="form-control" value="" required>{{ $item->address_ar }}</textarea>
                                                    </div>

                                                    <div class="form-group" style="text-align:right">
                                                        <label> العنوان بالانكليزي </label>
                                                        <textarea type="text" name="address_en" class="form-control" value="" required>{{ $item->address_en }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> الهاتف </label>
                                                        <textarea type="text" name="phone" class="form-control" value="" required>{{ $item->phone }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> رقم الوتس </label>
                                                        <textarea type="text" name="whatsApp" class="form-control" value="" required>{{ $item->whatsApp }}</textarea>
                                                    </div>

                                                    <div class="form-group" style="text-align:right">
                                                        <label> الايميل </label>
                                                        <textarea type="text" name="email" class="form-control" value="" required>{{ $item->email }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> facebook </label>
                                                        <textarea type="text" name="facebook" class="form-control" value="" required>{{ $item->facebook }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> twitter </label>
                                                        <textarea type="text" name="twitter" class="form-control" value="" required>{{ $item->twitter }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> linkedin </label>
                                                        <textarea type="text" name="linkedin" class="form-control" value="" required>{{ $item->linkedin }}</textarea>
                                                    </div>
                                                    <div class="form-group" style="text-align:right">
                                                        <label> instgram </label>
                                                        <textarea type="text" name="instgram" class="form-control" value="" required>{{ $item->instgram }}</textarea>
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
                    {{ $footer->links() }}
                </div>
            </div>
        </div>


    </div>





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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>


    <script>
        $('.alert-success').hide(5000);


        $(document).ready(function() {
            $('#table_xx').DataTable({});

            $('.plus').on('click', function() {
                $('.rr').append(`<input type="text"  name="phone[]" class="form-control inp"
                                        value=""
                                        >`);

            })
            $('.minus').on('click', function() {
                $('.inp').last().remove();

            })

            $('.delete11').on('click', function() {
                var id = $(this).data('id');

                $('.delete1').val(id);





            });



            $('.edit').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var name_en = $(this).data('name_en');
                var image = $(this).data('image');
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
