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
        <a class="breadcrumbs__item is-active">سلايدر </a>
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

        <div class="alert alert-success alert-dismissible" id="success2" role="alert"
            style="text-align: right;  display: none; font-size: 30px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            {{ session()->get('success') }}
        </div>


        <div class="card-header border-0">
            <h3 class="mb-0">جدول السلايدر</h3>
        </div>

        <div class="table-responsive">
            <a href=".createNewsModal" class=" btn btn-success" data-toggle="modal" data-id=""><i class="material-icons"
                    data-toggle="tooltip">إنشاء سلايدر جديد</i></a>


            <table class="table align-items-center table-bordered" id="table_xx" style="color: black; text-align:center">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th style="text-align: center;
                    color: black;"> العنوان بالعربي </th>
                        <th style="text-align: center;
            color: black;"> العنوان بالانكليزي </th>
                        <th style="text-align: center;
                    color: black;"> المحتوى بالعربي </th>
                        <th style="text-align: center;
            color: black;"> المحتوى بالانكليزي </th>
                        <th style="text-align: center;
                    color: black;"> االكلمة المفتاحية بالعربي </th>
                        <th style="text-align: center;
            color: black;"> الكملة المفتاحية بالانكليزي </th>


                        <th style="text-align: center;
                    color: black;"> صورة </th>

                        <th style="text-align: center;
                    color: black;"> حذف </th>

                        <th style="text-align: center;
                    color: black;"> تعديل </th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($sliders as $item)
                        <tr id="news_{{ $item->id }}">



                            <td style="vertical-align: initial;">
                                {{ $item->header_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->header_en }}


                            </td>
                            <td style="vertical-align: initial;">
                                {{ $item->content_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->content_en }}


                            </td>
                            <td style="vertical-align: initial;">
                                {{ $item->key_word_ar }}



                            </td>

                            <td style="vertical-align: initial;">
                                {{ $item->key_word_en }}


                            </td>


                            <td>
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" style="width: 150px;">
                                @endif

                            </td>


                            <td class="delete" style="vertical-align: initial;"> <a
                                    class="delete_news one  btn-sm btn-danger" data-id="{{ $item->id }}"
                                    href=".active_result" data-toggle="modal"> حذف
                                </a>

                            </td>
                            <td style="vertical-align: initial;">

                                <a class="edit_news btn btn-success btn-sm" data-header_ar="{{ $item->header_ar }}"
                                    data-header_en="{{ $item->header_en }}" data-content_ar	="{{ $item->content_ar }}"
                                    data-content_en="{{ $item->content_en }}" data-key_word_ar="{{ $item->key_word_ar }}"
                                    data-key_word_en="{{ $item->key_word_en }}" data-image="{{ $item->image }}"
                                    data-id="{{ $item->id }}" href=".editNewsModal" data-toggle="modal">تعديل</i>
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
                    {{ $sliders->links() }}
                </div>
            </div>
        </div>


    </div>
    {{-- </div> --}}



    <div class="modal fade editNewsModal"style="text-align: end;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_update" action="{{ route('slider.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">تعديل السلايدر </h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <input type="hidden" name="id" id="news_id" value="">

                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" id="header_ar" name="header_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>العنوان بالإنكليزية</label>
                            <input type="text" id="header_en" name="header_en" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>المحتوى بالعربية</label>
                            <input type="text" id="content_ar" name="content_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>المحتوى بالإنكليزية</label>
                            <input type="text" id="content_en" name="content_en" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>الكلمة المفتاحية بالعربية</label>
                            <input type="text" id="key_word_ar" name="key_word_ar" class="form-control"
                                value="" maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>الكلمة المفتاحية بالإنكليزية</label>
                            <input type="text" id="key_word_en" name="key_word_en" class="form-control"
                                value="" maxlength="100" style="direction: rtl" placeholder="">
                        </div>

                        {{-- ----------------- --}}


                        <div class="form-group">
                            <label>الصورة </label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            <img src="" width="50px" height="50px" class="del_edit_img" id="image1"
                                alt="Not found">
                            <span class="close-btn del_icon" title="الغاء" id=""
                                style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                            <input type="file" name="image" onchange="loadFile_edit(event)"
                                title=" size:	1350 × 500 px" class="form-control input_image" id="input_edit_image1"
                                lang="en">
                            <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src="" width="200px"
                                alt="">
                        </div>

                        {{-- ================================= --}}

                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                        <button class="btn btn-info">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade createNewsModal" style="text-align: end;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_update" action="{{ route('slider.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">إنشاء سلايدر جديد</h4>
                    </div>
                    <div class="modal-body" style="direction:ltr">
                        <div class="form-group">
                            <label>العنوان بالعربية</label>
                            <input type="text" name="header_ar" class="form-control" value="" maxlength="100"
                                style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>العنوان بالانكليزية</label>
                            <input type="text" name="header_en" class="form-control" value="" maxlength="100"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>المحتوى بالعربية</label>
                            <input type="text" name="content_ar" class="form-control" value="" maxlength="100"
                                style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>المحتوى بالانكليزية</label>
                            <input type="text" name="content_en" class="form-control" value="" maxlength="100"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>الكلمة المفتاحية بالعربية</label>
                            <input type="text" name="key_word_ar" class="form-control" value=""
                                maxlength="100" style="direction: rtl" placeholder="" required>
                        </div>

                        <div class="form-group">
                            <label>الكلمة المفتاحية بالانكليزية</label>
                            <input type="text" name="key_word_en" class="form-control" value=""
                                maxlength="100" placeholder="" required>
                        </div>





                        <div class="form-group">
                            <label>الصورة</label>
                            <br>
                            <input type="file" name="image" onchange="loadFile(event)" id="input_image1"
                                title=" size:	1350 × 500 px" class="input_image form-control" required>
                            <label class="custom-file-label" for="customFileLang">Select file</label>

                            <span class="close-btn del_img" title="الغاء" id="del_img"
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output" width="200px"
                                alt="">


                        </div>

                        {{-- ================================= --}}


                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-info">حفظ</button>
                    </div>

                </form>
            </div>
        </div>
    </div>







    <div class="col-md-4" class="delete_modal">
        {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
        <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog"
            aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-danger">
                    <form id="form_delete" method="POST">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                            <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="close">×</span>
                            </a>
                        </div>

                        <div class="modal-body">

                            <div class="py-3 text-center">
                                <i class="ni ni-bell-55 ni-3x"></i>
                                <h4 class="heading mt-4">You should read this!</h4>
                                <p>Are you sure you want to delete the item ?</p>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok,
                                Got it</a>
                            <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <script>
        $('.alert-success').hide(5000);
        $(document).ready(function() {
            $('#table_xx').DataTable({});
        })
        $(document).on('click', '.one', function() {

            var id = $(this).data('id');
            $('.delete_event').attr('href', `{{ route('admin.news.delete') }}`);

            $('.delete_event').data('id', id);

        });

        $(document).on('click', '.delete_event', function(e) {
            var id = $(this).data('id');
            e.preventDefault();
            $.ajax({

                type: 'post',
                url: "{{ route('slider.delete') }}",
                enctype: 'multipart/form-data',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,

                },

                success: function(data) {

                    $(`#news_${id}`).remove();
                    $('#success2').show();
                    document.getElementById('success2').innerText = "Deleted Successfully !";
                    $('.close').click();

                    $('#success2').hide(5000);

                },
                error: function(xhr) {

                }

            });


        });



        $(document).on('click', '.edit_news', function(e) {
            var id = $(this).data('id');
            e.preventDefault();

            var image = $(this).data('image');



            $('#news_id').val(id);
            $('#header_en').val($(this).data('header_en'));
            $('#header_ar').val($(this).data('header_ar'));
            $('#content_en').val($(this).data('content_en'));
            $('#content_ar').val($(this).data('content_ar'));
            $('#key_word_en').val($(this).data('key_word_en'));
            $('#key_word_ar').val($(this).data('key_word_ar'));


            if (image1 != "") {
                $('#image1').attr('src', `{{ asset('storage/${image}') }}`);
            }



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


    <script>
        var loadFile3 = function(event) {
            var output = document.getElementById('output3');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                document.getElementById('output3').setAttribute('style', 'display:inline');
                document.getElementById('del_img3').setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $(document).on('click', '#del_img3', function() {

            $('#output3').attr('style', 'display:none;');
            $('#input_image3').val('');
            $(this).hide();


        });
    </script>



    <script>
        var loadFile4 = function(event) {
            var output = document.getElementById('output4');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                document.getElementById('output4').setAttribute('style', 'display:inline');
                document.getElementById('del_img4').setAttribute('style',
                    'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $(document).on('click', '#del_img4', function() {

            $('#output4').attr('style', 'display:none;');
            $('#input_image4').val('');
            $(this).hide();


        });
    </script>
@endsection
