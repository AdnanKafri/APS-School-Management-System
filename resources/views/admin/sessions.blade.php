@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
    }
    .modal-header{
        direction: rtl;
    }
    .select2-container{
        width: 100% !important;
    }

</style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الحصص</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 30px;">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h1 class="mb-0" style="text-align: center;color: #001586"> جدول الصفوف</h1>
            </div>

    <div class="table-responsive">
 @can('create_workschedule')
    <!--<a  class=" btn btn-success" data-toggle="modal" data-target="#store_session" style="color: white;margin: 5px;background: #6ABAA3;border-color: #6ABAA3;"-->
    <!--data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء حصة جديد</i></a>-->
   @endcan

              <table class="table align-items-center table-flush">
                <thead class="">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">  الاسم بالعربي </th>

                    <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزي </th>

                    <th scope="col" class="sort" data-sort="budget"> </th>
                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($class as $item)

               <tr>
                    <td class="budget" style="font-weight:bold;font-size:15px">
                        {{$item->name}}
                    </td>

                    <td class="budget"style="font-weight:bold;font-size:15px">
                        {{$item->name_en}}
                    </td>

                    <td class="text-right">
                        <a class="btn btn-success " style="margin-left: 10px;color: #fff;" href="{{ route('session_class',$item->id) }}" >الحصص</a>
                    </td>
                </tr>
               @endforeach


                </tbody>
              </table>

            </div>



    </div>


            <div class="modal fade" id="store_session">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('session_store1') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="class_id" id="class_id">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة حصة</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الحصة</label>
                                    <input type="text" name="session_name" class="form-control" value="" style="direction: rtl"  maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>بداية الحصة</label>
                                    <input type="time" name="start_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>نهاية الحصة</label>
                                    <input type="time" name="end_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>


                                <div class="form-group" style="text-align:right">
                                    <label>  الشعب </label>
                                    <select name="room[]" class="w-100 js-example-basic-multiple"  multiple="multiple">
                                        @foreach ($room as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group" style="text-align:right">
                                    <label>النوع</label>
                                    <select name="type" style="direction: rtl" class="form-control" required>
                                        <option value="1">حصة درسية</option>
                                        <option value="2">استراحة</option>
                                    </select>
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


            <div class="modal fade" id="edit_session">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('session_update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden name="id" id="edit_id">
                            <input type="hidden" name="class_id" id="class_id">
                            <div class="modal-header">
                                <h4 class="modal-title">تعديل الحصة</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الحصة</label>
                                    <input type="text" name="session_name" class="form-control" value="" style="direction: rtl" id="session_name" maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>بداية الحصة</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control" value="" style="direction: rtl" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>نهاية الحصة</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control" value="" style="direction: rtl" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>النوع</label>
                                    <select name="type" id="edit_type" style="direction: rtl" class="form-control" required>
                                        <option value="1">حصة درسية</option>
                                        <option value="2">استراحة</option>
                                    </select>
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

            <div class="modal fade" id="delete_session">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('session_delete') }}" >
                            @csrf
                            <input type="text" hidden name="id" id="delete_id">

                            <div class="modal-header">
                                <h4 class="modal-title">حذف الحصة</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الحصة</label>
                                    <input type="text" name="session_name_delete" class="form-control" style="direction: rtl" id="session_name_delete"  readonly>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-primary " style="color:#fff !important" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-danger">تأكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>






<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.alert-success').hide(5000);


$(document).ready(function () {

    $('.js-example-basic-multiple').select2();

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);


});
$(document).on('click',".edit_see", function () {
    var data = $(this).data('data');
    $('#end_time').val(data.end_time);
    $('#edit_type').val(data.type);
    $('#edit_id').val(data.id);
    $('#start_time').val(data.start_time);
    $('#session_name').val(data.name);
});
$(document).on('click',".delete_session", function () {
    var data = $(this).data('data');

    $('#delete_id').val(data.id);

    $('#session_name_delete').val(data.name);
});



$('.edit').on('click', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');
    var name_en=$(this).data('name_en');
var image=$(this).data('image');
    var cost=$(this).data('cost');
    $('#class_id').val(id);
    $('#name').val(name);
    $('#name_en').val(name_en);
    $('#image').attr('src',`{{asset('storage/${image}')}}`);
    $('#cost').val(cost);




});


});
</script>

<script>


    var loadFile = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


    var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });


  </script>

@endsection
