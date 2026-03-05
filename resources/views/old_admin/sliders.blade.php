@extends('admin.layouts.app')
<head>



    <style>
    .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }
    </style>
</head>
@section('search')


@endsection

@section('content')




<div class="col"  style="direction:rtl;text-align:right">
    <div class="card">
            <!-- Card header -->
<!--            @if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->


<!--<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->

            <div class="card-header border-0">
              <h3 class="mb-0">جدول السلايدر</h3>

            </div>
<div class="table-responsive">
    <a href=".createSliderModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">اضافة سلايد</i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->

                    <th scope="col" class="sort" data-sort="completion">العنوان بالعربية</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان بالانكليزية</th>

                    <th scope="col" class="sort" data-sort="completion">المحتوى بالعربية</th>
                    <th scope="col" class="sort" data-sort="completion">المحتوى بالإنكليزية</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة</th>

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


  @foreach ($sliders as $item)
  <tr id="slider_{{$item->id}}">

      <!--<td>{{$item->id}}</td>-->
            <td>{{$item->header_ar}}</td>
      <td>{{$item->header_en}}</td>
      <td>{{$item->content_ar}}</td>
      <td>{{$item->content_en}}</td>
  <td><img src="{{ asset('storage/'.$item->image) }}" width="100px" height="100px" alt=""></td>

  <td>


        <div class="text-center">

                    <a  data-id="{{ $item->id }}" class="one btn btn-danger btn-sm confirm1"
                    href=".active_result" data-toggle="modal">
                        حذف
                    </a>
    </div>

      <a href=".editSliderModal" class=" btn btn-success btn-sm edit_slider" data-toggle="modal" id=""
      data-id="{{ $item->id }}"
        data-header_ar="{{ $item->header_ar }}"
        data-header_en="{{ $item->header_en }}"
        data-content_ar="{{ $item->content_ar }}"
        data-content_en="{{ $item->content_en }}"
        data-image={{ $item->image }}

      ><i class="material-icons" data-toggle="tooltip">تعديل</i></a>
  </td>
</tr>

  @endforeach





                </tbody>

              </table>

            </div>


    </div>
</div>





<div class="modal fade createSliderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">اضافة سلايد جديد</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">



                    <div class="form-group">
                        <label>العنوان بالعربية</label>
                        <input type="text" name="header_ar" style="direction: rtl" class="form-control b"
                            value="" maxlength="100"
                            placeholder="اكتب العنوان بالعربي" >
                    </div>



                    <div class="form-group">
                        <label>العنوان بالإنكليزية</label>
                        <input type="text" name="header_en" style="" class="form-control b"
                            value="" maxlength="100"
                            placeholder="Type header En">
                    </div>

                    <div class="form-group">
                        <label>المحتوى بالعربية</label>
                        <textarea name="content_ar" style="direction: rtl" id="" maxlength="255" cols="30" rows="3"
                         class="form-control b" ></textarea>

                    </div>



                    <div class="form-group">
                        <label>المحتوى بالإنكليزية</label>
                        <textarea name="content_en" id="" maxlength="255" cols="30" rows="3"
                         class="form-control b" ></textarea>

                    </div>




                    <div class="form-group">
                        <div class="custom-file">

                            <input type="file" name="image" onchange="loadFile(event)" required class="custom-file-input" id="image" lang="en">
                            <label class="custom-file-label" for="customFileLang">Select file</label>


                            <div style="position: relative">
                                <span class="close-btn" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                                <img id="output" style=" display: none"src=""  width="200px" alt="">


                            </div>

                        </div>
                    </div>




                    <div>





                    </div>




                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-info" id="save">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal fade editSliderModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  action="{{ route('admin.slider.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="slider_id" id="slider_id">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل السلايد</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">



                    <div class="form-group">
                        <label>العنوان بالعربية</label>
                        <input type="text" name="header_ar" id="header_ar" style="direction: rtl" class="form-control b"
                            value="" maxlength="100"
                            placeholder="اكتب العنوان بالعربي" >
                    </div>



                    <div class="form-group">
                        <label>العنوان بالانكليزية</label>
                        <input type="text" name="header_en" id="header_en" style="" class="form-control b"
                            value="" maxlength="100"
                            placeholder="Type header En">
                    </div>

                    <div class="form-group">
                        <label>المحتوى بالعربية</label>
                        <textarea name="content_ar" style="direction: rtl" id="content_ar" maxlength="255" cols="30" rows="3"
                         class="form-control b"></textarea>

                    </div>



                    <div class="form-group">
                        <label>المحتوى بالإنكليزية</label>
                        <textarea name="content_en" id="content_en" maxlength="255" cols="30" rows="3"
                         class="form-control b"></textarea>

                    </div>




                    <div class="form-group">



                                     <img src="" width="50px" height="50px" class="del_edit_img" id="old_img" alt="Not found" >
                        <span class="close-btn " title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld"></span>


                        <input type="file" name="image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">



                    </div>





                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-info" id="save">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="col-md-4" class="delete_modal">
    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
    <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
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
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>

<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>

<script>
$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('admin.slider.delete') }}`);

$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('admin.slider.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#slider_${id}`).remove();

document.getElementById('success2').innerText="Deleted Successfully !";
$('.close').click();


swal({
  title: "حسناً",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

})


});




    $(document).ready(function () {



$(document).on('click' , '.edit_slider' , function () {

$('#slider_id').val($(this).data('id'));
$('#content_ar').val($(this).data('content_ar'));
$('#content_en').val($(this).data('content_en'));
$('#header_ar').val($(this).data('header_ar'));
$('#header_en').val($(this).data('header_en'));
var img= $(this).data('image');
$('#old_img').attr('src',`{{ asset('storage/${img}') }}`);

});
    });
</script>

<script>
    $('.alert-success').hide(5000);


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




    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
document.getElementById('output').setAttribute('style','display:inline');
document.getElementById('del_img').setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

        URL.revokeObjectURL(output.src) // free memory
      }
    };

    $(document).on('click' , '#del_img' , function () {

$('#output').attr('style','display:none;');
$('#image').val('');
$(this).hide();


    });

  </script>

@endsection

