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
    .form-group {
        box-sizing: border-box;
    }
</style>

@endsection
     @section('breadcrumbs')

<nav class="breadcrumbs">

    <a  class="breadcrumbs__item is-active">  تفاصيل اكثر  </a>
      <a  href="{{ route('about_us1') }}" class="breadcrumbs__item ">من نحن </a>
    <a  href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:center;margin: 20px;">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h3 class="mb-0">جدول  تفاصيل اخرى</h3>
            </div>

    <div class="table-responsive">
{{--
    <a href=".createClassModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء تفصيل جديدة</i></a> --}}


    <table class="table align-items-center table-bordered" id="table_xx"  style="color: black; text-align:center">
                <thead class="" style="color: black ; text-align:center">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th > العنوان  الاساسي  بالعربي </th>
            <th > العنوان الاساسي  بالانكليزي  </th>

                    <th > النص الاول بالعربي </th>

                    <th > النص  الاول بالانكليزي</th>
                    <th > العنوان   الثاني  بالعربي </th>
                    <th > العنوان الثاني  بالانكليزي  </th>
                    <th > العنوان  الفرعي  بالعربي </th>
                    <th > العنوان الفرعي  بالانكليزي  </th>
                    <th > النص  الثاني  بالعربي </th>

                    <th > النص   الثاني  بالانكليزي</th>
                    <th >   الصورة الاولى  </th>
                    <th >   الصورة  الاولى للسلايد   </th>
                    <th >   الصورة   الثانية للسلايد   </th>
                    <th >   الصورة    الثالثة للسلايد   </th>
                     <th > تعديل </th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($details as $item)

               <tr>



                <td >
                    <textarea readonly cols="20" rows="5" style="border: none;">  {{$item->title_ar}}</textarea>
                  </td>

                  <td >
                    <textarea readonly cols="20" rows="5" style="border: none;"> {{$item->title_en}}</textarea>
                  </td>

                  <td >
                    <textarea readonly cols="50" rows="10" style="border: none;"> {{$item->text_ar}}</textarea>

                  </td>
                  <td >
                    <textarea readonly cols="50" rows="10" style="border: none;"> {{$item->text_en}}</textarea>

                  </td>
                  <td >
                    <textarea readonly cols="20" rows="5" style="border: none;">  {{$item->title1_ar}}</textarea>
                  </td>

                  <td >
                    <textarea readonly cols="20" rows="5" style="border: none;">   {{$item->title1_en}}</textarea>
                  </td>
                  <td >
                    <textarea readonly cols="20" rows="5" style="border: none;">   {{$item->title2_ar}}</textarea>
                  </td>

                  <td >
                    <textarea readonly cols="20" rows="5" style="border: none;">  {{$item->title2_en}}</textarea>
                  </td>

                  <td >
                    <textarea readonly cols="50" rows="10" style="border: none;"> {{$item->text2_ar}}</textarea>

                  </td>
                  <td >
                    <textarea readonly cols="50" rows="10" style="border: none;">   {{$item->text2_en}}</textarea>

                  </td>


                  <td>
                    <img src="{{ asset('storage/'.$item->img) }}" style="width: 150px;">

                </td>

                    <td>
                        <img src="{{ asset('storage/'.$item->img_s1) }}" style="width: 150px;">

                    </td>
                    <td>
                        <img src="{{ asset('storage/'.$item->img_s2) }}" style="width: 150px;">

                    </td>
                    <td>
                        <img src="{{ asset('storage/'.$item->img_s3) }}" style="width: 150px;">

                    </td>


      <td class="delete"><a style="background-color: white; color: rgb(117, 115, 115);"
    class="btn delete11" href=".createClassModal" data-id="{{$item->id}}"  data-toggle="modal">تعديل    </a>
    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('more_details_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">تعديل  </h4>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="text" hidden name="id" id="id" value="{{ $item->id }}" >
                        <div class="form-group" style="text-align:right">
                            <label>عنوان  الاساسي  بالعربي  </label>
                            <input type="text" name="title_ar" class="form-control"
                                value="{{$item->title_ar}}" style="direction: rtl"
                                  required>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>عنوان   الاساسي بالانكليزي  </label>
                            <input type="text" name="title_en" class="form-control"
                                value="{{$item->title_en}}"
                                  required>
                        </div>
                         <div class="form-group" style="text-align:right">
                            <label>نص  الاول   بالعربي  </label>
                            <textarea type="text" name="text_ar" class="form-control"
                                value="{{$item->text_ar}}"
                                required>{{$item->text_ar}}</textarea>
                        </div>
                         <div class="form-group" style="text-align:right">
                            <label>نص  الاول  بانكليزي  </label>
                            <textarea type="text" name="text_en" class="form-control"
                                value="{{$item->text_en}}"
                                required>{{$item->text_en}}</textarea>
                        </div>
                           <div class="form-group" style="text-align:right">
                            <label> الصورة الاولى  </label>
                            <input type="file" id="upload_file"  src="{{ asset('storage/'.$item->img) }}" value="{{ $item->img }}" name="img"
                                                   >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>عنوان  الثاني  بالعربي  </label>
                            <input type="text" name="title1_ar" class="form-control"
                                value="{{$item->title1_ar}}" style="direction: rtl"
                                  required>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>عنوان   الثاني بالانكليزي  </label>
                            <input type="text" name="title1_en" class="form-control"
                                value="{{$item->title1_en}}"
                                  required>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>عنوان  الفرعي  بالعربي  </label>
                            <input type="text" name="title2_ar" class="form-control"
                                value="{{$item->title2_ar}}" style="direction: rtl"
                                  required>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>عنوان   الفرعي بالانكليزي  </label>
                            <input type="text" name="title2_en" class="form-control"
                                value="{{$item->title2_en}}"
                                  required>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>نص   الثاني   بالعربي  </label>
                            <textarea type="text" name="text2_ar" class="form-control"
                                value="{{$item->text2_ar}}"
                                required>{{$item->text2_ar}}</textarea>
                        </div>
                         <div class="form-group" style="text-align:right">
                            <label>نص  الثاني  بانكليزي  </label>
                            <textarea type="text" name="text2_en" class="form-control"
                                value="{{$item->text2_en}}"
                                required>{{$item->text2_en}}</textarea>
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>  الصورة الاولى للسلايد </label>
                            <input type="file" id="upload_file" name="img_s1"
                                                   >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> الصورة الثانية للسلايد  </label>
                            <input type="file" id="upload_file" name="img_s2"
                                                   >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> الصورة  الثالثة للسلايد  </label>
                            <input type="file" id="upload_file" name="img_s3"
                                                   >
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
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" >
                            {{ $details->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}



            <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" action="{{route('delete_more_details')}}" method="POST">
                                        @csrf


                                        <div class="modal-header">

                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                             <input class="delete1"  hidden   name="id" >
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.alert-success').hide(5000);


$(document).ready(function () {
$('#table_xx').DataTable({});
$('.delete11').on('click', function () {
    var id = $(this).data('id');

    $('.delete1').val(id);





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
